<script setup>
import Setup from "@/Pages/Logged/EmergencyPlan/Partials/Setup.vue";

const props = defineProps({
    risk: {
        type: Object,
        required: true,
    },
});

console.log(props.risk);
</script>

<template>
    <Setup :risk="risk" v-if="risk.emergencyPlanStatus == 1" />
</template>
