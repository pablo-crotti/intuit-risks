<script>
import { initFlowbite } from "flowbite";
import { useForm } from "@inertiajs/vue3";

import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import RiskAndCategory from "@/Components/Risks/Components/RiskAndCategory.vue";
import UserNameAndImg from "@/Components/UserNameAndImg.vue";
import CustomModal from "@/Components/CustomModal.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DropdownRadio from "@/Components/DropdownRadio.vue";
import UserImgPlaceholder from "@/Icons/UserImgPlaceholder.vue";
import Loader from "@/Components/Loader.vue";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            manualClose: false,
            manualCloseRadio: false,
            categories: [],
            users: [],
            isLoading: false,
            form: useForm({
                title: this.risk.name,
                description: this.risk.description,
                category: this.risk.category,
                responsible: this.risk.responsible,
                frequency: this.risk.evaluation_frequency,

                id: this.risk.id,
            }),
        };
    },

    components: {
        WidgetLayout,
        CustomModal,
        SecondaryButton,
        RiskAndCategory,
        UserNameAndImg,
        PrimaryButtonMono,
        PrimaryButton,
        DropdownRadio,
        UserImgPlaceholder,
        Loader,
        TextInput,
        InputLabel,
        InputError,
    },
    methods: {
        update() {
            (this.isLoading = true),
                this.form.put(`/api/risks/${this.form.id}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.manualClose = true;
                        this.isLoading = false;
                    },
                    onError: () => {
                        this.isLoading = false;
                    },
                });
        },
    },
    mounted() {
        initFlowbite();
        axios.get("/api/categories").then((response) => {
            this.categories = response.data;
        });

        axios.get("/api/users").then((response) => {
            this.users = response.data;
        });
    },
};
</script>

<template>
    <Loader v-if="isLoading" />
    <WidgetLayout>
        <template #title>Propriétés </template>
        <template #action>
            <CustomModal
                :id="`update-props-${risk.id}`"
                :manualClose="manualClose"
                @manualClosed="manualClose = false"
                title="Propriétés"
            >
                <template #body>
                    <div class="w-full">
                        <div class="w-full flex justify-end">
                            <DropdownRadio
                                :manualClose="manualCloseRadio"
                                @manualClosed="manualCloseRadio = false"
                            >
                                <template
                                    v-slot:button
                                    v-if="form.category.name"
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
                                <template v-slot:button v-esle>
                                    Catégorie
                                </template>
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
                                                    (manualCloseRadio = true)
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
                        </div>
                        <div class="flex justify-end">
                            <InputError
                                class="mt-2"
                                :message="form.errors.category"
                            />
                        </div>
                        <div class="mb-4">
                            <InputLabel>Nom</InputLabel>
                            <TextInput
                                v-model="form.title"
                                label="Nom"
                                placeholder="Nom du risque"
                                :required="true"
                            />
                            <InputError :message="form.errors.title" />
                        </div>
                        <div class="mb-4">
                            <InputLabel for="description"
                                >Description</InputLabel
                            >
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="block w-full mt-1 border bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:text-white"
                                rows="3"
                            ></textarea>
                            <InputError
                                class="mt-2"
                                :message="form.errors.description"
                            />
                        </div>
                        <div class="flex justify-start mb-2">
                            <InputLabel>Fréquence d'évaluation</InputLabel>
                        </div>
                        <div class="flex justify-start">
                            <button
                                id="dropdownFreqButton"
                                data-dropdown-toggle="dropdownFreq"
                                data-dropdown-placement="bottom"
                                class="text-gray-800 min-w-max bg-gray-300 hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-blue-800"
                                type="button"
                            >
                                <span v-if="!form.frequency"
                                    >Définir un fréquence d'évaluation</span
                                >
                                <span v-else>
                                    {{
                                        form.frequency == 86400
                                            ? `Un jour`
                                            : form.frequency == 604800
                                            ? `Une semaine`
                                            : form.frequency == 2592000
                                            ? `Un mois`
                                            : form.frequency == 7776000
                                            ? `Trois mois`
                                            : form.frequency == 15552000
                                            ? `Six mois`
                                            : `Une année`
                                    }}</span
                                >

                                <svg
                                    class="w-2.5 h-2.5 ms-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 10 6"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m1 1 4 4 4-4"
                                    />
                                </svg>
                            </button>
                            <div
                                id="dropdownFreq"
                                class="z-10 hidden bg-gray-200 rounded-lg shadow w-60 dark:bg-gray-700"
                            >
                                <ul
                                    class="h-48 py-2 overflow-y-auto text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownFreqButton"
                                >
                                    <li>
                                        <button
                                            @click="form.frequency = 86400"
                                            :class="`${
                                                form.frequency == 86400
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            Un jour
                                        </button>
                                    </li>
                                    <li>
                                        <button
                                            @click="form.frequency = 604800"
                                            :class="`${
                                                form.frequency == 604800
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            Une semaine
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            @click="form.frequency = 2592000"
                                            :class="`${
                                                form.frequency == 2592000
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            Un mois
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            @click="form.frequency = 7776000"
                                            :class="`${
                                                form.frequency == 7776000
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            Trois mois
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            @click="form.frequency = 15552000"
                                            :class="`${
                                                form.frequency == 15552000
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            Six mois
                                        </button>
                                    </li>

                                    <li>
                                        <button
                                            @click="form.frequency = 31536000"
                                            :class="`${
                                                form.frequency == 31536000
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            Une année
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div>
                            <InputError
                                class="mt-2"
                                :message="form.errors.frequency"
                            />
                        </div>
                        <div class="flex justify-end">
                            <button
                                id="dropdownUsersButton"
                                data-dropdown-toggle="dropdownUsers"
                                data-dropdown-placement="bottom"
                                class="text-gray-800 min-w-max bg-gray-300 hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-blue-800"
                                type="button"
                            >
                                <span v-if="!form.responsible"
                                    >Définir un responsable</span
                                >
                                <div v-else class="flex items-center gap-2">
                                    <UserImgPlaceholder
                                        :img="form.responsible.image"
                                    />

                                    {{ form.responsible.name }}
                                </div>

                                <svg
                                    class="w-2.5 h-2.5 ms-3"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 10 6"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m1 1 4 4 4-4"
                                    />
                                </svg>
                            </button>
                            <div
                                id="dropdownUsers"
                                class="z-10 hidden bg-gray-200 rounded-lg shadow w-60 dark:bg-gray-700"
                            >
                                <ul
                                    class="h-48 py-2 overflow-y-auto text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownUsersButton"
                                >
                                    <li v-for="user in users">
                                        <button
                                            @click="form.responsible = user"
                                            :class="`${
                                                form.responsible &&
                                                user.id == form.responsible.id
                                                    ? 'bg-gray-100 dark:bg-gray-800'
                                                    : ''
                                            } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                        >
                                            <UserImgPlaceholder
                                                :img="user.image"
                                            />

                                            {{ user.name }}
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <InputError
                                class="mt-2"
                                :message="form.errors.responsible"
                            />
                        </div>
                    </div>
                </template>
                <template #footer>
                    <div class="w-full flex justify-end gap-4">
                        <div class="w-30">
                            <PrimaryButtonMono
                                :data-modal-hide="`update-props-${risk.id}`"
                                >Annuler</PrimaryButtonMono
                            >
                        </div>
                        <div class="w-30">
                            <PrimaryButton @click="update"
                                >Enregistrer</PrimaryButton
                            >
                        </div>
                    </div>
                </template>
            </CustomModal>
        </template>
        <template #content>
            <div class="px-4 py-4">
                <RiskAndCategory
                    :name="risk.name"
                    :category_name="risk.category.name"
                    :category_color="risk.category.color"
                />

                <div
                    id="accordion-flush"
                    data-accordion="collapse"
                    data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                    data-inactive-classes="text-gray-500 dark:text-gray-400"
                >
                    <h2 id="accordion-flush-heading-1">
                        <button
                            type="button"
                            class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            data-accordion-target="#accordion-flush-body-1"
                            aria-expanded="false"
                            aria-controls="accordion-flush-body-1"
                        >
                            <span class="text-sm">Description</span>
                            <svg
                                data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5 5 1 1 5"
                                />
                            </svg>
                        </button>
                    </h2>
                    <div
                        id="accordion-flush-body-1"
                        class="hidden"
                        aria-labelledby="accordion-flush-heading-1"
                    >
                        <div
                            class="py-5 border-b border-gray-200 dark:border-gray-700"
                        >
                            <p class="mb-2 text-gray-500 dark:text-gray-400">
                                {{ risk.description }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 py-4">
                <div class="flex gap-4 mb-4">
                    <strong class="font-semibold text-gray-900 dark:text-white"
                        >Créateur</strong
                    >
                    <UserNameAndImg
                        :user_id="risk.author_id"
                        :user_name="risk.author.name"
                        :user_image="risk.author.image"
                    />
                </div>
                <div class="flex gap-4 mb-4">
                    <strong class="font-semibold text-gray-900 dark:text-white"
                        >Responsable</strong
                    >
                    <UserNameAndImg
                        v-if="risk.responsible_id"
                        :user_id="risk.responsible_id"
                        :user_name="risk.responsible.name"
                        :user_image="risk.responsible.image"
                    />
                    <p
                        v-else
                        class="text-base font-normal text-gray-500 dark:text-gray-400"
                    >
                        Non défini
                    </p>
                </div>
                <div
                    class="flex gap-4 mb-4 text-base font-normal text-gray-500 dark:text-gray-400"
                >
                    <strong class="font-semibold text-gray-900 dark:text-white"
                        >Évaluation</strong
                    >
                    {{
                        risk.evaluation_frequency == 86400
                            ? `Tous les jours`
                            : risk.evaluation_frequency == 604800
                            ? `Toutes les semaines`
                            : risk.evaluation_frequency == 2592000
                            ? `Tous les mois`
                            : risk.evaluation_frequency == 7776000
                            ? `Tous les trois mois`
                            : risk.evaluation_frequency == 15552000
                            ? `Tous les six mois`
                            : `Tous les ans`
                    }}
                </div>
            </div>
        </template>
    </WidgetLayout>
</template>
