<script>

export default {
    props: {
        probability: {
            type: String,
            required: true,
        },
        impact: {
            type: String,
            required: true,
        },
    },
    emits: ["update:probability", "update:impact"],
};



</script>
<template>
    <div class="relative mb-12">
        <label
            for="labels-range-input"
            class="font-normal text-lg text-gray-700 dark:text-white"
            >Probabilité
        </label>
        <input
            id="labels-range-input"
            type="range"
            :value="probability"
            @input="$emit('update:probability', $event.target.value)"
            min="1"
            max="4"
            class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-600"
        />
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6"
            >Peu probable</span
        >
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute start-1/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
            >Possible</span
        >
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute start-2/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
            >Probable</span
        >
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6"
            >Très probable</span
        >
    </div>
    <div class="relative mb-6">
        <label
            for="labels-range-input"
            class="font-normal text-lg text-gray-700 dark:text-white"
            >Impact</label
        >
        <input
            id="labels-range-input"
            type="range"
            :value="impact"
            @input="$emit('update:impact', $event.target.value)"
            min="1"
            max="4"
            class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-600"
        />
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6"
            >Mineur</span
        >
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute start-1/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
            >Significatif</span
        >
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute start-2/3 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6"
            >Important</span
        >
        <span
            class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6"
            >Majeur</span
        >
    </div>
</template>
