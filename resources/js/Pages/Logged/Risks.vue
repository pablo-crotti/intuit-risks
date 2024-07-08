<script setup>
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

import localstorage from "@/Helpers/localstorage";

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import ListView from "@/Components/Risks/Views/ListView.vue";
import MatrixView from "@/Components/Risks/Views/MatrixView.vue";
import NewRisk from "@/Components/Risks/Forms/NewRisk.vue";

const view = ref("list");
const loaded = ref(false);

if (localstorage.verifyLocalStorage("risksView")) {
    localstorage.getItem("risksView").then((value) => {
        view.value = value;
        loaded.value = true;
    });
} else {
    localstorage.setItem("risksView", view.value);
    loaded.value = true;
}

const props = defineProps({
    risks: {
        type: Array,
        required: true,
    },
});

const changeView = (newView) => {
    view.value = newView;
    localstorage.setItem("risksView", newView);
};

</script>

<template>
    <Head title="Risques" />
    <AuthenticatedLayout>
        <div v-if="loaded">
            <div class="w-full flex justify-center mb-10">
                <div class="w-full">
                    <button
                        @click="changeView('list')"
                        :class="`text-gray-900 border border-gray-300 focus:outline-none font-medium rounded-tl-lg rounded-bl-lg text-sm w-40 py-2.5 mb-2 dark:text-white dark:border-gray-600 dark:hover:border-gray-600 ${
                            view === 'list'
                                ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white'
                                : 'hover:bg-white dark:hover:bg-gray-800'
                        }`"
                    >
                        Vue en liste
                    </button>
                    <button
                        @click="changeView('matrix')"
                        :class="`text-gray-900 border border-gray-300 focus:outline-none font-medium rounded-tr-lg rounded-br-lg text-sm w-40 py-2.5 mb-2 dark:text-white dark:border-gray-600 dark:hover:border-gray-600 ${
                            view === 'matrix'
                                ? 'bg-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white border-primary-500'
                                : 'hover:bg-white dark:hover:bg-gray-800'
                        }`"
                    >
                        Vue en matrice
                    </button>
                </div>
                <div class="w-80 flex justify-end">
                    <NewRisk :risks="risks" />
                </div>
            </div>
            <ListView :risks="risks" v-if="view === 'list'" />
            <MatrixView :risks="risks" v-else-if="view === 'matrix'" />
        </div>
    </AuthenticatedLayout>
</template>
