<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>

<template>
    <label
        for="email"
        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
        ><slot /></label
    >

    <!-- <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label> -->
</template>
