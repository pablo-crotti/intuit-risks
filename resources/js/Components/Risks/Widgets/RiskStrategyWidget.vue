<script>
import { initFlowbite } from "flowbite";
import { useForm } from "@inertiajs/vue3";

import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import NewReductionPlanTask from "@/Components/Risks/Forms/NewReductionPlanTask.vue";
import ReductionPlanTaskCard from "@/Components/Risks/Components/ReductionPlanTaskCard.vue";
import InfosModal from "@/Components/InfosModal.vue";

export default {
    props: {
        strategy: {
            type: String,
            required: true,
        },
        risk: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {};
    },

    components: {
        WidgetLayout,
        NewReductionPlanTask,
        ReductionPlanTaskCard,
        InfosModal,
    },
    methods: {
        updateStrategy(strategy) {
            const form = useForm({
                strategy,
            });

            form.put(`/api/risks/${this.risk.id}/strategy`, {
                onSuccess: () => {
                    const closeButton = document.querySelector(
                        "#dropdownStratDefaultButton"
                    );

                    if (closeButton) {
                        const open = document.querySelector("#dropdown-strat");
                        if (!open.classList.contains("hidden")) {
                            const clickEvent = new MouseEvent("click", {
                                bubbles: true,
                                cancelable: true,
                                view: window,
                            });
                            closeButton.dispatchEvent(clickEvent);
                        }
                    }
                },
            });
        },

        countPrecursors(status) {
            return this.risk.precursors.filter(
                (precursor) => precursor.status == status
            ).length;
        },
    },
    mounted() {
        if (!this.strategy) {
            this.strategy = "Non définie";
        }
        initFlowbite();
    },
};
</script>

<template>
    <WidgetLayout>
        <template #title> Stratégie </template>
        <template #action>
            <div class="flex gap-2 items-center">
                <InfosModal title="La stratégie" id="strat-infos-modal">
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        La stratégie de gestion des risques consiste à choisir
                        comment traiter chaque risque. Les options incluent :
                        accepter, supprimer, veiller et diminuer.
                    </p>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        <strong>Accepter :</strong> Décider de ne pas prendre de
                        mesures spécifiques et accepter les conséquences
                        potentielles du risque.
                    </p>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        <strong>Supprimer :</strong> Prendre des mesures pour
                        éliminer complètement le risque.
                    </p>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        <strong>Veiller :</strong> Surveiller activement le
                        risque en analysant les signes avant-coureurs pour
                        anticiper et réagir rapidement en cas de changement.
                    </p>
                    <p
                        class="text-base leading-relaxed text-gray-500 dark:text-gray-400"
                    >
                        <strong>Diminuer :</strong> Mettre en place des mesures
                        préventives pour réduire l'impact ou la probabilité du
                        risque. Les utilisateurs peuvent également indiquer
                        l'efficacité de ces mesures pour évaluer leur pertinence
                        et ajuster les stratégies en conséquence.
                    </p>
                </InfosModal>
                <button
                    id="dropdownStratDefaultButton"
                    data-dropdown-toggle="dropdown-strat"
                    :class="`${
                        strategy == 'Non définie'
                            ? 'bg-gray-400 dark:bg-gray-500'
                            : strategy == 'Supprimer'
                            ? 'bg-red'
                            : strategy == 'Diminuer'
                            ? 'bg-orange'
                            : strategy == 'Veiller'
                            ? 'bg-blue'
                            : strategy == 'Accepter'
                            ? 'bg-green'
                            : ''
                    } text-white w-max focus:outline-none font-medium rounded-lg text-sm px-5 py-1.5 text-center inline-flex items-center`"
                    type="button"
                >
                    {{ strategy }}
                    <svg
                        class="w-2.5 h-2.5 ms-3"
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
                            d="m1 1 4 4 4-4"
                        />
                    </svg>
                </button>
                <div
                    id="dropdown-strat"
                    class="z-10 hidden bg-gray-100 divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                >
                    <ul
                        class="py-2 text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownStratDefaultButton"
                    >
                        <li>
                            <button
                                @click="updateStrategy('Supprimer')"
                                :class="`${
                                    strategy == 'Supprimer'
                                        ? 'bg-white dark:bg-gray-600'
                                        : ''
                                } block w-full text-left px-4 py-2 hover:bg-white dark:hover:bg-gray-600 dark:hover:text-white`"
                            >
                                <div class="flex gap-4 items-center">
                                    <span
                                        class="block w-4 h-4 bg-red rounded-full"
                                    ></span>
                                    Supprimer
                                </div>
                            </button>
                        </li>

                        <li>
                            <button
                                @click="updateStrategy('Diminuer')"
                                :class="`${
                                    strategy == 'Diminuer'
                                        ? 'bg-white dark:bg-gray-600'
                                        : ''
                                } block w-full text-left px-4 py-2 hover:bg-white dark:hover:bg-gray-600 dark:hover:text-white`"
                            >
                                <div class="flex gap-4 items-center">
                                    <span
                                        class="block w-4 h-4 bg-orange rounded-full"
                                    ></span>
                                    Diminuer
                                </div>
                            </button>
                        </li>
                        <li>
                            <button
                                @click="updateStrategy('Veiller')"
                                :class="`${
                                    strategy == 'Veiller'
                                        ? 'bg-white dark:bg-gray-600'
                                        : ''
                                } block w-full text-left px-4 py-2 hover:bg-white dark:hover:bg-gray-600 dark:hover:text-white`"
                            >
                                <div class="flex gap-4 items-center">
                                    <span
                                        class="block w-4 h-4 bg-blue rounded-full"
                                    ></span>
                                    Veiller
                                </div>
                            </button>
                        </li>

                        <li>
                            <button
                                @click="updateStrategy('Accepter')"
                                :class="`${
                                    strategy == 'Accepter'
                                        ? 'bg-white dark:bg-gray-600'
                                        : ''
                                } block w-full text-left px-4 py-2 hover:bg-white dark:hover:bg-gray-600 dark:hover:text-white`"
                            >
                                <div class="flex gap-4 items-center">
                                    <span
                                        class="block w-4 h-4 bg-green rounded-full"
                                    ></span>
                                    Accepter
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </template>
        <template #content>
            <div class="py-4">
                <div v-if="strategy == 'Veiller'">
                    <div
                        class="flex flex-col gap-4"
                        v-if="risk.precursors.length > 0"
                    >
                        <div class="flex justify-end mb-4">
                            <span
                                :class="`${
                                    (countPrecursors(2) +
                                        countPrecursors(1) / 2) /
                                        risk.precursors.length >
                                    0.6
                                        ? 'bg-red'
                                        : (countPrecursors(2) +
                                              countPrecursors(1) / 2) /
                                              risk.precursors.length >
                                          0.3
                                        ? 'bg-orange'
                                        : 'bg-green'
                                } px-4 py-2 w-max text-center text-white rounded-lg`"
                                >Dangerosité :
                                {{
                                    countPrecursors(2) + countPrecursors(1) / 2
                                }}
                                / {{ risk.precursors.length }}</span
                            >
                        </div>
                        <span
                            class="px-4 py-2 text-center bg-red text-white rounded-lg"
                            >Dangereux : {{ countPrecursors(2) }}</span
                        >
                        <span
                            class="px-4 py-2 text-center bg-orange text-white rounded-lg"
                            >Potentillement dangereux :
                            {{ countPrecursors(1) }}</span
                        >
                        <span
                            class="px-4 py-2 text-center bg-green text-white rounded-lg"
                            >Sans danger : {{ countPrecursors(0) }}</span
                        >
                    </div>
                    <p
                        v-else
                        class="text-gray-500 justify-center dark:text-gray-400 flex items-center gap-2"
                    >
                        Définissez des signes avant coureurs pour optenir des
                        indicateurs.
                    </p>
                </div>
                <div v-else-if="strategy == 'Diminuer'">
                    <div class="flex justify-center mb-4">
                        <div class="w-max">
                            <NewReductionPlanTask
                                v-if="
                                    (risk.responsible_id &&
                                        risk.responsible.id ==
                                            $page.props.auth.user.id) ||
                                    risk.author_id == $page.props.auth.user.id
                                "
                                :risk="risk"
                                :tasks="risk.reduction_plan_tasks"
                            />
                        </div>
                    </div>
                    <div
                        class="flex flex-col px-2 gap-4 mb-4 max-h-96 overflow-y-auto"
                        v-if="risk.reduction_plan_tasks.length > 0"
                    >
                        <div v-for="task in risk.reduction_plan_tasks">
                            <ReductionPlanTaskCard
                                :task="task"
                                :responsible_id="
                                    risk.responsible
                                        ? risk.responsible.id
                                        : null
                                "
                                :author_id="risk.author_id"
                            />
                        </div>
                    </div>

                    <p
                        v-else
                        class="text-gray-500 justify-center dark:text-gray-400 flex items-center gap-2 mb-4"
                    >
                        Définissez des actions de réduction pour pouvoir les
                        tester.
                    </p>
                </div>
                <p
                    v-else-if="strategy == 'Supprimer'"
                    class="text-gray-500 justify-center dark:text-gray-400 flex items-center gap-2"
                >
                    Ce risque a été jugé inacceptable et doit donc être
                    supprimé.
                </p>
                <p
                    v-else-if="strategy == 'Accepter'"
                    class="text-gray-500 justify-center dark:text-gray-400 flex items-center gap-2"
                >
                    Ce risque a été jugé acceptable. Pour l'intant, il n'est pas
                    nécessaire d'entreprendre d'autres mesures.
                </p>

                <p
                    v-else
                    class="text-gray-500 justify-center dark:text-gray-400 flex items-center gap-2"
                >
                    Aucune stratégie déinie.
                </p>
            </div>
        </template>
    </WidgetLayout>
</template>
