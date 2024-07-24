<script setup>
import { defineProps, ref, onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import CategoriesHub from "@/Components/Registration/CategoriesHub.vue";
import RisksView from "@/Components/Registration/RisksView.vue";
import Loader from "@/Components/Loader.vue";
import { Modal } from "flowbite";
import { initFlowbite } from "flowbite";
import axios from "axios";

const props = defineProps({
    organization: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        required: true,
    },
    risks: {
        type: Object,
        required: true,
    },
    companyRisks: {
        type: Array,
        required: false,
        default: null,
    },
});

const consultedCategories = ref([]);
const selectedCategory = ref(null);
const nextCategory = ref(null);
const previousCategory = ref(null);
const actualCategoryIndex = ref(null);
const isLoading = ref(false);
let modal = null;

const consultCategory = (id) => {
    consultedCategories.value.push(id);
    selectedCategory.value = id;
    actualCategoryIndex.value = props.categories.findIndex(
        (category) => category.id === selectedCategory.value
    );
    setNextCategory();
    setPreviousCategory();
};

const setNextCategory = () => {
    if (actualCategoryIndex.value >= props.categories.length) {
        nextCategory.value = null;
    } else {
        nextCategory.value = props.categories[actualCategoryIndex.value + 1];
    }
};

const setPreviousCategory = () => {
    if (actualCategoryIndex.value < 0) {
        previousCategory.value = null;
    } else {
        previousCategory.value =
            props.categories[actualCategoryIndex.value - 1];
    }
};

const closeModal = () => {
    modal.hide();
};

const storeRisks = () => {
    isLoading.value = true;
    axios.post("/register/risks/validate").then((response) => {
        if (response.status === 200) {
            window.location.href = "/dashboard";
        }
    });
};

const validateSelection = () => {
    if (props.companyRisks.length < 5) {
        modal.show();
    } else {
        storeRisks();
    }
};

onMounted(() => {
    initFlowbite();
    const $modalElement = document.querySelector("#popup-modal");
    if ($modalElement) {
        modal = new Modal($modalElement);
        modal.init();
    }
});
</script>
<template>
    <Loader v-if="isLoading" />
    <Head title="Sélection de risques" />
    <div
        id="popup-modal"
        tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button
                    type="button"
                    class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white duration-300"
                    data-modal-hide="popup-modal"
                >
                    <svg
                        class="w-3 h-3"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 14"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                        />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-4 md:p-5 text-center">
                    <svg
                        class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                        />
                    </svg>
                    <h3
                        class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400"
                    >
                        Vous avez actuellement selectionné moins de 5 risques.
                        Êtes-vous sûr de vouloir continuer ?
                    </h3>
                    <button
                        @click="storeRisks"
                        type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:outline-none font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                    >
                        Oui, je suis sur
                    </button>
                    <button
                        data-modal-hide="popup-modal"
                        type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                    >
                        Non, annuler
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="min-w-full min-h-full px-8 py-8">
        <CategoriesHub
            v-if="!selectedCategory"
            :categories="categories"
            :consultedCategories="consultedCategories"
            @newCategorySelected="(id) => consultCategory(id)"
            @validateSelection="validateSelection"
        />
        <RisksView
            v-else
            :risks="risks[selectedCategory]"
            :companyRisks="companyRisks"
            :nextCategory="nextCategory"
            :previousCategory="previousCategory"
            :category="categories[actualCategoryIndex]"
            @newCategorySelected="(id) => consultCategory(id)"
            @validateSelection="validateSelection"
        />
    </div>
</template>
