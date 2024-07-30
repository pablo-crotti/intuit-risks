<script>
export default {
    props: {
        categories: {
            type: Array,
            required: true,
        },
        consultedCategories: {
            type: Array,
            required: true,
        },
        risks: {
            type: Array,
            required: true,
        },
        companyRisks: {
            type: Array,
            required: true,
        },
    },
    emits: ["newCategorySelected", "validateSelection"],
};
</script>

<template>
    <div class="px-2 py-5 w-3/4 mx-auto flex flex-wrap gap-4 px-6">
        <div class="w-full flex justify-between">
            <h2
                class="mb-4 text-3xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-4xl lg:text-4xl text-gray-900 dark:text-white"
            >
                Vous y êtes <span class="text-primary-400">presque</span> !
            </h2>
            <button
                @click="$emit('validateSelection')"
                class="text-white bg-primary-700 hover:bg-primary-800 focus:outline-none font-medium rounded-lg text-sm px-6 text-center inline-flex items-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 duration-300"
            >
                Terminer la sélection de risques
            </button>
        </div>
        <p
            class="mb-6 text-lg text-center md:text-left font-normal text-gray-700 dark:text-gray-400 lg:text-xl"
        >
            Dans cette dernière étape, vous pouvez choisir les risques courants
            spécifiques à votre type d'organisation, triés selon les catégories
            ci-dessous. En sélectionnant ces risques, vous obtiendrez un premier
            aperçu de votre analyse de risques, personnalisée pour répondre aux
            besoins de votre organisation.
        </p>
    </div>
    <div
        v-for="category in categories"
        class="flex items-center justify-between text-lg w-3/4 mx-auto px-2 py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
    >
        <button
            @click="$emit('newCategorySelected', category.id)"
            class="group flex flex-col w-full hover:bg-white dark:hover:bg-gray-800 text-left p-6 rounded-lg"
        >
            <div class="flex justify-between w-full">
                <div class="flex justify-start gap-2 items-center">
                    <div class="flex gap-4 items-center">
                        <span
                            class="w-2 h-2 block rounded-full"
                            :style="`background-color: ${category.color}`"
                        ></span>
                        <p class="text-gray-900 dark:text-white">
                            {{ category.name }}
                        </p>
                    </div>
                    <span
                        v-if="consultedCategories.includes(category.id)"
                        class="px-2.5 py-0.5 text-xs ml-4 mb-5 bg-primary-500 text-white rounded-lg"
                        >Consulté</span
                    >
                </div>
                <span
                    class="flex items-center mr-5 group-hover:mr-0 duration-300 group-hover:text-primary-500"
                    >Voir les risques
                    <svg
                        class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 14 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M1 5h12m0 0L9 1m4 4L9 9"
                        />
                    </svg>
                </span>
            </div>

            <p class="text-gray-500 dark:text-gray-400">
                {{ category.description_short }}
            </p>
            <p class="text-gray-500 dark:text-gray-400 text-right">
                {{
                    companyRisks.filter(
                        (risk) => risk.category_id === category.id
                    ).length
                }}
                /
                {{ category.risks_count }}
            </p>
        </button>
    </div>
</template>
