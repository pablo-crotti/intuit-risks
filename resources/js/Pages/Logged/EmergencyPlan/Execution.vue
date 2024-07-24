<script setup>
import Setup from "@/Pages/Logged/EmergencyPlan/Partials/Setup.vue";

const props = defineProps({
    risk: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Setup :risk="risk" />
</template>
