<script>
export default {
    props: {
        pages: {
            type: Number,
            required: false,
        },
        actualPage: {
            type: Number,
            required: true,
        },
    },
    emits: ["change-page"],
};
</script>
<template>
    <nav>
        <ul class="flex items-center -space-x-px h-10 text-base">
            <li>
                <button
                    @click="$emit('change-page', actualPage - 1)"
                    :disabled="actualPage === 1"
                    :class="`flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 border border-e-0 border-gray-300 rounded-s-lg bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ${
                        actualPage === 1
                            ? 'opacity-35'
                            : ' hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'
                    }`"
                >
                    <span class="sr-only">Précédent</span>
                    <svg
                        class="w-3 h-3 rtl:rotate-180"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 6 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 1 1 5l4 4"
                        />
                    </svg>
                </button>
            </li>
            <span v-for="i in pages">
                <li>
                    <button
                        @click="$emit('change-page', i)"
                        :class="`${
                            actualPage === i
                                ? 'z-10 flex items-center justify-center px-4 h-10 leading-tight text-primary-600 border border-primary-300 bg-primary-50 hover:bg-primary-100 hover:text-primary-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white'
                                : 'flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 bg-white border border-e-0 border-gray-300  hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white'
                        }`"
                    >
                        {{ i }}
                    </button>
                </li>
            </span>
            <li>
                <button
                    @click="$emit('change-page', actualPage + 1)"
                    :disabled="actualPage === pages"
                    :class="`flex items-center justify-center px-4 h-10 ms-0 leading-tight text-gray-500 border border-e-0 border-gray-300 rounded-e-lg bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 ${
                        actualPage === pages
                            ? 'opacity-35'
                            : ' hover:bg-gray-100 hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white'
                    }`"

                >
                    <span class="sr-only">Next</span>
                    <svg
                        class="w-3 h-3 rtl:rotate-180"
                        aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 6 10"
                    >
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m1 9 4-4-4-4"
                        />
                    </svg>
                </button>
            </li>
        </ul>
    </nav>
</template>
