<script>
import MatrixTooltip from "@/Components/Risks/Components/MatrixTooltip.vue";
import RiskTableBody from "@/Components/Risks/Components/RiskTableBody.vue";

export default {
    data() {
        return {
            selectedRisk: null,
        };
    },

    props: {
        risks: {
            type: Array,
            required: true,
        },
    },
    components: {
        MatrixTooltip,
        RiskTableBody,
    },
    computed: {
        riskMatrix() {
            const matrix = {};
            for (let p = 1; p <= 4; p++) {
                matrix[p] = {};
                for (let i = 1; i <= 4; i++) {
                    matrix[p][i] = [];
                }
            }
            this.risks.forEach((risk) => {
                const prob = risk.evaluations[0].probability;
                const impact = risk.evaluations[0].impact;
                if (prob && impact) {
                    matrix[prob][impact].push(risk);
                }
            });
            return matrix;
        },
    },
};
</script>

<template>
    <table
        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
    >
        <thead class="text-xs text-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="w-1/5 py-3 text-center"></th>
                <th
                    scope="col"
                    class="w-1/5 bg-white py-3 text-center border dark:bg-gray-800 dark:border-gray-600"
                >
                    Mineur
                </th>
                <th
                    scope="col"
                    class="w-1/5 bg-white py-3 text-center border dark:bg-gray-800 dark:border-gray-600"
                >
                    Significatif
                </th>
                <th
                    scope="col"
                    class="w-1/5 bg-white py-3 text-center border dark:bg-gray-800 dark:border-gray-600"
                >
                    Important
                </th>
                <th
                    scope="col"
                    class="w-1/5 bg-white py-3 text-center border dark:bg-gray-800 dark:border-gray-600"
                >
                    Majeur
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                v-for="(probLabel, prob) in [
                    'Très probable',
                    'Probable',
                    'Possible',
                    'Peu probable',
                ]"
                :key="prob"
                :class="`probability-${4 - prob}`"
            >
                <td
                    scope="row"
                    class="w-1/5 text-xs font-bold bg-white py-3 text-gray-700 dark:text-gray-400 text-center border dark:bg-gray-800 dark:border-gray-600"
                >
                    {{ probLabel }}
                </td>
                <td
                    v-for="impact in [1, 2, 3, 4]"
                    :key="impact"
                    :class="`impact-${impact} border dark:border-gray-600`"
                >
                    <div
                        class="flex justify-start gap-1 flex-wrap min-w-1/5 max-w-1/5 p-2 min-h-24"
                    >
                        <MatrixTooltip
                            v-for="risk in riskMatrix[4 - prob][impact]"
                            :key="risk.id"
                            :id="risk.id"
                            :catLabel="risk.category.label"
                            :catColor="risk.category.color"
                            :name="risk.name"
                            @showDetails="selectedRisk = risk"
                        />
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    <div v-if="selectedRisk" class="mt-4">
        <table
            class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
        >
            <thead class="text-xs text-gray-700 dark:text-gray-400">
                <tr class="border-b">
                    <th scope="col" class="px-6 py-3">Titre</th>
                    <th scope="col" class="px-6 py-3">Criticité</th>
                    <th scope="col" class="px-6 py-3">Tendence</th>
                    <th scope="col" class="px-6 py-3">Stratégie</th>
                    <th scope="col" class="px-6 py-3">Dernière évaluation</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b dark:border-gray-700">
                    <RiskTableBody :risk="selectedRisk" />
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>
.probability-1 .impact-1,
.probability-1 .impact-2,
.probability-2 .impact-1 {
    background-color: #34a72a;
}
.probability-1 .impact-3,
.probability-1 .impact-4,
.probability-2 .impact-2,
.probability-2 .impact-3,
.probability-3 .impact-1,
.probability-3 .impact-2,
.probability-4 .impact-1 {
    background-color: #c9812f;
}
.probability-4 .impact-2,
.probability-4 .impact-3,
.probability-4 .impact-4,
.probability-3 .impact-3,
.probability-3 .impact-4,
.probability-2 .impact-4 {
    background-color: #ca3737;
}
</style>
