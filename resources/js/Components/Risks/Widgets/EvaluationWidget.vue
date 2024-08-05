<script>
import { initFlowbite } from "flowbite";
import { useForm } from "@inertiajs/vue3";

import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import CustomModal from "@/Components/CustomModal.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DateText from "@/Components/DateText.vue";
import ProbabilityAndImpactTooltip from "@/Components/Risks/Components/ProbabilityAndImpactTooltip.vue";
import InfosModal from "@/Components/InfosModal.vue";
import ProbabilityAndImpactSelect from "@/Components/Risks/Forms/ProbabilityAndImpactSelect.vue";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            selectedEvaluation: 0,
            manualClose: false,
            newEvaluationForm: useForm({
                probability: this.risk.evaluations[0].probability,
                impact: this.risk.evaluations[0].impact,
                risk_id: this.risk.id,
            }),
        };
    },
    components: {
        WidgetLayout,
        CustomModal,
        InputError,
        PrimaryButtonMono,
        PrimaryButton,
        DateText,
        ProbabilityAndImpactTooltip,
        InfosModal,
        ProbabilityAndImpactSelect,
    },
    methods: {
        storeNewEvaluation() {
            this.newEvaluationForm.post(route("evaluations.store"), {
                onSuccess: () => {
                    this.newEvaluationForm.reset();
                    this.manualClose = true;
                },
            });
        },
    },
    mounted() {
        initFlowbite();
    },
};
</script>

<template>
    <WidgetLayout>
        <template #title> Évaluation </template>
        <template #action>
            <div class="flex gap-2 items-center">
                <InfosModal title="Les évaluations" id="eval-infos-modal">
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        Les évaluations du risque permettent de mesurer l'impact
                        et la probabilité d'un risque. Ces évaluations sont
                        cruciales pour comprendre la gravité d'un risque et pour
                        planifier les actions nécessaires à sa mitigation.
                    </p>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        Les utilisateurs peuvent naviguer dans l'historique des
                        évaluations pour voir comment le risque a évolué au fil
                        du temps. Cette fonctionnalité permet de suivre les
                        changements dans l'impact et la probabilité du risque et
                        d'ajuster les stratégies de gestion en conséquence.
                    </p>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        Il est également possible d'ajouter une nouvelle
                        évaluation. Cela implique de réévaluer l'impact du
                        risque sur l'organisation et la probabilité de son
                        occurrence. Ces nouvelles données sont ensuite
                        enregistrées et ajoutées à l'historique.
                    </p>
                </InfosModal>
                <CustomModal
                    :buttonTitle="`Évaluer`"
                    :manualClose="manualClose"
                    :id="`new-evaluation-${risk.id}`"
                    @manualClosed="() => (manualClose = false)"
                    title="Nouvelle évaluation"
                >
                    <template #body>
                        <div class="w-full">
                            <ProbabilityAndImpactSelect
                                :probability="newEvaluationForm.probability"
                                :impact="newEvaluationForm.impact"
                                @update:probability="
                                    (e) => {
                                        newEvaluationForm.probability = e;
                                    }
                                "
                                @update:impact="
                                    (e) => {
                                        newEvaluationForm.impact = e;
                                    }
                                "
                            />
                            <!-- <div class="relative mb-12">
                                <label
                                    for="labels-range-input"
                                    class="font-normal text-lg text-gray-700 dark:text-white"
                                    >Probabilité</label
                                >
                                <input
                                    id="labels-range-input"
                                    type="range"
                                    v-model="newEvaluationForm.probability"
                                    min="1"
                                    max="4"
                                    class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-700"
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
                                    class="w-full h-1 bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-700"
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
                            </div> -->
                        </div>
                        <div class="pt-4">
                            <InputError
                                v-if="newEvaluationForm.errors.probability"
                                class="mt-2"
                                :message="newEvaluationForm.errors.probability"
                            />
                            <InputError
                                v-if="newEvaluationForm.errors.impact"
                                class="mt-2"
                                :message="newEvaluationForm.errors.impact"
                            />
                            <InputError
                                v-if="newEvaluationForm.errors.risk_id"
                                class="mt-2"
                                :message="newEvaluationForm.errors.risk_id"
                            />
                        </div>
                    </template>
                    <template #footer>
                        <div class="w-full flex justify-end gap-4">
                            <div class="w-30">
                                <PrimaryButtonMono
                                    :data-modal-hide="`new-evaluation-${risk.id}`"
                                    >Annuler</PrimaryButtonMono
                                >
                            </div>
                            <div class="w-30">
                                <PrimaryButton @click="storeNewEvaluation"
                                    >Enregistrer</PrimaryButton
                                >
                            </div>
                        </div>
                    </template>
                </CustomModal>
            </div>
        </template>
        <template #content>
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
                    <strong class="font-semibold text-gray-900 dark:text-white"
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
                    <strong class="font-semibold text-gray-900 dark:text-white"
                        >Impact</strong
                    >

                    <ProbabilityAndImpactTooltip
                        type="impact"
                        :value="risk.evaluations[selectedEvaluation].impact"
                    />
                </div>
            </div>
        </template>
    </WidgetLayout>
</template>
