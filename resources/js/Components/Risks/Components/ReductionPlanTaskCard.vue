<script>
import { initFlowbite } from "flowbite";
import { useForm } from "@inertiajs/vue3";

import UserNameAndImg from "@/Components/UserNameAndImg.vue";
import CustomModal from "@/Components/CustomModal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Modal from "@/Components/Modal.vue";

export default {
    props: {
        task: {
            type: Object,
            required: true,
        },
        responsible_id: {
            type: Number,
            default: null,
        },
        author_id: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            manualClose: false,
            form: useForm({
                status: 0,
                remark: "",
            }),
            confirmingTaskDeletion: false,
        };
    },
    methods: {
        close() {
            this.manualClose = true;
            this.form.reset();
        },
        store() {
            this.form.put(
                `/api/reduction-plan/tasks/${this.task.id}/evaluate`,
                {
                    onSuccess: () => {
                        this.form.reset();
                        this.manualClose = true;
                    },
                }
            );
        },
        confirmTaskDeletion() {
            this.confirmingTaskDeletion = true;
        },

        deleteTask() {
            const deleteForm = useForm({
                delete: true,
            });
            deleteForm.delete(`/api/reduction-plan/tasks/${this.task.id}`, {
                onSuccess: () => {
                    this.confirmingTaskDeletion = false;
                },
            });
        },

        closeModal() {
            this.confirmingTaskDeletion = false;
        },
    },
    components: {
        UserNameAndImg,
        CustomModal,
        InputLabel,
        InputError,
        PrimaryButton,
        PrimaryButtonMono,
        DangerButton,
        Modal,
        SecondaryButton,
    },
    mounted() {
        initFlowbite();
    },
};
</script>
<template>
    <div class="bg-gray-100 dark:bg-gray-700 rounded-lg pb-4">
        <div class="flex justify-end mb-4">
            <span
                :class="`${
                    task.status == 0
                        ? 'bg-gray-400 dark:bg-gray-500'
                        : task.status == 1
                        ? 'bg-green'
                        : 'bg-red'
                } text-white rounded-lg text-xs px-2 py-1`"
                >{{
                    task.status == 0
                        ? "Non évalué"
                        : task.status == 1
                        ? "Efficace"
                        : "Inefficace"
                }}</span
            >
        </div>
        <div class="px-4">
            <div class="flex gap-4 mb-4">
                <strong class="font-semibold text-gray-900 dark:text-white"
                    >Responsable</strong
                >
                <UserNameAndImg
                    :user_id="task.agent.id"
                    :user_name="task.agent.name"
                    :user_image="task.agent.image"
                />
            </div>
            <p class="text-gray-800 dark:text-white">{{ task.action }}</p>
            <div
                v-if="task.remark"
                :id="`accordion-flush-${task.id}`"
                data-accordion="collapse"
                data-active-classes="bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white"
                data-inactive-classes="text-gray-500 dark:text-gray-400"
            >
                <h2 :id="`accordion-flush-heading-1-${task.id}`">
                    <button
                        type="button"
                        class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-800 dark:text-gray-400 gap-3"
                        :data-accordion-target="`#accordion-flush-body-1-${task.id}`"
                        aria-expanded="false"
                        :aria-controls="`accordion-flush-body-1-${task.id}`"
                    >
                        <span class="text-sm">Remarque</span>
                        <svg
                            data-accordion-icon
                            class="w-3 h-3 rotate-180 shrink-0"
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
                                d="M9 5 5 1 1 5"
                            />
                        </svg>
                    </button>
                </h2>
                <div
                    :id="`accordion-flush-body-1-${task.id}`"
                    class="hidden"
                    :aria-labelledby="`accordion-flush-heading-1-${task.id}`"
                >
                    <div
                        class="py-5 border-b border-gray-200 dark:border-gray-800"
                    >
                        <p class="mb-2 text-gray-500 dark:text-gray-400">
                            {{ task.remark }}
                        </p>
                    </div>
                </div>
            </div>
            <div
                class="flex justify-end mt-4"
                v-if="!task.status && task.agent.id == $page.props.auth.user.id"
            >
                <div>
                    <CustomModal
                        :id="`modal-task-${task.id}`"
                        title="Évaluer la tâche"
                        :primaryButton="true"
                        :manualClose="manualClose"
                        @manualClosed="manualClose = false"
                        buttonTitle="Évaluer"
                    >
                        <template #body>
                            <div class="flex justify-center gap-8">
                                <button
                                    @click="form.status = -1"
                                    :class="`${
                                        form.status == -1 ? 'bg-red' : ''
                                    } group flex items-center px-8 border border-red rounded hover:bg-red duration-300`"
                                >
                                    <span
                                        :class="`${
                                            form.status == -1
                                                ? 'text-white'
                                                : ''
                                        } w-full py-4 ms-2 text-sm font-medium text-red group-hover:text-white`"
                                        >Inefficace</span
                                    >
                                </button>
                                <button
                                    :class="`${
                                        form.status == 1 ? 'bg-green' : ''
                                    } group flex items-center px-8 border border-green rounded hover:bg-green duration-300`"
                                    @click="form.status = 1"
                                >
                                    <span
                                        :class="`${
                                            form.status == 1 ? 'text-white' : ''
                                        } w-full py-4 ms-2 text-sm font-medium text-green group-hover:text-white`"
                                        >Efficace</span
                                    >
                                </button>
                            </div>
                            <InputError :message="form.errors.status" />
                            <div class="mt-4">
                                <InputLabel for="remark" label="Action"
                                    >Remarque</InputLabel
                                >
                                <textarea
                                    id="remark"
                                    v-model="form.remark"
                                    class="block w-full mt-1 border bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:text-white"
                                    rows="3"
                                ></textarea>
                                <InputError :message="form.errors.remark" />
                            </div>
                        </template>
                        <template #footer>
                            <div class="w-full flex justify-end gap-4">
                                <div>
                                    <PrimaryButtonMono @click="close"
                                        >Annuler</PrimaryButtonMono
                                    >
                                </div>
                                <div>
                                    <PrimaryButton @click="store"
                                        >Enregistrer</PrimaryButton
                                    >
                                </div>
                            </div>
                        </template>
                    </CustomModal>
                </div>
            </div>

            <div
                class="mt-4"
                v-if="
                    responsible_id == $page.props.auth.user.id ||
                    author_id == $page.props.auth.user.id
                "
            >
                <div class="w-max">
                    <DangerButton @click="confirmTaskDeletion"
                        >Supprimer</DangerButton
                    >
                    <Modal :show="confirmingTaskDeletion" @close="closeModal">
                        <div class="p-6">
                            <h2
                                class="text-lg font-medium text-gray-900 dark:text-white"
                            >
                                Êtes-vous sûr de vouloir supprimer la tâche ?
                            </h2>

                            <p
                                class="mt-1 text-sm text-gray-600 dark:text-gray-400"
                            >
                                Si vous confirmez, la tâche
                                <strong>{{ task.action }}</strong> sera
                                définitivement supprimée.
                            </p>

                            <div class="mt-6 flex justify-end">
                                <SecondaryButton @click="closeModal">
                                    Annuler
                                </SecondaryButton>

                                <DangerButton class="ms-3" @click="deleteTask">
                                    Supprimer la tâche
                                </DangerButton>
                            </div>
                        </div>
                    </Modal>
                </div>
            </div>
        </div>
    </div>
</template>
