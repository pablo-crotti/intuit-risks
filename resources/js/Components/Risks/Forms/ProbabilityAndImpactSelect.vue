<script>
export default {
    props: {
        probability: {
            required: true,
        },
        impact: {
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
        <div class="flex justify-between mt-2 gap-2">
            <button
                @click="$emit('update:probability', 1)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    probability == 1
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Peu probable
            </button>
            <button
                @click="$emit('update:probability', 2)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    probability == 2
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Possible
            </button>
            <button
                @click="$emit('update:probability', 3)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    probability == 3
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Probable
            </button>
            <button
                @click="$emit('update:probability', 4)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    probability == 4
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Très probable
            </button>
        </div>
        <!-- <input
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
        > -->
    </div>
    <div class="relative mb-6">
        <label
            for="labels-range-input"
            class="font-normal text-lg text-gray-700 dark:text-white"
            >Impact</label
        >
        <div class="flex justify-between mt-2 gap-2">
            <button
                @click="$emit('update:impact', 1)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    impact == 1
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Mineur
            </button>
            <button
                @click="$emit('update:impact', 2)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    impact == 2
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Significatif
            </button>
            <button
                @click="$emit('update:impact', 3)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    impact == 3
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Important
            </button>
            <button
                @click="$emit('update:impact', 4)"
                :class="`w-1/4 px-4 py-2 border rounded-md ${
                    impact == 4
                        ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                        : 'border-gray-400 text-gray-500 dark:border-gray-600 dark:text-gray-400 hover:bg-gray-400 hover:text-white dark:hover:bg-gray-600 dark:hover:text-white duration-300'
                }`"
            >
                Majeur
            </button>
        </div>
        <!-- <input
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
        > -->
    </div>
</template>
