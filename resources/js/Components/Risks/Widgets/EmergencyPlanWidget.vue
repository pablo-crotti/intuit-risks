<script>
import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import NewEmergencyPlan from "@/Components/Risks/Forms/NewEmergencyPlan.vue";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    
    components: {
        WidgetLayout,
        DangerButton,
        NewEmergencyPlan,
    
    },
    mounted() {},
};
</script>

<template>
    <WidgetLayout>
        <template #title> Plan d'urgence </template>
        <template #action>
                <NewEmergencyPlan :risk="risk" />
        </template>
        <template #content>
            <div class="px-4 py-4 w-full flex flex-col gap-4 justify-end">
                
                <div class="flex justify-center">
                <div class="w-max">
                    <DangerButton>Exécuter le plan d'urgence</DangerButton>
                </div>
            </div>
            </div>
        </template>
    </WidgetLayout>
</template>
