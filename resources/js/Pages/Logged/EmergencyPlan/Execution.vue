<script setup>
import { defineProps, onMounted, ref } from "vue";

import Setup from "@/Pages/Logged/EmergencyPlan/Partials/Setup.vue";
import Manage from "@/Pages/Logged/EmergencyPlan/Partials/Manage.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { useForm } from "@inertiajs/vue3";

import { initFlowbite } from "flowbite";

const props = defineProps({
    risk: {
        type: Object,
        required: true,
    },
    user: {
        type: Object,
        required: true,
    },
});

const confirmingEndEmergencyPlanExecution = ref(false);

const end = () => {
    const form = useForm({
        risk_id: props.risk.id,
    });

    form.patch(`/emergency-plan/${props.risk.id}/end`);
};

onMounted(() => {
    initFlowbite();
});
</script>

<template>
    <div class="min-w-screen min-h-screen py-8 px-8 max-w-screen-xl mx-auto">
        <Modal
            :show="confirmingEndEmergencyPlanExecution"
            @close="confirmingEndEmergencyPlanExecution = false"
        >
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                    Êtes-vous sûr de vouloir arrêter l'exécution le plan
                    d'urgence ?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Une fois la procédure lancée, les informations reccueillies
                    disparaitront.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton
                        @click="confirmingEndEmergencyPlanExecution = false"
                    >
                        Annuler
                    </SecondaryButton>

                    <DangerButton class="ms-3" @click="end">
                        Confirmer
                    </DangerButton>
                </div>
            </div>
        </Modal>

        <div v-if="user.is_admin" class="flex justify-end mb-8">
            <div class="w-max">
                <DangerButton
                    @click="confirmingEndEmergencyPlanExecution = true"
                    >Mettre fin à la situation crise</DangerButton
                >
            </div>
        </div>
        <Setup :risk="risk" :user="user" v-if="risk.emergencyPlanStatus == 1" />
        <Manage :risk="risk" :user="user" v-else />
    </div>
</template>
