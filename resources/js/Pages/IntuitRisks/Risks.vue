<script setup>
import { onMounted, ref } from "vue";
import RiskAndCategory from "@/Components/Risks/Components/RiskAndCategory.vue";
import Pagination from "@/Components/Pagination.vue";
import DropdownRadio from "@/Components/DropdownRadio.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps(["risks", "categories", "organizations"]);
const filteredRisks = ref(props.risks);
const shownRisks = ref(filteredRisks.value.slice(0, 8));

const page = ref(1);
const maxPage = ref(Math.ceil(filteredRisks.value.length / 8));

const pageRisks = () => {
    const start = (page.value - 1) * 8;
    const end = start + 8;

    shownRisks.value = filteredRisks.value.slice(start, end);
};

const orderRisks = () => {
    filteredRisks.value = filteredRisks.value.sort((a, b) =>
        a.name.localeCompare(b.name)
    );

    pageRisks();
};

const filter = () => {
    if (selectedCategories.value.length > 0) {
        filteredRisks.value = props.risks.filter((risk) =>
            selectedCategories.value.includes(risk.category.id)
        );
    }

    if (selectedOrganizations.value.length > 0) {
        filteredRisks.value = filteredRisks.value.filter((risk) =>
            risk.organization_types.some((org) =>
                selectedOrganizations.value.includes(org.id)
            )
        );

        page.value = 1;
        maxPage.value = Math.ceil(filteredRisks.value.length / 8);

        pageRisks();
    }

    if (
        selectedCategories.value.length === 0 &&
        selectedOrganizations.value.length === 0
    ) {
        filteredRisks.value = props.risks;
    }

    page.value = 1;
    maxPage.value = Math.ceil(filteredRisks.value.length / 8);

    pageRisks();
};

const selectedCategories = ref([]);

const setSelectedCategories = (categoryId) => {
    if (selectedCategories.value.includes(categoryId)) {
        selectedCategories.value = selectedCategories.value.filter(
            (cat) => cat !== categoryId
        );
    } else {
        selectedCategories.value.push(categoryId);
    }

    filter();
};

const selectedOrganizations = ref([]);

const setSelectedOrganizations = (organizationId) => {
    if (selectedOrganizations.value.includes(organizationId)) {
        selectedOrganizations.value = selectedOrganizations.value.filter(
            (org) => org !== organizationId
        );
    } else {
        selectedOrganizations.value.push(organizationId);
    }

    filter();
};

const showModal = ref(false);
const modification = ref(false);
const updateId = ref(null);

const form = useForm({
    name: "",
    desc: "",
    category: {},
    organization_types: [],
});

const manualClose = ref(false);

const updateRisk = (risk) => {
    form.name = risk.name;
    form.desc = risk.description;
    form.category = risk.category;
    form.organization_types = risk.organization_types.map((org) => org.id);

    updateId.value = risk.id;

    showModal.value = true;
    modification.value = true;
};

const submit = () => {
    if (modification.value) {
        form.patch(`/intuit-risks/risks/${updateId.value}`);
    } else {
        form.post("/intuit-risks/risks");
    }

    showModal.value = false;
    form.reset();
};

const updateStatus = (risk) => {
    const statusForm = useForm({
        is_active: risk.is_active,
    });
    statusForm.patch(`/intuit-risks/risks/${risk.id}`);
};

onMounted(() => {
    orderRisks();
});
</script>

<template>
    <Head title="Créateur de risques de base" />

    <AuthenticatedLayout>
        <Modal
            :show="showModal"
            @close="
                showModal = false;
                form.reset();
            "
        >
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    {{ modification ? "Modifier" : "Ajouter" }} un risque
                </h2>
                <div class="mt-4 flex gap-4">
                    <DropdownRadio :manualClose="manualClose" @manualClosed="">
                        <template v-slot:button v-if="form.category.id"
                            ><div
                                class="text-sm text-gray-500 dark:text-white flex items-center gap-2"
                            >
                                <span
                                    class="w-2 h-2 block rounded-full"
                                    :style="`background-color: ${form.category.color}`"
                                ></span>
                                {{ form.category.name }}
                            </div></template
                        >
                        <template v-slot:button v-esle> Catégorie </template>
                        <template v-slot:radio>
                            <li v-for="category in categories">
                                <button
                                    :class="`${
                                        form.category.id == category.id
                                            ? 'bg-white dark:bg-gray-700'
                                            : ''
                                    } text-left px-4 py-2 hover:bg-white dark:hover:bg-gray-700 w-full`"
                                    @click.prevent="
                                        (form.category = category),
                                            (manualClose = true)
                                    "
                                >
                                    <div
                                        class="text-sm text-gray-500 dark:text-white flex items-center gap-2"
                                    >
                                        <span
                                            class="w-2 h-2 block rounded-full"
                                            :style="`background-color: ${category.color}`"
                                        ></span>
                                        {{ category.name }}
                                    </div>
                                </button>
                            </li>
                        </template>
                    </DropdownRadio>
                    <DropdownRadio id="org-sel" @manualClosed="">
                        <template #button> Types d'organisations</template>
                        <template #radio>
                            <li v-for="organization in organizations">
                                <div class="flex items-center">
                                    <input
                                        :id="`checkbox-org-sel-${organization.id}`"
                                        type="checkbox"
                                        :checked="
                                            form.organization_types.includes(
                                                organization.id
                                            )
                                        "
                                        value=""
                                        @change="
                                            form.organization_types.includes(
                                                organization.id
                                            )
                                                ? form.organization_types.splice(
                                                      form.organization_types.indexOf(
                                                          organization.id
                                                      ),
                                                      1
                                                  )
                                                : form.organization_types.push(
                                                      organization.id
                                                  )
                                        "
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                    />
                                    <label
                                        :for="`checkbox-org-sel-${organization.id}`"
                                        class="flex gap-2 items-center ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        ><span
                                            class="block w-2 h-2 rounded-full"
                                            :style="`background-color: ${organization.color}`"
                                        ></span
                                        >{{ organization.name }}</label
                                    >
                                </div>
                            </li>
                        </template>
                    </DropdownRadio>
                </div>
                <div class="mt-4">
                    <InputError :message="form.errors.category" />
                    <InputError :message="form.errors.organization_types" />
                </div>
                <div class="mt-4">
                    <InputLabel for="name">Nom du risque</InputLabel>
                    <TextInput id="name" v-model="form.name" />
                    <InputError :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="description">Description</InputLabel>
                    <textarea
                        id="description"
                        v-model="form.desc"
                        class="block w-full mt-1 border bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:text-white"
                        rows="3"
                    ></textarea>
                    <InputError class="mt-2" :message="form.errors.desc" />
                </div>

                <div class="mt-6 flex justify-end gap-4">
                    <SecondaryButton
                        @click="
                            showModal = false;
                            form.reset();
                        "
                    >
                        Annuler
                    </SecondaryButton>
                    <PrimaryButton
                        @click="submit()"
                        :disabled="
                            !form.name ||
                            !form.category ||
                            !form.desc ||
                            form.organization_types.length === 0
                        "
                        :class="
                            !form.name ||
                            !form.category ||
                            !form.desc ||
                            form.organization_types.length === 0
                                ? 'opacity-25'
                                : ''
                        "
                        >Enregistrer</PrimaryButton
                    >
                </div>
            </div>
        </Modal>
        <div class="flex justify-end">
            <div>
                <DangerButton @click="showModal = true"
                    >Ajouter un risque</DangerButton
                >
            </div>
        </div>
        <div class="mb-4 flex gap-4">
            <DropdownRadio id="cat" @manualClosed="">
                <template #button> Catégories </template>
                <template #radio>
                    <li v-for="category in categories">
                        <div class="flex items-center">
                            <input
                                :id="`checkbox-cat-${category.id}`"
                                type="checkbox"
                                value=""
                                @change="setSelectedCategories(category.id)"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            />
                            <label
                                :for="`checkbox-cat-${category.id}`"
                                class="flex gap-2 items-center ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                ><span
                                    class="block w-2 h-2 rounded-full"
                                    :style="`background-color: ${category.color}`"
                                ></span
                                >{{ category.name }}</label
                            >
                        </div>
                    </li>
                </template>
            </DropdownRadio>

            <DropdownRadio id="org" @manualClosed="">
                <template #button> Types d'organisations</template>
                <template #radio>
                    <li v-for="organization in organizations">
                        <div class="flex items-center">
                            <input
                                :id="`checkbox-org-${organization.id}`"
                                type="checkbox"
                                value=""
                                @change="
                                    setSelectedOrganizations(organization.id)
                                "
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            />
                            <label
                                :for="`checkbox-org-${organization.id}`"
                                class="flex gap-2 items-center ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                ><span
                                    class="block w-2 h-2 rounded-full"
                                    :style="`background-color: ${organization.color}`"
                                ></span
                                >{{ organization.name }}</label
                            >
                        </div>
                    </li>
                </template>
            </DropdownRadio>
        </div>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Risque</th>
                        <th scope="col" class="px-6 py-3">Organisations</th>
                        <th scope="col" class="px-6 py-3">Visible</th>
                        <th scope="col" class="px-6 py-3">
                            <span class="sr-only">Modifier</span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        v-for="risk in shownRisks"
                    >
                        <th
                            scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            <div>
                                <RiskAndCategory
                                    :name="risk.name"
                                    :category_name="risk.category.name"
                                    :category_color="risk.category.color"
                                />
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            <div>
                                <p
                                    class="mb-2"
                                    v-for="organization in risk.organization_types"
                                >
                                    {{ organization.name }}
                                </p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <input
                                type="checkbox"
                                :checked="risk.is_active"
                                @change="updateStatus(risk)"
                            />
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button
                                @click="updateRisk(risk)"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            >
                                Modifier
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mt-4 flex justify-center">
            <Pagination
                :pages="maxPage"
                :actualPage="page"
                @changePage="
                    page = $event;
                    pageRisks();
                "
            />
        </div>
    </AuthenticatedLayout>
</template>
