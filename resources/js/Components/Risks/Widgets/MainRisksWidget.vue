<script>
import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import CriticityTooltip from "../Components/CriticityTooltip.vue";

export default {
    props: {
        mainRisks: {
            type: Object,
            required: true,
        },
    },
    components: {
        WidgetLayout,
        CriticityTooltip,
    
    },
    methods: {
        orderRisks() {
            return this.mainRisks.sort((a, b) => {
                return b.probability * b.impact - a.probability * a.impact;
            });
        },
    },
    mounted() {
       this.orderRisks();
    },
};
</script>

<template>
    <WidgetLayout>
        <template #title> Les plus critiques </template>
        <template #content>
            <div class="px-4 py-4 w-full flex flex-col gap-4 justify-end">
                <a v-for="risk in mainRisks" :href="`/risks/${risk.company_risk.id}`" class="flex flex-col gap-2 border-2 border-gray-100 hover:bg-gray-100 dark:border-gray-600 hover:dark:bg-gray-600 px-4 py-2 rounded-lg duration-300">
                    <div class="flex justify-between items-center gap-2">
                        <h2 class="text-base text-gray-900 dark:text-white">
                            {{ risk.company_risk.name }}
                        </h2>
                        <CriticityTooltip
                            :id="risk.company_risk.id"
                            :probability="risk.probability"
                            :impact="risk.impact"
                             />
                    </div>
                    
                </a>
            </div>
        </template>
    </WidgetLayout>
</template>
