<script>
import RiskTableBody from "@/Components/Risks/Components/RiskTableBody.vue";
import Pagination from "@/Components/Pagination.vue";
import DropdownRadio from "@/Components/DropdownRadio.vue";

export default {
    props: {
        risks: {
            type: Array,
            required: true,
        },
    },
    data: () => ({
        ordered: {
            title: null,
            criticity: "up",
            tendency: null,
            strategy: null,
            lastReview: null,
        },
        categories: [],
        selectedCategories: [],
        strategies: [
            {
                id: 1,
                name: "Supprimer",
                color: "bg-red",
            },
            {
                id: 2,
                name: "Diminuer",
                color: "bg-orange",
            },
            {
                id: 3,
                name: "Veiller",
                color: "bg-blue",
            },
            {
                id: 4,
                name: "Accepter",
                color: "bg-green",
            },
        ],
        selectedStrategies: [],
        pages: null,
        maxPerPage: 10,
        actualPage: 1,
        pageRisks: [],
        shownRisks: [],

        searching: false,
    }),
    components: {
        RiskTableBody,
        Pagination,
        DropdownRadio,
    },
    methods: {
        filter(col) {
            let newValue;

            if (this.ordered[col] == "up") {
                newValue = "down";
            } else {
                newValue = "up";
            }

            this.ordered = {
                title: null,
                criticity: null,
                tendency: null,
                strategy: null,
                lastReview: null,
                [col]: newValue,
            };

            this.order();
            this.setPageRisks();
        },
        order() {
            this.pageRisks.sort((a, b) => {
                if (this.ordered.criticity) {
                    if (this.ordered.criticity == "up") {
                        return (
                            b.evaluations[0].probability *
                                b.evaluations[0].impact -
                            a.evaluations[0].probability *
                                a.evaluations[0].impact
                        );
                    } else if (this.ordered.criticity == "down") {
                        return (
                            a.evaluations[0].probability *
                                a.evaluations[0].impact -
                            b.evaluations[0].probability *
                                b.evaluations[0].impact
                        );
                    } else return 0;
                } else if (this.ordered.title) {
                    if (this.ordered.title == "up") {
                        return a.name.localeCompare(b.name);
                    } else if (this.ordered.title == "down") {
                        return b.name.localeCompare(a.name);
                    } else return 0;
                } else if (this.ordered.tendency) {
                    if (!a.evaluations[1] && !b.evaluations[1]) return 0;
                    if (!a.evaluations[1]) return 1;
                    if (!b.evaluations[1]) return -1;

                    if (this.ordered.tendency == "up") {
                        return (
                            b.evaluations[0].probability *
                                b.evaluations[0].impact -
                            b.evaluations[1].probability *
                                b.evaluations[1].impact -
                            (a.evaluations[0].probability *
                                a.evaluations[0].impact -
                                a.evaluations[1].probability *
                                    a.evaluations[1].impact)
                        );
                    } else if (this.ordered.tendency == "down") {
                        return (
                            a.evaluations[0].probability *
                                a.evaluations[0].impact -
                            a.evaluations[1].probability *
                                a.evaluations[1].impact -
                            (b.evaluations[0].probability *
                                b.evaluations[0].impact -
                                b.evaluations[1].probability *
                                    b.evaluations[1].impact)
                        );
                    } else return 0;
                } else if (this.ordered.lastReview) {
                    const aLastReviewDate = new Date(
                        a.evaluations[0].created_at
                    );
                    const bLastReviewDate = new Date(
                        b.evaluations[0].created_at
                    );

                    const aNextReviewTime =
                        aLastReviewDate.getTime() +
                        a.evaluation_frequency * 1000;

                    const bNextReviewTime =
                        bLastReviewDate.getTime() +
                        b.evaluation_frequency * 1000;

                    const currentDate = new Date();

                    if (this.ordered.lastReview == "up") {
                        return (
                            bNextReviewTime -
                            currentDate.getTime() -
                            (aNextReviewTime - currentDate.getTime())
                        );
                    } else if (this.ordered.lastReview == "down") {
                        return (
                            aNextReviewTime -
                            currentDate.getTime() -
                            (bNextReviewTime - currentDate.getTime())
                        );
                    }
                    return 0;
                } else return 0;
            });
        },
        setPageRisks() {
            this.pages = Math.ceil(this.pageRisks.length / this.maxPerPage);
            this.shownRisks = this.pageRisks.slice(
                (this.actualPage - 1) * this.maxPerPage,
                this.actualPage * this.maxPerPage
            );
        },
        normalizeString(str) {
            return str
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .toLowerCase();
        },
        search(input) {
            if (input === "") {
                this.searching = false;
                return;
            } else {
                this.searching = true;
            }
            const normalizedInput = this.normalizeString(input);
            this.pageRisks = this.risks.filter((risk) =>
                this.normalizeString(risk.name).includes(normalizedInput)
            );
        },
        setCategories() {
            const categories = this.risks.map((risk) => risk.category);

            categories.forEach((category) => {
                const existingCategory = this.categories.find(
                    (cat) => cat.id === category.id
                );
                if (!existingCategory) {
                    this.categories.push(category);
                }
            });

            this.categories.sort((a, b) => a.name.localeCompare(b.name));
        },

        useFilters() {
            this.pageRisks = this.risks;
            if (
                this.selectedStrategies.length === 0 &&
                this.selectedCategories.length === 0
            ) {
                this.order();
                this.setPageRisks();
                return;
            }

            if (this.selectedStrategies.length == 0) {
                this.pageRisks = this.risks.filter((risk) =>
                    this.selectedCategories.includes(risk.category.id)
                );
            } else if (this.selectedCategories.length == 0) {
                this.pageRisks = this.risks.filter((risk) =>
                    this.selectedStrategies.includes(risk.strategy)
                );
            } else {
                this.pageRisks = this.risks.filter(
                    (risk) =>
                        this.selectedCategories.includes(risk.category.id) &&
                        this.selectedStrategies.includes(risk.strategy)
                );
            }

            this.order();
            this.setPageRisks();
        },
        setSelectedCategories(id) {
            if (this.selectedCategories.includes(id)) {
                this.selectedCategories = this.selectedCategories.filter(
                    (cat) => cat !== id
                );
            } else {
                this.selectedCategories.push(id);
            }

            this.useFilters();
        },
        setSelectedStrategies(name) {
            if (this.selectedStrategies.includes(name)) {
                this.selectedStrategies = this.selectedStrategies.filter(
                    (strat) => strat !== name
                );
            } else {
                this.selectedStrategies.push(name);
            }

            this.useFilters();
        },
    },

    watch: {
        risks() {
            this.pageRisks = this.risks;
            this.order();
            this.setPageRisks();
        },
        actualPage() {
            this.setPageRisks();
        },
    },
    mounted() {
        this.order();

        this.pages = Math.ceil(this.risks.length / this.maxPerPage);
        this.pageRisks = this.risks;
        this.setPageRisks();
        this.setCategories();
    },
};
</script>

<template>
    <div class="flex gap-4 items-start mb-4">
        <div
            class="flex items-center justify-center flex-column flex-wrap md:flex-row md:items-center space-y-4 md:space-y-0 pb-4"
        >
            <label for="table-search-risks" class="sr-only">Recherche</label>
            <div class="relative">
                <div
                    class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
                >
                    <svg
                        class="w-4 h-4 text-gray-500 dark:text-gray-400"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 20 20"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>
                <input
                    @input="search($event.target.value)"
                    type="text"
                    id="table-search-risks"
                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="Recherche d'un risque"
                />
            </div>
        </div>
        <div class="w-full flex justify-end gap-4">
            <DropdownRadio id="cat" @manualClosed="">
                <template #button> Catégories </template>
                <template #radio>
                    <li v-for="category in categories">
                        <div class="flex items-center">
                            <input
                                :id="`checkbox-cat-${category.id}`"
                                type="checkbox"
                                value=""
                                @change="setSelectedCategories(category.id)"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            />
                            <label
                                :for="`checkbox-cat-${category.id}`"
                                class="flex gap-2 items-center ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                ><span
                                    class="block w-2 h-2 rounded-full"
                                    :style="`background-color: ${category.color}`"
                                ></span
                                >{{ category.name }}</label
                            >
                        </div>
                    </li>
                </template>
            </DropdownRadio>
            <DropdownRadio id="strat" @manualClosed="">
                <template #button> Stratégies </template>
                <template #radio>
                    <li v-for="strategy in strategies">
                        <div class="flex items-center">
                            <input
                                :id="`checkbox-strat-${strategy.id}`"
                                type="checkbox"
                                value=""
                                @change="setSelectedStrategies(strategy.name)"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            />
                            <label
                                :for="`checkbox-strat-${strategy.id}`"
                                class="flex gap-2 items-center ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >
                                <span
                                    :class="`block w-2 h-2 rounded-full ${strategy.color}`"
                                ></span
                                >{{ strategy.name }}</label
                            >
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <input
                                id="checkbox-strat-99"
                                type="checkbox"
                                value=""
                                @change="setSelectedStrategies(null)"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                            />
                            <label
                                for="checkbox-strat-99"
                                class="flex gap-2 items-center ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                            >
                                <span
                                    class="block w-2 h-2 rounded-full bg-gray-400"
                                ></span
                                >Non définie</label
                            >
                        </div>
                    </li>
                </template>
            </DropdownRadio>
        </div>
    </div>
    <table
        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
    >
        <thead class="text-xs text-gray-700 dark:text-gray-400">
            <tr class="border-b">
                <th scope="col" class="px-6 py-3">
                    <button
                        class="w-full flex justify-between items-center"
                        @click="filter('title')"
                    >
                        Titre
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            :class="`size-3 ${
                                ordered.title == 'up'
                                    ? 'rotate-90'
                                    : ordered.title == 'down'
                                    ? 'rotate-[270deg]'
                                    : 'rotate-0'
                            }`"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button
                        class="w-full flex justify-between items-center"
                        @click="filter('criticity')"
                    >
                        Criticité
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            :class="`size-3 ${
                                ordered.criticity == 'up'
                                    ? 'rotate-90'
                                    : ordered.criticity == 'down'
                                    ? 'rotate-[270deg]'
                                    : 'rotate-0'
                            }`"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">
                    <button
                        class="w-full flex justify-between items-center"
                        @click="filter('tendency')"
                    >
                        Tendence
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            :class="`size-3 ${
                                ordered.tendency == 'up'
                                    ? 'rotate-90'
                                    : ordered.tendency == 'down'
                                    ? 'rotate-[270deg]'
                                    : 'rotate-0'
                            }`"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </th>
                <th scope="col" class="px-6 py-3">Stratégie</th>
                <th scope="col" class="px-6 py-3">
                    <button
                        class="w-full flex justify-between items-center"
                        @click="filter('lastReview')"
                    >
                        Dernière évaluation
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            :class="`size-3 ${
                                ordered.lastReview == 'up'
                                    ? 'rotate-90'
                                    : ordered.lastReview == 'down'
                                    ? 'rotate-[270deg]'
                                    : 'rotate-0'
                            }`"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.5 5.653c0-1.427 1.529-2.33 2.779-1.643l11.54 6.347c1.295.712 1.295 2.573 0 3.286L7.28 19.99c-1.25.687-2.779-.217-2.779-1.643V5.653Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="border-b dark:border-gray-700"
                v-for="risk in shownRisks"
            >
                <RiskTableBody :risk="risk" />
            </tr>
        </tbody>
    </table>

    <div class="w-full flex justify-center my-8">
        <Pagination
            v-if="pages > 1 && !searching"
            :pages="pages"
            :actualPage="actualPage"
            @changePage="(i) => (actualPage = i)"
        />
    </div>
</template>
