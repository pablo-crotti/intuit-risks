<script>
import { initFlowbite } from "flowbite";
export default {
    props: {
        id: {
            type: String,
            default: "dropdownHelperRadio",
        },
        manualClose: {
            type: Boolean,
            default: false,
        },
    },
    emits: ["manualClosed"],
    methods: {
        closeModal() {
            const closeButton = document.querySelector(`#button-${this.id}`);

            if (closeButton) {
                const open = document.querySelector(`#${this.id}`);
                if (!open.classList.contains("hidden")) {
                    const clickEvent = new MouseEvent("click", {
                        bubbles: true,
                        cancelable: true,
                        view: window,
                    });
                    closeButton.dispatchEvent(clickEvent);
                }
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
    mounted() {
        initFlowbite();
    },
};
</script>

<template>
    <button
        :id="`button-${id}`"
        :data-dropdown-toggle="id"
        class="text-gray-900 dark:text-white bg-gray-100 hover:bg-white dark:bg-gray-700 dark:hover:bg-gray-600 focus:outline-none font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 duration-300"
        type="button"
    >
        <slot name="button" />
        <svg
            class="w-2.5 h-2.5 ms-2.5"
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
        :id="id"
        class="z-10 hidden bg-gray-100 divide-y divide-gray-100 rounded-lg shadow w-max-content dark:bg-gray-600 dark:divide-gray-600"
        data-popper-reference-hidden=""
        data-popper-escaped=""
        data-popper-placement="top"
        style="
            position: absolute;
            inset: auto auto 0px 0px;
            margin: 0px;
            transform: translate3d(522.5px, 6119.5px, 0px);
        "
    >
        <ul
            class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200"
            :aria-labelledby="`button-${id}`"
        >
            <slot name="radio" />
        </ul>
    </div>
</template>
