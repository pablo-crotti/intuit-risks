<script>
import CriticityTooltip from "@/Components/Risks/CriticityTooltip.vue";
import RiskStrategy from "@/Components/Risks/RiskStrategy.vue";
import DateText from "@/Components/DateText.vue";
import ReviewInformations from "@/Components/Risks/ReviewInformations.vue";
import TendencyArrow from "@/Icons/TendencyArrow.vue";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    components: {
        CriticityTooltip,
        RiskStrategy,
        DateText,
        ReviewInformations,
        TendencyArrow,
    },
};
</script>
<template>
    <td class="px-6 py-4">
        <div class="flex justify-between gap-8">
            <div>
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                    {{ risk.name }}
                </div>
                <div
                    class="text-sm text-gray-500 dark:text-gray-400 flex items-center gap-2"
                >
                    <span
                        class="w-2 h-2 block rounded-full"
                        :style="`background-color: ${risk.category.color}`"
                    ></span>
                    {{ risk.category.name }}
                </div>
            </div>
            <button
                id="dropdownMenuIconButton"
                class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-gray-50 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none dark:text-white focus:ring-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                type="button"
            >
                <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="currentColor"
                    viewBox="0 0 4 15"
                >
                    <path
                        d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z"
                    />
                </svg>
            </button>
        </div>
    </td>
    <td class="px-6 py-4">
        <CriticityTooltip
            v-if="risk.evaluations[0].impact && risk.evaluations[0].probability"
            :id="risk.id"
            :probability="risk.evaluations[0].probability"
            :impact="risk.evaluations[0].impact"
        />
        <CriticityTooltip
            v-else
            :id="risk.id"
            :probability="risk.evaluations[0].probability"
            :impact="risk.evaluations[0].impact"
        />
    </td>
    <td class="px-6 py-4">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            <svg
                v-if="
                    risk.evaluations.length > 1
                "
                :class="`w-6 h-6 ${
                    risk.evaluations[0].probability *
                        risk.evaluations[0].impact -
                        risk.evaluations[1].probability *
                            risk.evaluations[1].impact >
                    0
                        ? 'text-red'
                        : risk.evaluations[0].probability *
                              risk.evaluations[0].impact -
                              risk.evaluations[1].probability *
                                  risk.evaluations[1].impact <
                          0
                        ? 'text-green'
                        : 'text-gray-500 dark:text-gray-400'
                }`"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <TendencyArrow
                    :tendency="
                        risk.evaluations[0].probability *
                            risk.evaluations[0].impact -
                        risk.evaluations[1].probability *
                            risk.evaluations[1].impact
                    "
                />
            </svg>
            <span v-if="!risk.evaluations.length <= 1">Aucune donnée</span>
        </div>
    </td>
    <td class="px-6 py-4">
        <RiskStrategy v-if="risk.strategy" :strategy="risk.strategy" />
        <span
            v-else
            class="text-white px-2 py-1 rounded-md bg-gray-400 dark:bg-gray-500"
            >Non définie</span
        >
    </td>
    <td class="px-6 py-4">
        <div class="text-sm text-gray-500 dark:text-gray-400">
            <div v-if="risk.evaluations[0].created_at">
                <DateText :date="risk.evaluations[0].created_at" /><br />
                <ReviewInformations
                    :lastReview="risk.evaluations[0].created_at"
                    :evaluationFrequency="risk.evaluation_frequency"
                />
            </div>
            <div v-else>
                <span class="text-red">Doit être évalué</span>
            </div>
        </div>
    </td>
</template>
