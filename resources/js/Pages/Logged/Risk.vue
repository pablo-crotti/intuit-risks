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
import UserNameAndImg from "@/Components/UserNameAndImg.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Loader from "@/Components/Loader.vue";
import DropdownRadio from "@/Components/DropdownRadio.vue";
import askMistral from "@/Helpers/askMistral";
import DangerIcon from "@/Icons/DangerIcon.vue";

const props = defineProps({
    risk: {
        type: Object,
        required: true,
    },
});

const selectedEvaluation = ref(0);
const manualClose = ref(false);
const precursors = ref(props.risk.precursors || []);
const sign = ref("");
const precursorsToDelete = ref([]);
const loading = ref(false);
const precursorsUpdated = ref(false);

const newEvaluationForm = useForm({
    probability: props.risk.evaluations[0].probability,
    impact: props.risk.evaluations[0].impact,
    risk_id: props.risk.id,
});

const addPrecursor = () => {
    const prc = {
        name: sign.value,
        id: 0,
    };
    precursors.value.push(prc);
    sign.value = "";
    precursorsUpdated.value = true;
};

const deletePrecursor = (index, id) => {
    if (id) {
        precursorsToDelete.value.push(id);
        precursorsUpdated.value = true;
    }
    precursors.value.splice(index, 1);
};

const generatePrecursors = async () => {
    loading.value = true;
    const riskForIA = {
        name: props.risk.name,
        description: props.risk.description,
        category: props.risk.category.name,
        precursors: precursors.value,
        probability: props.risk.evaluations[0].probability,
        impact: props.risk.evaluations[0].impact,
    };

    const company = await axios.get(route("company.index"));
    const companyForAI = {
        sector: company.data.sector,
        employees: company.data.employees,
        country: company.data.country.name,
        city: company.data.city,
        organization_type: company.data.organization_type.name,
    };
    const precursorsFromAI = await askMistral.askPrecursors(
        riskForIA,
        companyForAI
    );

    precursorsFromAI.precursors.forEach((precursor) => {
        const prc = {
            name: precursor.title,
            id: 0,
        };
        precursors.value.push(prc);
    });
    loading.value = false;
    precursorsUpdated.value = true;
};

const storeNewEvaluation = () => {
    newEvaluationForm.post(route("evaluations.store"), {
        onSuccess: () => {
            newEvaluationForm.reset();
            manualClose.value = true;
        },
    });
};
const storePrecursors = () => {
    if (precursors.value.length > 0) {
        const newPrecursors = precursors.value.filter((precursor) => {
            return precursor.id === 0;
        });

        if (newPrecursors.length > 0) {
            const precursorsToStore = useForm({
                precursors: newPrecursors,
                risk_id: props.risk.id,
            });

            precursorsToStore.post(route("precursors.store"), {
                onSuccess: () => {
                    precursorsToStore.reset();
                    manualClose.value = true;
                    precursors.value = props.risk.precursors;
                },
            });
        }
    }

    if (precursorsToDelete.value.length > 0) {
        const precursorsToDeleteForm = useForm({
            precursors: precursorsToDelete.value,
        });

        precursorsToDeleteForm.delete(route("precursors.delete"), {
            onSuccess: () => {
                precursorsToDeleteForm.reset();
                precursorsToDelete.value = [];
                manualClose.value = true;
            },
        });
    }

    precursorsUpdated.value = false;
};
const updatePrecursors = (id, status) => {
    const updatePrecursors = useForm({
        status: status,
        id: id,
    });

    updatePrecursors.patch(route("precursors.update"), {
        onSuccess: () => {
            updatePrecursors.reset();
        },
    });

    manualClose.value = true;
};
</script>
<template>
    <AuthenticatedLayout>
        <Loader v-if="loading" />
        <Head title="Risques" />
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
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
                <div class="px-4 py-4">
                    <div class="flex gap-4 mb-4">
                        <strong
                            class="font-semibold text-gray-900 dark:text-white"
                            >Créateur</strong
                        >
                        <UserNameAndImg :user_name="risk.author.name" />
                    </div>
                </div>

                <div class="px-4 py-4 flex justify-between items-center mt-4">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Signes avant coureurs
                    </h2>
                    <div class="w-24">
                        <CustomModal
                            :id="`update-signs-${risk.id}`"
                            :manualClose="manualClose"
                            @manualClosed="() => (manualClose = false)"
                            title="Signes avant coureurs"
                        >
                            <template v-slot:body>
                                <div class="w-full">
                                    <div class="mb-4">
                                        <button
                                            @click="generatePrecursors"
                                            class="text-gray-700 dark:text-gray-300 hover:text-primary-500 flex gap-2 items-center"
                                        >
                                            Génération IA
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="size-5"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"
                                                    clip-rule="evenodd"
                                                />
                                                <path
                                                    d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z"
                                                />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="mb-8 flex justify-between">
                                        <InputLabel
                                            for="signs"
                                            :value="`Signes avant coureurs`"
                                        />
                                        <TextInput
                                            id="signs"
                                            v-model="sign"
                                            placeholder="Signes avant coureurs"
                                        />
                                        <div class="w-28 ml-4">
                                            <PrimaryButtonMono
                                                @click="addPrecursor"
                                                >Ajouter</PrimaryButtonMono
                                            >
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-4">
                                        <div
                                            v-for="(
                                                precursor, index
                                            ) in precursors"
                                            :key="precursor"
                                            class="flex justify-between items-center px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-800"
                                        >
                                            <p
                                                class="text-base font-normal text-gray-700 dark:text-gray-300"
                                            >
                                                {{ precursor.name }}
                                            </p>
                                            <button
                                                class="bg-red rounded-md hover:opacity-85 w-6 h-6 flex justify-center items-center ml-6"
                                                @click="
                                                    deletePrecursor(
                                                        index,
                                                        precursor.id
                                                    )
                                                "
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    class="size-6 text-white"
                                                    stroke-width="1.5"
                                                    stroke="currentColor"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M6 18 18 6M6 6l12 12"
                                                    />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <template v-slot:footer>
                                <div class="w-full flex justify-end gap-4">
                                    <div class="w-30">
                                        <PrimaryButtonMono
                                            :data-modal-hide="`update-signs-${risk.id}`"
                                            >Annuler</PrimaryButtonMono
                                        >
                                    </div>
                                    <div class="w-30">
                                        <PrimaryButton
                                            @click="storePrecursors"
                                            :disabled="!precursorsUpdated"
                                            :class="
                                                !precursorsUpdated
                                                    ? 'opacity-50'
                                                    : ''
                                            "
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
                <div class="px-4 py-4 flex flex-col gap-4">
                    <div
                        v-for="precursor in risk.precursors"
                        class="flex flex-col gap-4 px-4 py-2 rounded-lg bg-gray-100 dark:bg-gray-700"
                    >
                        <p
                            class="text-base font-normal text-gray-700 dark:text-gray-300"
                        >
                            {{ precursor.name }}
                        </p>
                        <div class="flex justify-end">
                            <DropdownRadio
                                :id="`dropdown-${precursor.id}`"
                                :manualClose="manualClose"
                                @manualClosed="() => (manualClose = false)"
                            >
                                <template v-slot:button>
                                    <DangerIcon :danger="precursor.status" />
                                </template>
                                <template v-slot:radio>
                                    <li>
                                        <label
                                            class="flex p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >
                                            <div
                                                class="w-full flex gap-2 grid-cols-3 items-center"
                                            >
                                                <input
                                                    :name="`helper-radio-${precursor.id}`"
                                                    type="radio"
                                                    :checked="
                                                        precursor.status == 0
                                                    "
                                                    @change="
                                                        updatePrecursors(
                                                            precursor.id,
                                                            0
                                                        )
                                                    "
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <span
                                                    class="w-full font-medium text-gray-900 dark:text-gray-300"
                                                    >Aucun signe</span
                                                >
                                                <div
                                                    class="w-full flex justify-end"
                                                >
                                                    <DangerIcon :danger="0" />
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >
                                            <div
                                                class="w-full flex gap-2 grid-cols-3 items-center"
                                            >
                                                <input
                                                    :name="`helper-radio-${precursor.id}`"
                                                    type="radio"
                                                    :checked="
                                                        precursor.status == 1
                                                    "
                                                    @change="
                                                        updatePrecursors(
                                                            precursor.id,
                                                            1
                                                        )
                                                    "
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <span
                                                    class="w-full font-medium text-gray-900 dark:text-gray-300"
                                                    >À surveiller</span
                                                >
                                                <div
                                                    class="w-full flex justify-end"
                                                >
                                                    <DangerIcon :danger="1" />
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                    <li>
                                        <label
                                            class="flex p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600"
                                        >
                                            <div
                                                class="w-full flex gap-2 grid-cols-3 items-center"
                                            >
                                                <input
                                                    :name="`helper-radio-${precursor.id}`"
                                                    type="radio"
                                                    :checked="
                                                        precursor.status == 2
                                                    "
                                                    @change="
                                                        updatePrecursors(
                                                            precursor.id,
                                                            2
                                                        )
                                                    "
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                                />
                                                <span
                                                    class="w-full font-medium text-gray-900 dark:text-gray-300"
                                                    >En cours</span
                                                >
                                                <div
                                                    class="w-full flex justify-end"
                                                >
                                                    <DangerIcon :danger="2" />
                                                </div>
                                            </div>
                                        </label>
                                    </li>
                                </template>
                            </DropdownRadio>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <div class="px-4 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Évaluation
                    </h2>

                    <div class="w-24">
                        <CustomModal
                            :buttonTitle="`Évaluer`"
                            :manualClose="manualClose"
                            :id="`new-evaluation-${risk.id}`"
                            @manualClosed="() => (manualClose = false)"
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
                                            :data-modal-hide="`new-evaluation-${risk.id}`"
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
                </div>
                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="w-full">
                    <RiskChart :evaluations="risk.evaluations" />
                </div>
            </div>

            <div class="bg-white rounded-md dark:bg-gray-800">
                <div class="px-4 py-4 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                        Stratégie
                    </h2>

                    <div class="w-24">
                        
                    </div>
                </div>

                <span
                    class="w-full h-1 block bg-gray-200 dark:bg-gray-900"
                ></span>
                <div class="px-4 py-4">
                    
                </div>
                
            </div>
        </div>
    </AuthenticatedLayout>
</template>
