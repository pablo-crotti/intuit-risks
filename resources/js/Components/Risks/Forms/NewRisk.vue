<script>
import CustomModal from "@/Components/CustomModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DropdownRadio from "@/Components/DropdownRadio.vue";
import { useForm } from "@inertiajs/vue3";

export default {
    data() {
        return {
            customRisk: false,
            AIrisk: false,
            categories: [],
            manualClose: false,
            form: useForm({
                title: "",
                category: {},
            }),
        };
    },
    components: {
        CustomModal,
        PrimaryButton,
        PrimaryButtonMono,
        TextInput,
        InputLabel,
        InputError,
        DropdownRadio,
    },
    mounted() {
        axios.get("api/categories").then((response) => {
            this.categories = response.data;
        });
    },
};
</script>

<template>
    <CustomModal
        :id="'new-risk'"
        :buttonNewRisk="true"
        title="Déclarer un risque"
    >
        <template v-slot:body>
            <div v-if="!AIrisk && !customRisk" class="flex flex-col gap-4">
                <a
                    href="/register/risks"
                    class="group inline-flex w-full items-center justify-center p-5 text-base font-medium text-gray-700 rounded-lg bg-gray-100 hover:text-gray-800 hover:bg-gray-200 dark:text-gray-200 dark:bg-gray-700 border-0 dark:border-2 dark:border-gray-600 dark:hover:border-gray-800 dark:hover:bg-gray-800 dark:hover:text-white duration-300"
                >
                    <span class="w-full">Sélection de risques prédéfinis</span>
                    <svg
                        class="w-4 h-4 ms-2 rtl:rotate-180 mr-4 group-hover:mr-0 duration-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9"
                        />
                    </svg>
                </a>
                <button
                    @click="customRisk = true"
                    class="group text-left inline-flex w-full items-center justify-center p-5 text-base font-medium text-gray-700 rounded-lg bg-gray-100 hover:text-gray-800 hover:bg-gray-200 dark:text-gray-200 dark:bg-gray-700 border-0 dark:border-2 dark:border-gray-600 dark:hover:border-gray-800 dark:hover:bg-gray-800 dark:hover:text-white duration-300"
                >
                    <span class="w-full">Création d'un risque</span>
                    <svg
                        class="w-4 h-4 ms-2 rtl:rotate-180 mr-4 group-hover:mr-0 duration-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9"
                        />
                    </svg>
                </button>
                <button
                    @click="AIrisk = true"
                    class="group text-left inline-flex w-full items-center justify-center p-5 text-base font-medium text-gray-700 rounded-lg bg-gray-100 hover:text-gray-800 hover:bg-gray-200 dark:text-gray-200 dark:bg-gray-700 border-0 dark:border-2 dark:border-gray-600 dark:hover:border-gray-800 dark:hover:bg-gray-800 dark:hover:text-white duration-300"
                >
                    <span class="w-full flex gap-2 items-center">
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
                        Suggestion IA
                    </span>
                    <svg
                        class="w-4 h-4 ms-2 rtl:rotate-180 mr-4 group-hover:mr-0 duration-300"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9"
                        />
                    </svg>
                </button>
            </div>
            <div v-else>
                <form>
                    <div class="w-full flex justify-end">
                        <DropdownRadio
                            :manualClose="manualClose"
                            @manualClose="manualClose = false"
                        >
                            <template v-slot:button v-if="form.category.name"
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
                                        class="text-left px-4 py-2 hover:bg-white  dark:hover:bg-gray-600 w-full"
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
                    </div>
                    <div class="mt-4">
                        <InputLabel for="title">Titre</InputLabel>
                        <TextInput
                            id="title"
                            placeholder="Perte de motivation des employés et perte de personnel-clé"
                            v-model="form.title"
                        />
                        <InputError />
                    </div>
                    
                </form>
            </div>
        </template>
        <template v-slot:footer v-if="AIrisk || customRisk">
            <div class="w-full flex justify-end gap-4">
                <div>
                    <PrimaryButtonMono @click="AIrisk = customRisk = false"
                        >Retour</PrimaryButtonMono
                    >
                </div>
                <div><PrimaryButton>Valider</PrimaryButton></div>
            </div>
        </template>
    </CustomModal>
</template>
