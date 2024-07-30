<script setup>
import { ref } from "vue";

const value = ref(0);

const updateValue = (e) => {
    // console.log(e.target);

    let buttonWidth = 0;
    let position = 0;
    if (e.target.nodeName === "BUTTON") {
        buttonWidth = e.target.clientWidth;
        position = e.offsetX;
    } else if (e.target.nodeName === "DIV") {
        buttonWidth = e.target.parentElement.clientWidth;
        position = e.target.parentElement.offsetLeft + e.offsetX;
    } else if (e.target.id == "ranger") {
        const parentButton = e.target.parentElement.parentElement;
        buttonWidth = parentButton.clientWidth;
        console.log(e.target);
        // const rect = parentButton.getBoundingClientRect();
    }

    const ration = position / buttonWidth;

    if (ration < 1 / 3 / 2) {
        value.value = 0;
    } else if (ration < 1 / 2) {
        value.value = 1;
    } else if (ration < 2 / 3 + 1 / 3 / 2) {
        value.value = 2;
    } else {
        value.value = 3;
    }
};
</script>
<template>
    <label
        for="labels-range-input"
        class="font-normal text-lg text-gray-700 dark:text-white"
        >Probabilité</label
    >
    <input
        id="labels-range-input"
        type="range"
        :v-model="value + 1"
        min="1"
        max="4"
        class="w-full h-1 hidden bg-gray-200 h1 rounded-lg appearance-none cursor-pointer range-sm dark:bg-gray-700"
    />
    <button
        class="w-full bg-gray-600 h-2 rounded-lg p-0 flex items-center"
        @click="(e) => updateValue(e)"
    >
        <div
            :style="`width: ${(value / 3) * 100}%`"
            class="h-2 bg-primary-600 flex justify-end items-center rounded-lg"
        >
            <span
                draggable="true"
                @drag="(e) => updateValue(e)"
                id="ranger"
                class="w-4 h-4 block bg-primary-500 rounded-full"
            ></span>
        </div>
    </button>
    <p class="text-white">{{ value }}</p>
    <!-- <span
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
    > -->
</template>
<style scoped></style>
