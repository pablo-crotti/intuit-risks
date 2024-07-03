<script setup>
import { Head } from "@inertiajs/vue3";
import { defineProps, onMounted } from "vue";
import { initFlowbite } from "flowbite";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import RiskAndCategory from "@/Components/Risks/Components/RiskAndCategory.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import UserNameAndImg from "@/Components/UserNameAndImg.vue";

import RiskChartWidget from "@/Components/Risks/Widgets/RiskChartWidget.vue";
import PrecursorsWidget from "@/Components/Risks/Widgets/PrecursorsWidget.vue";
import EvaluationWidget from "@/Components/Risks/Widgets/EvaluationWidget.vue";

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
                <div class="px-4 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Propriétés
                    </h2>

                    <div class="w-24">
                        <SecondaryButton>Modifier</SecondaryButton>
                    </div>
                </div>
                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="px-4 py-4">
                    <RiskAndCategory
                        :name="risk.name"
                        :category_name="risk.category.name"
                        :category_color="risk.category.color"
                    />
                </div>
                <div class="px-4 py-4">
                    <div class="flex gap-4 mb-4">
                        <strong
                            class="font-semibold text-gray-900 dark:text-white"
                            >Créateur</strong
                        >
                        <UserNameAndImg
                            :user_name="risk.author.name"
                            :user_image="risk.author.image"
                        />
                    </div>
                </div>
                <PrecursorsWidget :risk="risk" />
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <EvaluationWidget :risk="risk" />
                <RiskChartWidget :evaluations="risk.evaluations" />
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <div class="px-4 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Stratégie
                    </h2>

                    <div class="w-24"></div>
                </div>

                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="px-4 py-4"></div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
