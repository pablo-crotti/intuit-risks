<script>
import { initFlowbite } from "flowbite";
import axios from "axios";

import UserImgPlaceholder from "@/Icons/UserImgPlaceholder.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";

export default {
    props: {
        risk: {
            type: Object,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            actions: [],
            informations: [],
            setupCompleted: false,
            users: [],
            form: useForm({
                task: "",
                responsible: null,
            }),
        };
    },
    components: {
        UserImgPlaceholder,
        DangerButton,
    },
    methods: {
        setActionsAndInformations() {
            if (this.risk && this.risk.emergency_plan_actions) {
                this.informations = this.risk.emergency_plan_actions.filter(
                    (action) => action.is_information == true
                );
                this.actions = this.risk.emergency_plan_actions.filter(
                    (action) => action.is_information == false
                );
            }
        },
        close(id) {
            const closeButton = document.querySelector(
                `#dropdownUsersRedButton-${id}`
            );
            if (closeButton) {
                const clickEvent = new MouseEvent("click", {
                    bubbles: true,
                    cancelable: true,
                    view: window,
                });
                closeButton.dispatchEvent(clickEvent);
            }
        },
        verifySetupCompleted() {
            if (this.risk && this.risk.emergency_plan_actions) {
                const uncompleted = this.risk.emergency_plan_actions.filter(
                    (action) => !action.agent_id
                );
                this.setupCompleted = uncompleted.length === 0;
            }
        },
        setUser(action, user) {
            this.form.task = action;
            this.form.responsible = user;

            this.form.patch(`${this.risk.id}/agents`, {
                onSuccess: () => {
                    this.setActionsAndInformations();
                    this.verifySetupCompleted();
                    this.close(action);
                },
            });
        },
        start() {
            this.form.patch(`/emergency-plan/${this.risk.id}/start`, {
                onSuccess: () => {
                    console.log("Emergency plan started.");
                },
                onError: (errors) => {
                    console.error("Error starting emergency plan:", errors);
                },
            });
        },
    },
    mounted() {
        axios.get("/api/users").then((response) => {
            this.users = response.data;
            initFlowbite();
        });
        this.setActionsAndInformations();
        this.verifySetupCompleted();
    },
};
</script>

<template>
    <div
        v-if="
            risk.author_id == user.id ||
            responsible_id == user.id ||
            user.is_admin
        "
        class="flex flex-col gap-4 justify-start items-center"
    >
        <div class="w-full rounded-lg bg-gray-200 dark:bg-gray-800 p-4">
            <div class="flex justify-end">
                <div class="w-max">
                    <DangerButton
                        @click="start"
                        :disabled="!setupCompleted"
                        :class="!setupCompleted ? 'opacity-80' : ''"
                        >Lancer le plan d'urgence</DangerButton
                    >
                </div>
            </div>
            <h1 class="text-gray-900 dark:text-white text-lg">
                {{ risk.name }}
            </h1>
            <div class="flex gap-2 items-center">
                <span
                    class="w-3 h-3 block rounded-full"
                    :style="`background-color: ${risk.category.color}`"
                ></span>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ risk.category.name }}
                </p>
            </div>
            <p class="text-gray-700 dark:text-gray-300 mt-4">
                {{ risk.description }}
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-4">
            <div class="w-full rounded-lg bg-gray-200 dark:bg-gray-800">
                <div
                    class="border-b-4 border-gray-100 dark:border-gray-900 p-4"
                >
                    <h2
                        class="text-center text-lg text-gray-900 dark:text-white font-bold"
                    >
                        Informations
                    </h2>
                </div>
                <div class="p-4">
                    <div v-for="information in informations">
                        <div
                            class="mb-8 flex flex-col border-b border-gray-500 dark:border-gray-600 pb-4"
                        >
                            <div class="flex gap-2 items-center">
                                <p
                                    class="text-gray-700 dark:text-gray-300 w-full"
                                >
                                    {{ information.action }}
                                </p>
                                <div class="flex flex-col items-end">
                                    <button
                                        :id="`dropdownUsersRedButton-${information.id}`"
                                        :data-dropdown-toggle="`dropdownUsersRed-${information.id}`"
                                        data-dropdown-placement="bottom"
                                        class="text-gray-800 min-w-max bg-gray-300 hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-blue-800"
                                        type="button"
                                    >
                                        <span v-if="!information.agent_id"
                                            >Responsable</span
                                        >
                                        <div
                                            v-else
                                            class="flex items-center gap-2"
                                        >
                                            <UserImgPlaceholder
                                                :img="information.agent.image"
                                            />
                                            {{ information.agent.name }}
                                        </div>

                                        <svg
                                            class="w-2.5 h-2.5 ms-3"
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
                                        :id="`dropdownUsersRed-${information.id}`"
                                        class="z-10 hidden bg-gray-200 rounded-lg shadow w-60 dark:bg-gray-600"
                                    >
                                        <ul
                                            class="h-48 py-2 overflow-y-auto text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`dropdownUsersRedButton-${information.id}`"
                                        >
                                            <li v-for="user in users">
                                                <button
                                                    @click="
                                                        setUser(
                                                            information.id,
                                                            user.id
                                                        )
                                                    "
                                                    :class="`${
                                                        user.id ==
                                                        information.agent_id
                                                            ? 'bg-gray-100 dark:bg-gray-800'
                                                            : ''
                                                    } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                                >
                                                    <UserImgPlaceholder
                                                        :img="user.image"
                                                    />

                                                    {{ user.name }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full rounded-lg bg-gray-200 dark:bg-gray-800">
                <div
                    class="border-b-4 border-gray-100 dark:border-gray-900 p-4"
                >
                    <h2
                        class="text-center text-lg text-gray-900 dark:text-white font-bold"
                    >
                        Actions
                    </h2>
                </div>
                <div class="p-4">
                    <div v-for="action in actions">
                        <div
                            class="mb-8 flex flex-col border-b border-gray-500 dark:border-gray-600 pb-4"
                        >
                            <div class="flex gap-2 items-center">
                                <p
                                    class="text-gray-700 dark:text-gray-300 w-full"
                                >
                                    {{ action.action }}
                                </p>
                                <div class="flex flex-col items-end">
                                    <button
                                        :id="`dropdownUsersRedButton-${action.id}`"
                                        :data-dropdown-toggle="`dropdownUsersRed-${action.id}`"
                                        data-dropdown-placement="bottom"
                                        class="text-gray-800 min-w-max bg-gray-300 hover:bg-gray-200 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:text-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-blue-800"
                                        type="button"
                                    >
                                        <span v-if="!action.agent_id"
                                            >Responsable</span
                                        >
                                        <div
                                            v-else
                                            class="flex items-center gap-2"
                                        >
                                            <UserImgPlaceholder
                                                :img="action.agent.image"
                                            />
                                            {{ action.agent.name }}
                                        </div>

                                        <svg
                                            class="w-2.5 h-2.5 ms-3"
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
                                        :id="`dropdownUsersRed-${action.id}`"
                                        class="z-10 hidden bg-gray-200 rounded-lg shadow w-60 dark:bg-gray-600"
                                    >
                                        <ul
                                            class="h-48 py-2 overflow-y-auto text-gray-700 dark:text-gray-200"
                                            :aria-labelledby="`dropdownUsersRedButton-${action.id}`"
                                        >
                                            <li v-for="user in users">
                                                <button
                                                    @click="
                                                        setUser(
                                                            action.id,
                                                            user.id
                                                        )
                                                    "
                                                    :class="`${
                                                        user.id ==
                                                        action.agent_id
                                                            ? 'bg-gray-100 dark:bg-gray-800'
                                                            : ''
                                                    } flex w-full gap-2 items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white`"
                                                >
                                                    <UserImgPlaceholder
                                                        :img="user.image"
                                                    />

                                                    {{ user.name }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div
        v-else
        class="h-screen flex flex-col justify-center items-center gap-4"
    >
        <h1
            class="text-xl text-gray-900 text-center md:text-left font-extrabold leading-none tracking-tight md:text-2xl lg:text-3xl dark:text-white animate-pulse"
        >
            Crise en cours
        </h1>
        <p class="text-gray-700 dark:text-gray-200 text-lg text-center">
            Les administrateurs sont actuellement entrain d'attribuer des rôles
            pour la résolution de la crise. Veuillez patienter...
        </p>
    </div>
</template>
