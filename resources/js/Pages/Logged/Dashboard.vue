<script setup>
import { Head } from "@inertiajs/vue3";
import { defineProps } from "vue";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import GlobalStatusWidget from "@/Components/Risks/Widgets/GlobalStatusWidget.vue";
import GlobalRiskChartWidget from "@/Components/Risks/Widgets/GlobalRiskChartWidget.vue";
import MainRisksWidget from "@/Components/Risks/Widgets/MainRisksWidget.vue";

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
    mainRisks: {
        type: Object,
        required: true,
    },
});
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
                    <GlobalStatusWidget
                        :totalRisks="totalRisks"
                        :criticalityCategories="criticalityCategories"
                    />
                </div>
                <div class="bg-white rounded-md dark:bg-gray-800">
                    <GlobalRiskChartWidget :evaluations="evaluations" />
                </div>
                <div class="bg-white rounded-md dark:bg-gray-800">
                    <MainRisksWidget :mainRisks="mainRisks" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
