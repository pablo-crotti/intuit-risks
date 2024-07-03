<script>
import { initFlowbite } from "flowbite"; 
export default {
    props: {
        id: {
            required: true,
        },
        probability: {
            type: [Number, null],
            required: false,
            default: null,
        },
        impact: {
            type: [Number, null],
            required: false,
            default: null,
        },
    },

    methods: {
        defineCriticity(probability, impact) {
            if (probability * impact >= 8) {
                return "Critique";
            } else if (probability * impact >= 3) {
                return "Majeure";
            } else {
                return "Mineure";
            }
        },
    },
    mounted() {
        initFlowbite();
    },
};
</script>
<template>
    <div v-if="probability && impact">
        <button
            :data-tooltip-target="`tooltip-${id}`"
            type="button"
            :class="`text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center ${
                probability * impact >= 8
                    ? 'bg-red'
                    : probability * impact >= 3
                    ? 'bg-orange'
                    : 'bg-green'
            }`"
        >
            {{ defineCriticity(probability, impact) }}
        </button>

        <div
            :id="`tooltip-${id}`"
            role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
        >
            Probabilité: {{ probability }}<br />
            Impact: {{ impact }}<br />
            Criticité: {{ probability * impact }}
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>

    <div v-else>
        <button
            :data-tooltip-target="`tooltip-${id}`"
            type="button"
            class="text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-gray-400 dark:bg-gray-500"
        >
            Non évalué
        </button>

        <div
            :id="`tooltip-${id}`"
            role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700"
        >
            Ce risque n'a pas encore été évalué.
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>
    </div>
</template>
