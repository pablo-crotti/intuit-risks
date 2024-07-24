<script>
import WidgetLayout from "@/Layouts/WidgetLayout.vue";
import DangerButton from "@/Components/DangerButton.vue";
import NewEmergencyPlan from "@/Components/Risks/Forms/NewEmergencyPlan.vue";
import ExecuteEmergencyPlan from "@/Components/Risks/Forms/ExecuteEmergencyPlan.vue";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            informations: this.risk.emergency_plan_actions.filter(
                (action) => action.is_information == true
            ),
            actions: this.risk.emergency_plan_actions.filter(
                (action) => action.is_information == false
            ),
        };
    },

    components: {
        WidgetLayout,
        DangerButton,
        NewEmergencyPlan,
        ExecuteEmergencyPlan,
    },
    mounted() {},
};
</script>

<template>
    <WidgetLayout>
        <template #title> Plan d'urgence </template>
        <template #action>
            <NewEmergencyPlan :risk="risk" />
        </template>
        <template #content>
            <div class="px-4 py-4 w-full flex flex-col gap-4 justify-end">
                <div class="flex flex-col justify-start items-center w-full">
                    <div
                        id="accordion-flush-infos"
                        data-accordion="collapse"
                        data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        data-inactive-classes="text-gray-500 dark:text-gray-400"
                        class="w-full"
                    >
                        <h2 id="accordion-flush-heading-infos">
                            <button
                                type="button"
                                class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                                data-accordion-target="#accordion-flush-body-infos"
                                aria-expanded="false"
                                aria-controls="accordion-flush-body-infos"
                            >
                                <span class="text-sm">Informations</span>
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
                            id="accordion-flush-body-infos"
                            class="hidden"
                            aria-labelledby="accordion-flush-heading-infos"
                        >
                            <div
                                class="py-5 border-b border-gray-200 dark:border-gray-700"
                            >
                                <p
                                    v-for="information in informations"
                                    class="mb-2 text-gray-500 dark:text-gray-400"
                                >
                                    {{ information.action }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        id="accordion-flush-actions"
                        data-accordion="collapse"
                        data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white"
                        data-inactive-classes="text-gray-500 dark:text-gray-400"
                        class="w-full"
                    >
                        <h2 id="accordion-flush-heading-actions">
                            <button
                                type="button"
                                class="flex items-center justify-between w-full py-5 font-medium rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400 gap-3"
                                data-accordion-target="#accordion-flush-body-actions"
                                aria-expanded="false"
                                aria-controls="accordion-flush-body-actions"
                            >
                                <span class="text-sm">Actions</span>
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
                            id="accordion-flush-body-actions"
                            class="hidden"
                            aria-labelledby="accordion-flush-heading-actions"
                        >
                            <div
                                class="py-5 border-b border-gray-200 dark:border-gray-700"
                            >
                                <p
                                    v-for="action in actions"
                                    class="mb-2 text-gray-500 dark:text-gray-400"
                                >
                                    {{ action.action }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-max mt-8"
                        v-if="informations.length > 0 || actions.length > 0"
                    >
                        <ExecuteEmergencyPlan :id="risk.id" />
                    </div>
                </div>
            </div>
        </template>
    </WidgetLayout>
</template>
