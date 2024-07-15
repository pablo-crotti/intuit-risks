<script>
import WidgetLayout from "@/Layouts/WidgetLayout.vue";

export default {
    props: {
        totalRisks: {
            type: Number,
            required: true,
        },

        criticalityCategories: {
            type: Object,
            required: true,
        },
    },
    components: {
        WidgetLayout,
    },
};
</script>

<template>
    <WidgetLayout>
        <template #title> {{ totalRisks }} risques identifiés </template>
        <template #content>
            <div class="px-4 py-4 w-full flex flex-col gap-4 justify-end">
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
        </template>
    </WidgetLayout>
</template>
