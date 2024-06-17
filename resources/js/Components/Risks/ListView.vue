<script>
// import CriticityTooltip from "@/Components/Risks/CriticityTooltip.vue";
// import TendencyArrow from "@/Icons/TendencyArrow.vue";
// import DateText from "@/Components/DateText.vue";
// import ReviewInformations from "@/Components/Risks/ReviewInformations.vue";
// import RiskStrategy from "@/Components/Risks/RiskStrategy.vue";
import RiskTableBody from "@/Components/Risks/RiskTableBody.vue";

export default {
    props: {
        risks: {
            type: Array,
            required: true,
        },
    },
    components: {
        RiskTableBody
    },
    mounted() {
        console.log(this.risks);
    },
};
</script>

<template>
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
            <tr class="border-b dark:border-gray-700" v-for="risk in risks">
                <RiskTableBody :risk="risk" />
            </tr>
        </tbody>
    </table>
</template>
