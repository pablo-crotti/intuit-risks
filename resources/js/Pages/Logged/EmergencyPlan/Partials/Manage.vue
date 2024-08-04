<script setup>
import { defineProps, onMounted, ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import UserNameAndImg from "@/Components/UserNameAndImg.vue";

import { useForm } from "@inertiajs/vue3";

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

const actions = ref([]);
const informations = ref([]);

const responseForm = useForm({
    id: 0,
    response: "",
});

const setActionsAndInformations = () => {
    informations.value = props.risk.emergency_plan_actions.filter(
        (action) => action.is_information == true
    );
    actions.value = props.risk.emergency_plan_actions.filter(
        (action) => action.is_information == false
    );
};

const userActions = ref([]);
const userInformations = ref([]);

const setUserActionsAndInformations = () => {
    userInformations.value = informations.value.filter(
        (information) => information.agent_id == props.user.id
    );

    userActions.value = actions.value.filter(
        (action) => action.agent_id == props.user.id
    );
};

const done = (id) => {
    const form = useForm({
        id: id,
    });

    form.patch(`/emergency-plan/${props.risk.id}/action-done`, {
        onSuccess: () => {
            setActionsAndInformations();
            setUserActionsAndInformations();
            responseForm.id = id;
        },
    });
};

const newresponse = (id) => {
    responseForm.patch(`/emergency-plan/${props.risk.id}/action-response`, {
        onSuccess: () => {
            setActionsAndInformations();
            setUserActionsAndInformations();
            responseForm.reset();
        },
    });
};

onMounted(() => {
    setActionsAndInformations();
    setUserActionsAndInformations();
});
</script>
<template>
    <div class="flex flex-col gap-4 justify-start items-center">
        <div class="w-full rounded-lg bg-gray-200 dark:bg-gray-800 p-4">
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
        <div class="w-full rounded-lg bg-gray-200 dark:bg-gray-800 p-4">
            <h1 class="text-gray-900 dark:text-white text-lg mb-8">
                Vos responsabilités
            </h1>

            <div class="flex flex-col gap-8">
                <h2
                    class="text-gray-700 dark:text-gray-300 text-md text-left border-b py-2 border-gray-400 dark:border-gray-700"
                >
                    Informations
                </h2>
                <div
                    class="pb-2 border-b-2 border-gray-400 dark:border-gray-700"
                    v-for="information in userInformations"
                >
                    <button
                        class="flex gap-2 dark:text-white"
                        :disabled="information.status"
                        @click="done(information.id)"
                    >
                        <span
                            :class="`w-6 h-6 border-2 rounded-md flex items-center justify-center text-white ${
                                information.status
                                    ? 'bg-primary-500 border-primary-500'
                                    : 'border-gray-400 '
                            }`"
                        >
                            <svg
                                v-if="information.status"
                                class="size-6"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </span>
                        {{ information.action }}
                    </button>
                    <div class="mt-4" v-if="information.status">
                        <span v-if="responseForm.id == information.id">
                            <InputLabel for="description"
                                >Description</InputLabel
                            >
                            <textarea
                                id="description"
                                v-model="responseForm.response"
                                class="block w-full mt-1 border bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:text-white"
                                rows="3"
                            ></textarea>
                            <InputError
                                class="mt-2"
                                :message="responseForm.errors.response"
                            />
                            <div class="flex justify-end mt-4 gap-4">
                                <span class="w-max">
                                    <PrimaryButtonMono
                                        @click="responseForm.reset()"
                                        >{{
                                            !information.response
                                                ? "Pas de remarque"
                                                : "Annuler"
                                        }}</PrimaryButtonMono
                                    >
                                </span>
                                <span class="w-max">
                                    <PrimaryButton @click="newresponse"
                                        >Enregistrer</PrimaryButton
                                    >
                                </span>
                            </div>
                        </span>
                        <span
                            v-else
                            class="w-full flex justify-between items-start gap-8"
                        >
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ information.response }}
                            </p>
                            <button
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-400 furation-300"
                                @click="
                                    responseForm.id = information.id;
                                    responseForm.response =
                                        information.response;
                                "
                            >
                                <svg
                                    class="size-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"
                                    />
                                </svg>
                            </button>
                        </span>
                    </div>
                </div>
                <h2
                    class="text-gray-700 dark:text-gray-300 text-md text-left mb-4 border-b py-2 border-gray-400 dark:border-gray-700"
                >
                    Actions
                </h2>
                <div
                    class="pb-2 border-b-2 border-gray-400 dark:border-gray-700"
                    v-for="action in userActions"
                >
                    <button
                        class="flex gap-2 dark:text-white"
                        :disabled="action.status"
                        @click="done(action.id)"
                    >
                        <span
                            :class="`w-6 h-6 border-2 rounded-md flex items-center justify-center text-white ${
                                action.status
                                    ? 'bg-primary-500 border-primary-500'
                                    : 'border-gray-400 '
                            }`"
                        >
                            <svg
                                v-if="action.status"
                                class="size-6"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </span>
                        {{ action.action }}
                    </button>
                    <div class="mt-4" v-if="action.status">
                        <span v-if="responseForm.id == action.id">
                            <InputLabel for="description"
                                >Description</InputLabel
                            >
                            <textarea
                                id="description"
                                v-model="responseForm.response"
                                class="block w-full mt-1 border bg-gray-50 border-gray-300 rounded-lg shadow-sm focus:ring-primary-600 focus:border-primary-600 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:text-white"
                                rows="3"
                            ></textarea>
                            <InputError
                                class="mt-2"
                                :message="responseForm.errors.response"
                            />
                            <div class="flex justify-end mt-4 gap-4">
                                <span class="w-max">
                                    <PrimaryButtonMono
                                        @click="responseForm.reset()"
                                        >{{
                                            !action.response
                                                ? "Pas de remarque"
                                                : "Annuler"
                                        }}</PrimaryButtonMono
                                    >
                                </span>
                                <span class="w-max">
                                    <PrimaryButton @click="newresponse"
                                        >Enregistrer</PrimaryButton
                                    >
                                </span>
                            </div>
                        </span>
                        <span
                            v-else
                            class="w-full flex justify-between items-start gap-8"
                        >
                            <p class="text-gray-700 dark:text-gray-300">
                                {{ action.response }}
                            </p>
                            <button
                                class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-400 furation-300"
                                @click="
                                    responseForm.id = action.id;
                                    responseForm.response = action.response;
                                "
                            >
                                <svg
                                    class="size-6"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="currentColor"
                                >
                                    <path
                                        d="M18.75 12.75h1.5a.75.75 0 0 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM12 6a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 6ZM12 18a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 12 18ZM3.75 6.75h1.5a.75.75 0 1 0 0-1.5h-1.5a.75.75 0 0 0 0 1.5ZM5.25 18.75h-1.5a.75.75 0 0 1 0-1.5h1.5a.75.75 0 0 1 0 1.5ZM3 12a.75.75 0 0 1 .75-.75h7.5a.75.75 0 0 1 0 1.5h-7.5A.75.75 0 0 1 3 12ZM9 3.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5ZM12.75 12a2.25 2.25 0 1 1 4.5 0 2.25 2.25 0 0 1-4.5 0ZM9 15.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z"
                                    />
                                </svg>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
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
                                    class="text-gray-700 dark:text-gray-300 w-full font-bold"
                                >
                                    {{ information.action }}
                                </p>

                                <span
                                    v-if="information.status"
                                    class="w-6 h-6 border-2 rounded-md flex items-center justify-center text-white border-primary-500 bg-primary-500"
                                >
                                    <svg
                                        v-if="information.status"
                                        class="size-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex gap-4 mt-4">
                                <strong
                                    class="font-normal text-gray-900 dark:text-white"
                                    >Responsable</strong
                                >
                                <UserNameAndImg
                                    :user_id="information.agent.id"
                                    :user_name="information.agent.name"
                                    :user_image="information.agent.image"
                                />
                            </div>
                            <p
                                :class="`mt-4 ${
                                    information.response
                                        ? 'text-gray-600 dark:text-gray-300'
                                        : 'text-red'
                                }`"
                                v-if="information.status"
                            >
                                {{ information.response ?? "Aucune remarque" }}
                            </p>
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
                                    class="text-gray-700 dark:text-gray-300 w-full font-bold"
                                >
                                    {{ action.action }}
                                </p>

                                <span
                                    v-if="action.status"
                                    class="w-6 h-6 border-2 rounded-md flex items-center justify-center text-white border-primary-500 bg-primary-500"
                                >
                                    <svg
                                        v-if="action.status"
                                        class="size-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </span>
                            </div>
                            <div class="flex gap-4 mt-4">
                                <strong
                                    class="font-normal text-gray-900 dark:text-white"
                                    >Responsable</strong
                                >
                                <UserNameAndImg
                                    :user_id="action.agent.id"
                                    :user_name="action.agent.name"
                                    :user_image="action.agent.image"
                                />
                            </div>
                            <p
                                :class="`mt-4 ${
                                    action.response
                                        ? 'text-gray-600 dark:text-gray-300'
                                        : 'text-red'
                                }`"
                                v-if="action.status"
                            >
                                {{ action.response ?? "Aucune remarque" }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
