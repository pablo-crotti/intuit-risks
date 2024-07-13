<script setup>
import { Head } from "@inertiajs/vue3";
import { defineProps, onMounted } from "vue";
import { initFlowbite } from "flowbite";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import RiskChartWidget from "@/Components/Risks/Widgets/RiskChartWidget.vue";
import PrecursorsWidget from "@/Components/Risks/Widgets/PrecursorsWidget.vue";
import EvaluationWidget from "@/Components/Risks/Widgets/EvaluationWidget.vue";
import RiskPropsWidget from '@/Components/Risks/Widgets/RiskPropsWidget.vue'
import RiskStrategyWidget from '@/Components/Risks/Widgets/RiskStrategyWidget.vue'
import EmergencyPlanWidget from "@/Components/Risks/Widgets/EmergencyPlanWidget.vue";


const props = defineProps({
    risk: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    initFlowbite();

});
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Risques" />
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
            <div class="bg-white rounded-md dark:bg-gray-800">
                <RiskPropsWidget :risk="risk" />
                <PrecursorsWidget :risk="risk" />
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <EvaluationWidget :risk="risk" />
                <RiskChartWidget :evaluations="risk.evaluations" />
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <RiskStrategyWidget :strategy="risk.strategy ? risk.strategy : 'Non définie'" :risk="risk"/>
                <EmergencyPlanWidget :risk="risk"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
