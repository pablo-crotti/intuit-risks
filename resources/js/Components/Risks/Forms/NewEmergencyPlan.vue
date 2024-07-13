<script>
import CustomModal from "@/Components/CustomModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import { Input } from "postcss";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            buttonTitle: "Modifier",
            manualClose: false,
            information: "",
            action: "",
            informations: [],
            actions: [],
            toDelete: [],
        };
    },

    components: {
        CustomModal,
        InputLabel,
        TextInput,
        PrimaryButtonMono,
    },

    methods: {
        addInformation() {
            if (this.information === "") {
                return;
            }

            
            const info = {
                information: this.information,
                id: 0,
            };

            this.informations.push(info);
            this.information = "";
        },
        deleteInformation(index, id) {
            if(id) {
                this.toDelete.push(id);
            }
            this.informations.splice(index, 1);
        },
        addAction() {
            if (this.action === "") {
                return;
            }

            
            const action = {
                action: this.action,
                id: 0,
            };

            this.actions.push(action);
            this.action = "";
        },
        deleteAction(index, id) {
            if(id) {
                this.toDelete.push(id);
            }
            this.actions.splice(index, 1);
        },
        generateEmergencyPlan() {
            console.log("generate precursors");
        },
    },

    mounted() {
        console.log(this.risk);
    },
};
</script>

<template>
    <CustomModal
        :buttonTitle="
            this.risk.emergency_plan_actions.length == 0 ? 'Créer' : 'Modifier'
        "
        :manualClose="manualClose"
        @manualClosed="manualClose = false"
        title="Plan d'urgence"
        :id="`update-emergency-plan-${risk.id}`"
    >
        <template #body>
            <div class="mb-4">
                <button
                    @click="generateEmergencyPlan"
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
                <TextInput
                    id="infos"
                    v-model="information"
                    placeholder="Informations utiles"
                />
                <div class="w-28 ml-4">
                    <PrimaryButtonMono @click="addInformation"
                        >Ajouter</PrimaryButtonMono
                    >
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div
                    v-for="(information, index) in informations"
                    :key="information"
                    class="flex justify-between items-center px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700"
                >
                    <p
                        class="text-base font-normal text-gray-700 dark:text-gray-300"
                    >
                        {{ information.information }}
                    </p>
                    <button
                        class="bg-red rounded-md hover:opacity-85 w-6 h-6 flex justify-center items-center ml-6"
                        @click="deleteInformation(index, information.id)"
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
            <div class="mb-8 flex justify-between">
                <TextInput
                    id="actions"
                    v-model="action"
                    placeholder="Actions à mener"
                />
                <div class="w-28 ml-4">
                    <PrimaryButtonMono @click="addAction"
                        >Ajouter</PrimaryButtonMono
                    >
                </div>
            </div>
            <div class="flex flex-col gap-4">
                <div
                    v-for="(action, index) in actions"
                    :key="action"
                    class="flex justify-between items-center px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700"
                >
                    <p
                        class="text-base font-normal text-gray-700 dark:text-gray-300"
                    >
                        {{ action.action }}
                    </p>
                    <button
                        class="bg-red rounded-md hover:opacity-85 w-6 h-6 flex justify-center items-center ml-6"
                        @click="deleteAction(index, action.id)"
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
        </template>
    </CustomModal>
</template>
