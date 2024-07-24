<script>
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

export default {
    props: {
        id: {
            type: String,
            required: true,
        },
    },

    data() {
        return {
            confirmingEmergencyPlanExecution: false,
        };
    },
    components: {
        DangerButton,
        SecondaryButton,
        Modal,
    },

    methods: {
        execute() {
            window.location.href = `/emergency-plan/${this.id}`;
        },
    },
};
</script>

<template>
    <Modal
        :show="confirmingEmergencyPlanExecution"
        @close="confirmingEmergencyPlanExecution = false"
    >
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">
                Êtes-vous sûr de vouloir éxécuter le plan d'urgence ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Une fois la procédure lancée, la plateforme sera mise en allerte
                et le plan d'urgence sera exécuté.
            </p>

            <div class="mt-6 flex justify-end">
                <SecondaryButton
                    @click="confirmingEmergencyPlanExecution = false"
                >
                    Annuler
                </SecondaryButton>

                <DangerButton class="ms-3" @click="execute">
                    Confirmer
                </DangerButton>
            </div>
        </div>
    </Modal>
    <DangerButton @click="confirmingEmergencyPlanExecution = true"
        >Exécuter le plan d'urgence</DangerButton
    >
</template>
