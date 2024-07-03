<script>
import Widget from "@/Layouts/WidgetLayout.vue";
import CriticityTooltip from "@/Components/Risks/Components/CriticityTooltip.vue";

export default {
    props: {
        evaluations: {
            type: Array,
            default: () => [],
        },
    },
    data: function () {
        return {
            options: {
                chart: {
                    height: "100%",
                    maxWidth: "100%",
                    type: "area",
                    fontFamily: "Inter, sans-serif",
                    dropShadow: {
                        enabled: false,
                    },
                    toolbar: {
                        show: false,
                    },
                },
                tooltip: {
                    enabled: true,
                    x: {
                        show: false,
                    },
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                        shade: "#0E7C7B",
                        gradientToColors: ["#0E7C7B"],
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: 6,
                },
                grid: {
                    show: false,
                    strokeDashArray: 4,
                    padding: {
                        left: 2,
                        right: 2,
                        top: 0,
                    },
                },
                series: [
                    {
                        name: "Criticité",
                        data: [6500, 6418, 6456, 6526, 6356, 6456],
                        color: "#0E7C7B",
                    },
                ],
                xaxis: {
                    categories: [
                        "01 February",
                        "02 February",
                        "03 February",
                        "04 February",
                        "05 February",
                        "06 February",
                        "07 February",
                    ],
                    labels: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                },
                yaxis: {
                    show: false,
                },
            },
            variance: 0,
            percentage_color: "text-gray-500 dark:text-gray-400",
            selectedPeriod: 3,
        };
    },
    components: {
        Widget,
        CriticityTooltip,
    },
    methods: {
        renderChart() {
            if (typeof ApexCharts !== "undefined") {
                const chart = new ApexCharts(
                    document.getElementById("area-chart"),
                    this.options
                );
                chart.render();
            }
        },
        formatDate(dateString) {
            const options = { day: "numeric", month: "long", year: "numeric" };
            const date = new Date(dateString);
            return date.toLocaleDateString("fr-FR", options);
        },
        formatEvaluations() {
            let evaluationData = [];
            let evaluationDates = [];

            let timeRange = 0;

            if (this.selectedPeriod == 1) {
                timeRange = 30; // 1 mois
            } else if (this.selectedPeriod == 2) {
                timeRange = 90; // 3 mois
            } else if (this.selectedPeriod == 3) {
                timeRange = 180; // 6 mois
            } else if (this.selectedPeriod == 4) {
                timeRange = 365; // 1 an
            } else if (this.selectedPeriod == 5) {
                timeRange = 730; // 2 ans
            }

            const actualEvaluations = this.evaluations;
            const now = new Date();
            const filteredEvaluations = actualEvaluations.filter(
                (evaluation) => {
                    const createdAt = new Date(evaluation.created_at);
                    const timeDifference =
                        (now - createdAt) / (1000 * 60 * 60 * 24);
                    return timeDifference <= timeRange;
                }
            );

            if (filteredEvaluations.length > 1) {
                const lastEvaluation =
                    filteredEvaluations[0].probability *
                    filteredEvaluations[0].impact;

                const previousEvaluation =
                    filteredEvaluations[filteredEvaluations.length - 1]
                        .probability *
                    filteredEvaluations[filteredEvaluations.length - 1].impact;

                this.variance = lastEvaluation - previousEvaluation;
                if (this.variance < 0) {
                    this.percentage_color = "text-green";
                } else if (this.variance > 0) {
                    this.percentage_color = "text-red";
                } else {
                    this.percentage_color = "text-gray-500 dark:text-gray-400";
                }
            }

            filteredEvaluations.reverse();

            filteredEvaluations.map((evaluation) => {
                evaluationData.push(evaluation.probability * evaluation.impact);
                evaluationDates.push(this.formatDate(evaluation.created_at));
            });

            this.options.series[0].data = evaluationData;
            this.options.xaxis.categories = evaluationDates;

            this.renderChart();
        },
        setNewPeriod(period) {
            this.selectedPeriod = period;
            this.formatEvaluations();
        },
        getPeriodName(period) {
            switch (period) {
                case 1:
                    return "1 mois";
                case 2:
                    return "3 mois";
                case 3:
                    return "6 mois";
                case 4:
                    return "1 an";
                case 5:
                    return "2 ans";
            }
        },
    },
    mounted() {
        initFlowbite();
        this.formatEvaluations();
    },
};
</script>

<template>
    <Widget>
        <template #title> Évolution </template>
        <template #content>
            <div class="w-full bg-white rounded-lg dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between">
                    <div>
                        <h5
                            class="leading-none text-3xl font-bold text-gray-900 dark:text-white pb-2"
                        >
                            <CriticityTooltip
                                :id="1"
                                :probability="evaluations[0].probability"
                                :impact="evaluations[0].impact"
                            />
                        </h5>
                        <p
                            class="text-base font-normal text-gray-500 dark:text-gray-400"
                        >
                            Criticité actuelle
                        </p>
                    </div>
                    <div
                        :class="`flex items-center px-2.5 py-0.5 text-base font-semibold ${percentage_color} text-center`"
                    >
                        {{ variance }}
                        <svg
                            class="w-3 h-3 ms-1"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 10 14"
                            :transform="
                                variance < 0 ? 'rotate(180)' : 'rotate(0)'
                            "
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13V1m0 0L1 5m4-4 4 4"
                            />
                        </svg>
                    </div>
                </div>
                <div id="area-chart"></div>
                <div
                    class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between"
                >
                    <div class="flex justify-between items-center pt-5">
                        <button
                            id="dropdownDefaultButton"
                            data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button"
                        >
                            {{ getPeriodName(selectedPeriod) }}
                            <svg
                                class="w-2.5 m-2.5 ms-1.5"
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
                            id="lastDaysdropdown"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700"
                        >
                            <ul
                                class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownDefaultButton"
                            >
                                <li>
                                    <button
                                        @click="setNewPeriod(1)"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        {{ getPeriodName(1) }}
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="setNewPeriod(2)"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        {{ getPeriodName(2) }}
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="setNewPeriod(3)"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        {{ getPeriodName(3) }}
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="setNewPeriod(4)"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        {{ getPeriodName(4) }}
                                    </button>
                                </li>
                                <li>
                                    <button
                                        @click="setNewPeriod(5)"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                    >
                                        {{ getPeriodName(5) }}
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Widget>
</template>
