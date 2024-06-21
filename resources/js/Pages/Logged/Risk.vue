<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, ref, watch } from "vue";
import RiskAndCategory from "@/Components/Risks/RiskAndCategory.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DateText from "@/Components/DateText.vue";
import ProbabilityAndImpactTooltip from "@/Components/Risks/ProbabilityAndImpactTooltip.vue";
import CustomModal from "@/Components/CustomModal.vue";
import InputError from "@/Components/InputError.vue";
import RiskChart from "@/Components/Risks/RiskChart.vue";

const props = defineProps({
    risk: {
        type: Object,
        required: true,
    },
});

const selectedEvaluation = ref(0);
const manualClose = ref(false);

const newEvaluationForm = useForm({
    probability: props.risk.evaluations[0].probability,
    impact: props.risk.evaluations[0].impact,
    risk_id: props.risk.id,
});

const storeNewEvaluation = () => {
    newEvaluationForm.post(route("evaluations.store"), {
        onSuccess: () => {
            newEvaluationForm.reset();
            manualClose.value = true;
        },
    });
};
</script>
<template>

    <AuthenticatedLayout>
        <Head title="Risques" />
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-md dark:bg-gray-800">
                <div class="px-4 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Propriétés
                    </h2>

                    <div class="w-24">
                        <SecondaryButton>Modifier</SecondaryButton>
                    </div>
                </div>
                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="px-4 py-4">
                    <RiskAndCategory
                        :name="risk.name"
                        :category_name="risk.category.name"
                        :category_color="risk.category.color"
                    />
                </div>
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <div class="px-4 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Évaluation
                    </h2>

                    <div class="w-24">
                        <CustomModal
                            :manualClose="manualClose"
                            title="Nouvelle évaluation"
                        >
                            <template v-slot:body>
                                <div class="w-full">
                                    <div class="relative mb-12">
                                        <label
                                            for="labels-range-input"
                                            class="font-normal text-lg text-gray-700 dark:text-white"
                                            >Probabilité</label
                                        >
                                        <input
                                            id="labels-range-input"
                                            type="range"
                                            v-model="
                                                newEvaluationForm.probability
                                            "
                                            min="1"
                                            max="4"
                                            class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-800"
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
                                            v-model="newEvaluationForm.impact"
                                            min="1"
                                            max="4"
                                            class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-800"
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
                                </div>
                                <div class="pt-4">
                                    <InputError
                                        v-if="
                                            newEvaluationForm.errors.probability
                                        "
                                        class="mt-2"
                                        :message="
                                            newEvaluationForm.errors.probability
                                        "
                                    />
                                    <InputError
                                        v-if="newEvaluationForm.errors.impact"
                                        class="mt-2"
                                        :message="
                                            newEvaluationForm.errors.impact
                                        "
                                    />
                                    <InputError
                                        v-if="newEvaluationForm.errors.risk_id"
                                        class="mt-2"
                                        :message="
                                            newEvaluationForm.errors.risk_id
                                        "
                                    />
                                </div>
                            </template>
                            <template v-slot:footer>
                                <div class="w-full flex justify-end gap-4">
                                    <div class="w-30">
                                        <PrimaryButtonMono
                                            data-modal-hide="default-modal"
                                            >Annuler</PrimaryButtonMono
                                        >
                                    </div>
                                    <div class="w-30">
                                        <PrimaryButton
                                            @click="storeNewEvaluation"
                                            >Enregistrer</PrimaryButton
                                        >
                                    </div>
                                </div>
                            </template>
                        </CustomModal>
                    </div>
                </div>

                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="px-4 py-4">
                    <div>
                        <select
                            id="organization"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            @change="selectedEvaluation = $event.target.value"
                        >
                            <option
                                v-for="(evaluation, index) in risk.evaluations"
                                :value="index"
                            >
                                <DateText :date="evaluation.created_at" />
                                <span v-if="index == 0">(Actuelle)</span>
                            </option>
                        </select>
                    </div>
                </div>
                <div class="px-4 py-4">
                    <div class="grid grid-cols-2 mb-4">
                        <strong
                            class="font-semibold text-gray-900 dark:text-white"
                            >Probabilité</strong
                        >
                        <ProbabilityAndImpactTooltip
                            type="probability"
                            :value="
                                risk.evaluations[selectedEvaluation].probability
                            "
                        />
                    </div>
                    <div class="grid grid-cols-2">
                        <strong
                            class="font-semibold text-gray-900 dark:text-white"
                            >Impact</strong
                        >

                        <ProbabilityAndImpactTooltip
                            type="impact"
                            :value="risk.evaluations[selectedEvaluation].impact"
                        />
                    </div>
                </div>

                <div class="px-4 py-4 flex justify-between items-center mt-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Évolution
                    </h2>

                    <div class="w-24">
                    </div>
                    
                </div>
                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="w-full">
                    <RiskChart :evaluations="risk.evaluations" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
