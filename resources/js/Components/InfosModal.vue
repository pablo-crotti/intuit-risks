<script>
export default {
    props: {
        title: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
    },
};
</script>

<template>
    <button
        :data-modal-target="id"
        :data-modal-toggle="id"
        class="group block text-white focus:outline-none focus:ring-primary-300 font-medium rounded-full text-sm px-0 py-0 text-center"
        type="button"
    >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            class="size-10 text-gray-300 group-hover:text-primary-600 dark:text-gray-700 dark:group-hover:text-primary-600 duration-300"
            fill="currentColor"
        >
            <path
                fill-rule="evenodd"
                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm8.706-1.442c1.146-.573 2.437.463 2.126 1.706l-.709 2.836.042-.02a.75.75 0 0 1 .67 1.34l-.04.022c-1.147.573-2.438-.463-2.127-1.706l.71-2.836-.042.02a.75.75 0 1 1-.671-1.34l.041-.022ZM12 9a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z"
                clip-rule="evenodd"
            />
        </svg>
    </button>

    <div
        :id="id"
        tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
        <div class="relative p-4 w-full max-w-3xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div
                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
                >
                    <h3
                        class="text-xl font-semibold text-gray-900 dark:text-white"
                    >
                        {{ title }}
                    </h3>
                    <button
                        type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        :data-modal-hide="id"
                    >
                        <svg
                            class="w-3 h-3"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 14 14"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                            />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-4 md:p-5 space-y-4">
                    <slot />
                </div>
                <div
                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600"
                ></div>
            </div>
        </div>
    </div>
</template>
