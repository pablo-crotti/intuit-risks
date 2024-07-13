<script>
import { useForm } from "@inertiajs/vue3";
import { initFlowbite } from "flowbite";

import CustomModal from "@/Components/CustomModal.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import UserImgPlaceholder from "@/Icons/UserImgPlaceholder.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import Loader from "@/Components/Loader.vue";

import askMistral from "@/Helpers/askMistral";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
        tasks: {
            type: Array,
            required: true,
        },
    },

    data() {
        return {
            manualClose: false,
            users: [],
            isLoading: false,
            form: useForm({
                task: "",
                responsible: null,
            }),
        };
    },

    components: {
        CustomModal,
        TextInput,
        InputLabel,
        InputError,
        UserImgPlaceholder,
        PrimaryButton,
        PrimaryButtonMono,
        Loader,

    },
    methods: {
        close() {
            const closeButton = document.querySelector(
                "#dropdownUsersRedButton"
            );
            if (closeButton) {
                const clickEvent = new MouseEvent("click", {
                    bubbles: true,
                    cancelable: true,
                    view: window,
                });
                closeButton.dispatchEvent(clickEvent);
            }
        },

        store() {
            this.isLoading = true;
            this.form.post(`/api/risks/${this.risk.id}/tasks`, {
                onSuccess: () => {
                    this.manualClose = true;
                    this.isLoading = false;
                    this.form.reset();
                },
                onError: () => {
                    this.isLoading = false;
                },
            });
        },
        async generateReductionPlanTask() {
            this.isLoading = true;
            const company = await axios.get(route("company.index"));
            const companyForAI = {
                sector: company.data.sector,
                employees: company.data.employees,
                country: company.data.country.name,
                city: company.data.city,
                organization_type: company.data.organization_type.name,
            };

            const taskFromAI = await askMistral.askReductionPlanTask(
                companyForAI,
                this.risk
            );

            this.form.task = taskFromAI.title;
            this.isLoading = false;
        
        },
    },

    mounted() {
        initFlowbite();
        axios.get("/api/users").then((response) => {
            this.users = response.data;
        });
    },
};
</script>
<template>
    <Loader v-if="isLoading" />
    <CustomModal
        :manualClose="manualClose"
        title="Nouvelle action de réduction"
        @manualClosed="manualClose = false"
        buttonTitle="Ajouter une action"
    >
        <template #body>
            <div class="mb-4">
                <button
                    @click="generateReductionPlanTask"
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
            <div class="mb-4">
                <InputLabel for="task" label="Action">Action</InputLabel>
                <textarea
                    id="task"
                    v-model="form.task"
                    class="block w-full mt-1 border bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:text-white"
                    rows="3"
                    placeholder="Sensibiliser les employés aux dangers humains et sociaux, tels que le harcèlement moral ou sexuel, et leur fournir une formation sur les comportements appropriés en milieu de travail."
                ></textarea>
                <InputError :message="form.errors.task" />
            </div>
            <div class="flex flex-col items-end">
                <button
                    id="dropdownUsersRedButton"
                    data-dropdown-toggle="dropdownUsersRed"
                    data-dropdown-placement="bottom"
                    class="text-gray-800 min-w-max bg-gray-300 hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-blue-800"
                    type="button"
                >
                    <span v-if="!form.responsible">Responsable</span>
                    <div v-else class="flex items-center gap-2">
                        <UserImgPlaceholder :img="form.responsible.image" />

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
                    id="dropdownUsersRed"
                    class="z-10 hidden bg-gray-200 rounded-lg shadow w-60 dark:bg-gray-600"
                >
                    <ul
                        class="h-48 py-2 overflow-y-auto text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownUsersRedButton"
                    >
                        <li v-for="user in users">
                            <button
                                @click="(form.responsible = user), close()"
                                :class="`${
                                    form.responsible &&
                                    user.id == form.responsible.id
                                        ? 'bg-gray-100 dark:bg-gray-800'
                                        : ''
                                } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                            >
                                <UserImgPlaceholder :img="user.image" />

                                {{ user.name }}
                            </button>
                        </li>
                    </ul>
                </div>
                <InputError :message="form.errors.responsible" />
            </div>
        </template>

        <template #footer>
            <div class="w-full flex justify-end gap-4">
                <div>
                    <PrimaryButtonMono
                        @click="(manualClose = true), form.reset()"
                        >Annuler</PrimaryButtonMono
                    >
                </div>
                <div>
                    <PrimaryButton @click="store">Enregistrer</PrimaryButton>
                </div>
            </div>
        </template>
    </CustomModal>
</template>
