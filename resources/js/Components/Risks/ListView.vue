<script>
// import CriticityTooltip from "@/Components/Risks/CriticityTooltip.vue";
// import TendencyArrow from "@/Icons/TendencyArrow.vue";
// import DateText from "@/Components/DateText.vue";
// import ReviewInformations from "@/Components/Risks/ReviewInformations.vue";
// import RiskStrategy from "@/Components/Risks/RiskStrategy.vue";
import RiskTableBody from "@/Components/Risks/RiskTableBody.vue";

export default {
    data() {
        return {
            risks: [
                {
                    id: 1,
                    name: "Vague de froid intense et de longue durée",
                    category_name: "Environnemnt",
                    category_label: "ENV",
                    category_color: "#3FC919",
                    last_review: "1713398400",
                    evaluation_frequency: "2592000",
                    strategy: "Diminuer",
                    author_name: "Jean Dupont",
                    agent_name: "Jean Dupont",
                    validator_name: "Jean Dupont",
                    actual_probability: 4,
                    actual_impact: 3,
                    old_probability: 3,
                    old_impact: 1,
                },
                {
                    id: 2,
                    name: "Faillite ou dysfonctionnement d'un fournisseur de la commune",
                    category_name: "Approvisionnement",
                    category_label: "APP",
                    category_color: "#6E82A7",
                    last_review: "1649212800",
                    evaluation_frequency: "2592000",
                    strategy: "Supprimer",
                    author_name: "Jean Dupont",
                    agent_name: "Jean Dupont",
                    validator_name: "Jean Dupont",
                    actual_probability: 2,
                    actual_impact: 2,
                    old_probability: 4,
                    old_impact: 2,
                },
                {
                    id: 3,
                    name: "Faillite ou dysfonctionnement d'un fournisseur de la commune",
                    category_name: "Approvisionnement",
                    category_label: "APP",
                    category_color: "#6E82A7",
                    last_review: "1649212800",
                    evaluation_frequency: "2592000",
                    strategy: "Veiller",
                    author_name: "Jean Dupont",
                    agent_name: "Jean Dupont",
                    validator_name: "Jean Dupont",
                    actual_probability: 1,
                    actual_impact: 1,
                    old_probability: 1,
                    old_impact: 1,
                },
                {
                    id: 4,
                    name: "Faillite ou dysfonctionnement d'un fournisseur de la commune",
                    category_name: "Approvisionnement",
                    category_label: "APP",
                    category_color: "#6E82A7",
                    last_review: "1704067200",
                    evaluation_frequency: "2592000",
                    strategy: "Accepter",
                    author_name: "Jean Dupont",
                    agent_name: "Jean Dupont",
                    validator_name: "Jean Dupont",
                    actual_probability: 1,
                    actual_impact: 1,
                    old_probability: null,
                    old_impact: null,
                },
                {
                    id: 5,
                    name: "Faillite ou dysfonctionnement d'un fournisseur de la commune",
                    category_name: "Approvisionnement",
                    category_label: "APP",
                    category_color: "#6E82A7",
                    last_review: "",
                    evaluation_frequency: "2592000",
                    strategy: "",
                    author_name: "Jean Dupont",
                    agent_name: "Jean Dupont",
                    validator_name: "Jean Dupont",
                    actual_probability: null,
                    actual_impact: null,
                    old_probability: null,
                    old_impact: null,
                },
            ],
        };
    },

    components: {
        RiskTableBody
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
