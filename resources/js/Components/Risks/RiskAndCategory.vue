<script>
export default {
    props: {
        name: {
            type: String,
            required: true,
        },
        category_name: {
            type: String,
            required: true,
        },
        category_color: {
            type: String,
            required: true,
        },
    },
};
</script>

<template>
    <div>
        <div class="text-sm font-medium text-gray-900 dark:text-white">
            {{ name }}
        </div>
        <div
            class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2"
        >
            <span
                class="w-2 h-2 block rounded-full"
                :style="`background-color: ${category_color}`"
            ></span>
            {{ category_name }}
        </div>
    </div>
</template>
