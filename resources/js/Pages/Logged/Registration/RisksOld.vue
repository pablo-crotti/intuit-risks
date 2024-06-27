<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Steps from "@/Components/Registration/Steps.vue";
import localstorage from "@/Helpers/localstorage";

defineProps({
    organization: {
        type: Object,
        default: () => {},
    },
    risks: {
        type: Object,
        default: () => {},
    },
});

const loaded = ref(false);

const selectedRisks = ref([[]]);

if (localstorage.verifyLocalStorage("selectedRisks")) {
    localstorage.getItem("selectedRisks").then((res) => {
        selectedRisks.value = res;
        loaded.value = true;
    });
} else {
    loaded.value = true;
}

const insertRisk = (riskId, categoryId, riskName, riskDesc) => {
    if (!selectedRisks.value[categoryId]) {
        selectedRisks.value[categoryId] = [];
    }

    const riskIndex = selectedRisks.value[categoryId].findIndex(
        (r) => r.id === riskId
    );

    if (riskIndex === -1) {
        const newRisk = {
            id: riskId,
            name: riskName,
            description: riskDesc,
            category: categoryId,
            probability: 1,
            impact: 1,
        };
        selectedRisks.value[categoryId].push(newRisk);
    } else {
        selectedRisks.value[categoryId].splice(riskIndex, 1);
    }
    localstorage.setItem("selectedRisks", selectedRisks.value);
};

const setEvaluation = (riskId, categoryId, key, value) => {
    const riskIndex = selectedRisks.value[categoryId].findIndex(
        (r) => r.id === riskId
    );
    selectedRisks.value[categoryId][riskIndex][key] = value;
    localstorage.setItem("selectedRisks", selectedRisks.value);
};

const isSelected = (riskId, categoryId) => {
    if (!selectedRisks.value[categoryId]) return false;
    return selectedRisks.value[categoryId].some((risk) => risk.id === riskId);
};

const form = useForm({
    selectedRisks: null,
});

const store = () => {
    form.selectedRisks = selectedRisks.value;
    form.post(route("register.risks.store"));
};
</script>
<template>
    <Head title="Sélection de risques" />
    <div class="flex justify-center py-20" v-if="loaded">
        <div class="w-3/4">
            <div class="mb-10 flex justify-between">
                <div class="w-full">
                    <Steps :step="3" />
                </div>
                <div class="w-32">
                    <PrimaryButton @click="store">Valider</PrimaryButton>
                </div>
            </div>
            <h2
                class="mb-4 text-3xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-5xl lg:text-5xl text-gray-900 dark:text-white "
            >
                Vous y êtes <span class="text-primary-400">presque</span> !
            </h2>
            <p
                class="mb-6 text-lg text-center md:text-left font-normal text-gray-900 dark:text-gray-200 lg:text-xl"
            >
                Dans cette dernière étape, vous pouvez choisir les risques
                courants spécifiques à votre type d'organisation. En
                sélectionnant ces risques, vous obtiendrez un premier aperçu de
                votre analyse de risques, personnalisée pour répondre aux
                besoins de votre organisation.
            </p>

            <div
                id="accordion-flush"
                data-accordion="collapse"
                data-active-classes="dark:bg-gray-900 text-gray-900 dark:text-white"
                data-inactive-classes="text-gray-500 dark:text-gray-400"
            >
                <span v-for="(risksGroup, category, i) in risks">
                    <h2 :id="`accordion-flush-heading-${i}`">
                        <button
                            type="button"
                            class="flex items-center justify-between w-full px-2 py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                            :data-accordion-target="`#accordion-flush-body-${i}`"
                            :aria-expanded="i === 0 ? 'true' : 'false'"
                            :aria-controls="`accordion-flush-body-${i}`"
                        >
                            <div
                                class="flex justify-start gap-2 items-center w-full"
                            >
                                <span
                                    class="w-2 h-2 block rounded-full"
                                    :style="`background-color: ${risksGroup[0].category.color}`"
                                ></span>
                                <span>{{ category }}</span>
                            </div>

                            <span class="flex justify-end w-full pr-5">
                                {{
                                    selectedRisks[risksGroup[0].category.id]
                                        ? selectedRisks[
                                              risksGroup[0].category.id
                                          ].length
                                        : 0
                                }}/{{ risksGroup.length }}</span
                            >
                            <svg
                                data-accordion-icon
                                class="w-3 h-3 rotate-180 shrink-0"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 10 6"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5 5 1 1 5"
                                />
                            </svg>
                        </button>
                    </h2>
                    <div
                        :id="`accordion-flush-body-${i}`"
                        class="hidden"
                        :aria-labelledby="`accordion-flush-heading-${i}`"
                    >
                        <div class="px-2 py-5 flex flex-wrap gap-4">
                            <div
                                class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-900 dark:border-gray-700 dark:hover:bg-gray-800"
                                v-for="risk in risksGroup"
                            >
                                <label class="flex">
                                    <div class="w-full">
                                        <p
                                            class="font-normal text-lg text-gray-900 dark:text-white"
                                        >
                                            {{ risk.name }}
                                        </p>
                                        <p
                                            class="font-normal text-gray-700 dark:text-gray-400"
                                        >
                                            {{ risk.description }}
                                        </p>
                                    </div>
                                    <div
                                        class="h-full flex justify-end items-center w-16"
                                    >
                                        <input
                                            :checked="
                                                isSelected(
                                                    risk.id,
                                                    risk.category.id
                                                )
                                            "
                                            id="red-checkbox"
                                            type="checkbox"
                                            value=""
                                            @click="
                                                insertRisk(
                                                    risk.id,
                                                    risk.category.id,
                                                    risk.name,
                                                    risk.description
                                                )
                                            "
                                            class="w-6 h-6 text-red-600 bg-gray-100 border-gray-300 rounded dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 hover:cursor-pointer"
                                        />
                                    </div>
                                </label>
                                <div
                                    v-if="isSelected(risk.id, risk.category.id)"
                                    class="w-full mt-4 pt-4"
                                >
                                    <div class="relative mb-12">
                                        <label
                                            for="labels-range-input"
                                            class="font-normal text-lg text-gray-700 dark:text-white"
                                            >Probabilité</label
                                        >
                                        <input
                                            id="labels-range-input"
                                            type="range"
                                            :value="
                                                selectedRisks[
                                                    risk.category.id
                                                ].find((r) => r.id === risk.id)
                                                    .probability
                                            "
                                            @input="
                                                setEvaluation(
                                                    risk.id,
                                                    risk.category.id,
                                                    'probability',
                                                    $event.target.value
                                                )
                                            "
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
                                            :value="
                                                selectedRisks[
                                                    risk.category.id
                                                ].find((r) => r.id === risk.id)
                                                    .impact
                                            "
                                            @input="
                                                setEvaluation(
                                                    risk.id,
                                                    risk.category.id,
                                                    'impact',
                                                    $event.target.value
                                                )
                                            "
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>
</template>
