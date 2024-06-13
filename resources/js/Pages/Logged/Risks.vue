<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import ListView from "@/Components/Risks/ListView.vue";
import MatrixView from "@/Components/Risks/MatrixView.vue";
import { ref } from "vue";

const view = ref("matrix");

const changeView = (newView) => {
    view.value = newView;
};
</script>

<template>
    <Head title="Risques" />
    <AuthenticatedLayout>
        <div class="w-full flex justify-center mb-4">
            <button @click="changeView('list')" 
            :class="`text-gray-900 border border-gray-300 focus:outline-none font-medium rounded-tl-lg rounded-bl-lg text-sm w-40 py-2.5 mb-2 dark:text-white dark:border-gray-600 dark:hover:border-gray-600 ${view === 'list' ? 'bg-primary-500 border-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white' : 'hover:bg-white dark:hover:bg-gray-800'}`"
            >
                Vue en liste
            </button>
            <button
            @click="changeView('matrix')" 
            :class="`text-gray-900 border border-gray-300 focus:outline-none font-medium rounded-tr-lg rounded-br-lg text-sm w-40 py-2.5 mb-2 dark:text-white dark:border-gray-600 dark:hover:border-gray-600 ${view === 'matrix' ? 'bg-primary-500 dark:bg-primary-600 dark:border-primary-600 text-white border-primary-500' : 'hover:bg-white dark:hover:bg-gray-800'}`"
            >
                Vue en matrice
            </button>
        </div>
        <ListView v-if="view === 'list'" />
        <MatrixView v-else-if="view === 'matrix'" />

        
    </AuthenticatedLayout>
</template>
