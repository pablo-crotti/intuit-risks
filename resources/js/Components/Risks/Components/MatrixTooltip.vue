<script>
import { initFlowbite } from "flowbite";
export default {
    props: {
        id: {
            type: Number,
            required: true,
        },
        catLabel: {
            type: String,
            required: true,
        },
        catColor: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
    },
    mounted() {
        initFlowbite();
    },
};
</script>

<template>
    <div>
        <button
            :data-tooltip-target="`tooltip-${id}`"
            type="button"
            class="text-gray-700 rounded-lg text-xs px-2 py-0.5 text-center bg-white dark:bg-gray-700 dark:text-white flex items-center gap-1 hover:bg-gray-200 dark:hover:bg-gray-800"
        >
            <span
                class="w-2 h-2 block rounded-full"
                :style="`background-color: ${catColor}`"
            ></span
            >{{ `${catLabel} ${id}` }}
        </button>

        <div
            :id="`tooltip-${id}`"
            role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
        >
            {{ name }}
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</template>
