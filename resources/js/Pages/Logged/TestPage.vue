<script>
import { ref } from "vue";

// const categories = fetch("http://localhost:8000/api/categories")
//     .then((response) => response.json())
//     .then((data) => {
//         return data;
//     })
//     .catch((error) => {
//         console.error("Error:", error);
//     });
// const categories = ref([
//     {
//         id: 1,
//         name: "Environmentaux",
//         color: "#3FC919",
//         label: "ENV",
//     },
//     {
//         id: 2,
//         name: "Financiers",
//         color: "#3FC919",
//         label: "FIN",
//     },
//     {
//         id: 3,
//         name: "Humains et sociaux",
//         color: "#3FC919",
//         label: "HUMSOC",
//     },
// ]);

export default {
    data() {
        return {
            categories: [],
        };
    },
    mounted() {
        fetch("http://localhost:8000/api/categories")
            .then((response) => response.json())
            .then((data) => {
                this.categories = data;
                console.log(this.categories);
            })
            .catch((error) => {
                console.error("Error:", error);
            });
        
    },
};
</script>
<template>
    <div class="p-10">
        <div id="accordion-collapse" data-accordion="collapse">
            <span v-for="(category, index) in categories">
                <h2 :id="`accordion-collapse-heading ${category.id}`">
                    <button
                        type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 gap-3"
                        :data-accordion-target="`#accordion-collapse-body-${category.id}`"
                        :aria-expanded="index === 0 ? 'true' : 'false'"
                        :aria-controls="`accordion-collapse-body-${category.id}`"
                    >
                        <div
                            class="flex justify-start gap-2 items-center w-full"
                        >
                            <span
                                class="w-2 h-2 block rounded-full"
                                :style="`background-color: ${category.color}`"
                            ></span>
                            <span>{{ category.name }}</span>
                        </div>
                        <span class="flex justify-end w-full"
                            >Sélectionnés : 0/10</span
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
                    :id="`accordion-collapse-body-${category.id}`"
                    class="hidden"
                    :aria-labelledby="`accordion-collapse-heading-${category.id}`"
                >
                    <div
                        class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900"
                    >
                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                            Flowbite is an open-source library of interactive
                            components built on top of Tailwind CSS including
                            buttons, dropdowns, modals, navbars, and more.
                        </p>
                        <p class="text-gray-500 dark:text-gray-400">
                            Check out this guide to learn how to
                            <a
                                href="/docs/getting-started/introduction/"
                                class="text-blue-600 dark:text-blue-500 hover:underline"
                                >get started</a
                            >
                            and start developing websites even faster with
                            components on top of Tailwind CSS.
                        </p>
                    </div>
                </div>
            </span>
        </div>
    </div>
</template>
