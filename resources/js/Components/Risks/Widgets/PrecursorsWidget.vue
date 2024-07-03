<script>
import { initFlowbite } from "flowbite";
import { useForm } from "@inertiajs/vue3";

import askMistral from "@/Helpers/askMistral";

import Loader from "@/Components/Loader.vue";
import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import CustomModal from "@/Components/CustomModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import DropdownRadio from "@/Components/DropdownRadio.vue";
import DangerIcon from "@/Icons/DangerIcon.vue";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            isLoading: false,
            manualClose: false,
            sign: "",
            precursors: this.risk.precursors || [],
            precursorsUpdated: false,
            precursorsToDelete: [],
        };
    },
    components: {
        Loader,
        WidgetLayout,
        CustomModal,
        PrimaryButton,
        PrimaryButtonMono,
        TextInput,
        InputLabel,
        DropdownRadio,
        DangerIcon,
    },
    methods: {
        async generatePrecursors() {
            this.isLoading = true;
            const riskForIA = {
                name: this.risk.name,
                description: this.risk.description,
                category: this.risk.category.name,
                precursors: this.precursors,
                probability: this.risk.evaluations[0].probability,
                impact: this.risk.evaluations[0].impact,
            };

            const company = await axios.get(route("company.index"));
            const companyForAI = {
                sector: company.data.sector,
                employees: company.data.employees,
                country: company.data.country.name,
                city: company.data.city,
                organization_type: company.data.organization_type.name,
            };
            const precursorsFromAI = await askMistral.askPrecursors(
                riskForIA,
                companyForAI
            );

            precursorsFromAI.precursors.forEach((precursor) => {
                const prc = {
                    name: precursor.title,
                    id: 0,
                };
                this.precursors.push(prc);
            });
            this.isLoading = false;
            this.precursorsUpdated = true;
        },
        addPrecursor() {
            const prc = {
                name: this.sign,
                id: 0,
            };
            this.precursors.push(prc);
            this.sign = "";
            this.precursorsUpdated = true;
        },

        deletePrecursor(index, id) {
            if (id) {
                this.precursorsToDelete.push(id);
                this.precursorsUpdated = true;
            }
            this.precursors.splice(index, 1);
        },
        storePrecursors() {
            if (this.precursors.length > 0) {
                const newPrecursors = this.precursors.filter((precursor) => {
                    return precursor.id === 0;
                });

                if (newPrecursors.length > 0) {
                    const precursorsToStore = useForm({
                        precursors: newPrecursors,
                        risk_id: this.risk.id,
                    });

                    precursorsToStore.post(route("precursors.store"), {
                        onSuccess: () => {
                            precursorsToStore.reset();
                            this.manualClose = true;
                            this.precursors = this.risk.precursors;
                        },
                    });
                }
            }

            if (this.precursorsToDelete.length > 0) {
                const precursorsToDeleteForm = useForm({
                    precursors: this.precursorsToDelete,
                });

                precursorsToDeleteForm.delete(route("precursors.delete"), {
                    onSuccess: () => {
                        precursorsToDeleteForm.reset();
                        this.precursorsToDelete = [];
                        this.manualClose = true;
                    },
                });
            }

            this.precursorsUpdated = false;
        },
        updatePrecursors(id, status) {
            const updatePrecursors = useForm({
                status: status,
                id: id,
            });

            updatePrecursors.patch(route("precursors.update"), {
                onSuccess: () => {
                    updatePrecursors.reset();
                },
            });

            this.manualClose = true;
        },
    },
    mounted() {
        initFlowbite();
    },
};
</script>
<template>
    <Loader v-if="isLoading" />
    <WidgetLayout>
        <template #title>Signes avant coureurs </template>
        <template #action>
            <CustomModal
                :id="`update-signs-${risk.id}`"
                :manualClose="manualClose"
                @manualClosed="() => (manualClose = false)"
                title="Signes avant coureurs"
            >
                <template #body>
                    <div class="w-full">
                        <div class="mb-4">
                            <button
                                @click="generatePrecursors"
                                class="text-gray-700 dark:text-gray-300 hover:text-primary-500 flex gap-2 items-center"
                            >
                                Génération IA
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                    class="size-5"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"
                                        clip-rule="evenodd"
                                    />
                                    <path
                                        d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z"
                                    />
                                </svg>
                            </button>
                        </div>
                        <div class="mb-8 flex justify-between">
                            <InputLabel
                                for="signs"
                                :value="`Signes avant coureurs`"
                            />
                            <TextInput
                                id="signs"
                                v-model="sign"
                                placeholder="Signes avant coureurs"
                            />
                            <div class="w-28 ml-4">
                                <PrimaryButtonMono @click="addPrecursor"
                                    >Ajouter</PrimaryButtonMono
                                >
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <div
                                v-for="(precursor, index) in precursors"
                                :key="precursor"
                                class="flex justify-between items-center px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800"
                            >
                                <p
                                    class="text-base font-normal text-gray-700 dark:text-gray-300"
                                >
                                    {{ precursor.name }}
                                </p>
                                <button
                                    class="bg-red rounded-md hover:opacity-85 w-6 h-6 flex justify-center items-center ml-6"
                                    @click="
                                        deletePrecursor(index, precursor.id)
                                    "
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        class="size-6 text-white"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M6 18 18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
                <template #footer>
                    <div class="w-full flex justify-end gap-4">
                        <div class="w-30">
                            <PrimaryButtonMono
                                :data-modal-hide="`update-signs-${risk.id}`"
                                >Annuler</PrimaryButtonMono
                            >
                        </div>
                        <div class="w-30">
                            <PrimaryButton
                                @click="storePrecursors"
                                :disabled="!precursorsUpdated"
                                :class="!precursorsUpdated ? 'opacity-50' : ''"
                                >Enregistrer</PrimaryButton
                            >
                        </div>
                    </div>
                </template>
            </CustomModal>
        </template>
        <template #content>
            <div class="px-4 py-4 flex flex-col gap-4">
                <span v-for="precursor in risk.precursors">
                    <div
                        v-if="precursor.id != 0"
                        class="flex flex-col gap-4 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700"
                    >
                        <p
                            class="text-base font-normal text-gray-700 dark:text-gray-300"
                        >
                            {{ precursor.name }}
                        </p>
                        <div class="flex justify-end">
                            <DropdownRadio
                                :id="`dropdown-${precursor.id}`"
                                :manualClose="manualClose"
                                @manualClosed="() => (manualClose = false)"
                            >
                                <template #button>
                                    <DangerIcon :danger="precursor.status" />
                                </template>
                                <template #radio>
                                    <li>
                                        <label
                                            class="flex w-full p-2 rounded cursor-pointer hover:bg-white dark:hover:bg-gray-600"
                                        >
                                            <div
                                                class="w-full flex gap-4 items-center"
                                            >
                                                <input
                                                    :name="`helper-radio-${precursor.id}`"
                                                    type="radio"
                                                    :checked="
                                                        precursor.status == 0
                                                    "
                                                    @change="
                                                        updatePrecursors(
                                                            precursor.id,
                                                            0
                                                        )
                                                    "
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <p
                                                    class="w-full font-medium text-gray-900 dark:text-gray-300"
                                                >
                                                    Aucun signe
                                                </p>
                                                <div class="flex justify-end">
                                                    <DangerIcon :danger="0" />
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex p-2 rounded cursor-pointer hover:bg-white dark:hover:bg-gray-600"
                                        >
                                            <div
                                                class="w-full flex gap-4 items-center"
                                            >
                                                <input
                                                    :name="`helper-radio-${precursor.id}`"
                                                    type="radio"
                                                    :checked="
                                                        precursor.status == 1
                                                    "
                                                    @change="
                                                        updatePrecursors(
                                                            precursor.id,
                                                            1
                                                        )
                                                    "
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <p
                                                    class="w-full font-medium text-gray-900 dark:text-gray-300"
                                                >
                                                    À surveiller
                                                </p>
                                                <div class="flex justify-end">
                                                    <DangerIcon :danger="1" />
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex p-2 rounded cursor-pointer hover:bg-white dark:hover:bg-gray-600"
                                        >
                                            <div
                                                class="w-full flex gap-4 items-center"
                                            >
                                                <input
                                                    :name="`helper-radio-${precursor.id}`"
                                                    type="radio"
                                                    :checked="
                                                        precursor.status == 2
                                                    "
                                                    @change="
                                                        updatePrecursors(
                                                            precursor.id,
                                                            2
                                                        )
                                                    "
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <p
                                                    class="w-full font-medium text-gray-900 dark:text-gray-300"
                                                >
                                                    En cours
                                                </p>
                                                <div class="flex justify-end">
                                                    <DangerIcon :danger="2" />
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                </template>
                            </DropdownRadio>
                        </div>
                    </div>
                </span>
            </div>
        </template>
    </WidgetLayout>
</template>
