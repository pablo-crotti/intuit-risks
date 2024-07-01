<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { defineProps, ref } from "vue";
import evaluations from "@/Helpers/evaluations";
import RisksChart from "@/Components/Risks/RisksChart.vue";

const props = defineProps({
    company: {
        type: Object,
        required: true,
    },
    totalRisks: {
        type: Number,
        required: true,
    },
    criticalityCategories: {
        type: Object,
        required: true,
    },
    evaluations: {
        type: Array,
        required: true,
    },
});

const variations = evaluations.formatEvaluationsVariations(props.evaluations);
</script>

<template>
    <Head title="Tableau de bord" />
    
    <AuthenticatedLayout>
        <div class="py-12">
            <h2
                class="mb-10 text-3xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-5xl lg:text-5xl text-gray-900 dark:text-white"
            >
                <span class="text-primary-400">{{ company.name }}</span> -
                Tableau de bord
            </h2>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white rounded-md dark:bg-gray-800">
                    <div class="px-4 py-4 flex justify-between items-center">
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            {{ totalRisks }} risques identifiés
                        </h2>
                    </div>
                    <span
                        class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                    ></span>
                    <div
                        class="px-4 py-4 w-full flex flex-col gap-4 justify-end"
                    >
                        <div
                            class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-red"
                        >
                            {{ criticalityCategories.critical }} critiques
                        </div>
                        <div
                            class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-orange"
                        >
                            {{ criticalityCategories.moderate }} majeurs
                        </div>
                        <div
                            class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-green"
                        >
                            {{ criticalityCategories.low }} mineurs
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-md dark:bg-gray-800">
                    <div class="px-4 py-4 flex justify-between items-center">
                        <h2
                            class="text-lg font-bold text-gray-900 dark:text-white"
                        >
                            Évolution
                        </h2>
                    </div>
                    <span
                        class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                    ></span>
                    <div class="px-4 py-4">
                        <RisksChart :variations="variations" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
