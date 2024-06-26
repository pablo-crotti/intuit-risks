<script>
import SecondaryButton from "./SecondaryButton.vue";

export default {
    props: {
        show: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: "Modal title",
        },
        manualClose: {
            type: Boolean,
            default: false,
        },
        id: {
            type: String,
            default: "default-modal",
        },
        buttonTitle: {
            type: String,
            default: "Modifier",
        },
    },
    components: {
        SecondaryButton,
    },
    emits: ["manualClosed"],
    methods: {
        closeModal() {
            const closeButton = document.querySelector("#close-modal");
            if (closeButton) {
                const clickEvent = new MouseEvent("click", {
                    bubbles: true,
                    cancelable: true,
                    view: window,
                });
                closeButton.dispatchEvent(clickEvent);
            }

            this.$emit("manualClosed");
        },
    },
    watch: {
        manualClose(value) {
            if (value) {
                this.closeModal();
            }
        },
    },
};
</script>

<template>
    <SecondaryButton :data-modal-target="id" :data-modal-toggle="id">
        {{ buttonTitle }}
    </SecondaryButton>

    <div
        :id="id"
        tabindex="-1"
        aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
        <div class="relative p-4 w-full max-w-2xl max-h-full">
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
                        id="close-modal"
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
                    <slot name="body" />
                </div>
                <div
                    class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600"
                >
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </div>
</template>
