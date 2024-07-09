<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { defineProps, onMounted, ref } from "vue";
import UserImgPlaceholder from "@/Icons/UserImgPlaceholder.vue";
import CustomModal from "@/Components/CustomModal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PrimaryButtonMono from "@/Components/PrimaryButtonMono.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import Loader from "@/Components/Loader.vue";
import { initFlowbite } from "flowbite";
import DropdownRadio from "@/Components/DropdownRadio.vue";
import axios from "axios";

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    admin: {
        type: Number,
        required: true,
    },
});

const isLoading = ref(false);
const manualClose = ref(false);
const users = ref(props.users);
const filteredUsers = ref(users.value);

const form = useForm({
    name: "",
    email: "",
    is_admin: false,
});

onMounted(() => {
    initFlowbite();
});

const storeNewUser = () => {
    isLoading.value = true;
    form.post(route("admin.users.store"), {
        onFinish: () => {
            isLoading.value = false;
            form.reset("name", "email", "is_admin");
        },
    });
};

const updateStatus = async (id, status) => {
    isLoading.value = true;
    const statusForm = useForm({
        id: id,
        update: status,
    });

    axios
        .patch(route("admin.users.update"), statusForm.data())
        .then((response) => {
            users.value = response.data.users;
            filteredUsers.value = response.data.users;
            isLoading.value = false;
            manualClose.value = true;
        });
};

const normalizeString = (str) => {
    return str
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "")
        .toLowerCase();
};

const search = (input) => {
    if (input === "") {
        filteredUsers.value = users.value;
        return;
    }

    filteredUsers.value = users.value.filter((user) =>
        normalizeString(user.name).includes(normalizeString(input))
    );
};
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Utilisateurs" />
        <Loader v-if="isLoading" />
        <div>
            <div class="relative overflow-x-auto">
                <div
                    class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4"
                >
                    <div>
                        <CustomModal
                            id="new-user-modal"
                            title="Ajouter un utilisateur"
                            buttonTitle="Ajouter un utilisateur"
                        >
                            <template v-slot:body>
                                <div class="mb-4">
                                    <InputLabel for="name">Nom</InputLabel>
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1"
                                        placeholder="Jean Dupont"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.name"
                                    />
                                </div>
                                <div>
                                    <InputLabel for="email">Email</InputLabel>
                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1"
                                        placeholder="jean.dupont@example.com"
                                    />
                                    <InputError
                                        class="mt-2"
                                        :message="form.errors.email"
                                    />
                                </div>
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input
                                            id="is_admin"
                                            name="is_admin"
                                            v-model="form.is_admin"
                                            aria-describedby="is_admin"
                                            type="checkbox"
                                            class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                                        />
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label
                                            for="is_admin"
                                            class="font-light text-gray-500 dark:text-gray-300"
                                            >Définir comme administrateur
                                        </label>
                                    </div>
                                </div>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.is_admin"
                                />
                            </template>
                            <template v-slot:footer>
                                <div class="w-full flex justify-end gap-4">
                                    <div class="w-30">
                                        <PrimaryButtonMono
                                            data-modal-hide="new-user-modal"
                                            >Annuler</PrimaryButtonMono
                                        >
                                    </div>
                                    <div class="w-30">
                                        <PrimaryButton @click="storeNewUser"
                                            >Enregistrer</PrimaryButton
                                        >
                                    </div>
                                </div>
                            </template>
                        </CustomModal>
                    </div>
                    <label for="table-search" class="sr-only">Recherche</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none"
                        >
                            <svg
                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 20 20"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                />
                            </svg>
                        </div>
                        <input
                            @input="search($event.target.value)"
                            type="text"
                            id="table-search-users"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Recherche d'utilisateurs"
                        />
                    </div>
                </div>
                <table
                    class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr>
                            <th scope="col" class="px-6 py-3">Nom</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">
                                Administration
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="user in filteredUsers"
                            :key="user.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                        >
                            <th
                                scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white"
                            >
                                <UserImgPlaceholder
                                    :img="user.image"
                                    width="w-10"
                                    height="h-10"
                                />
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        {{ user.name }}
                                    </div>
                                    <div class="font-normal text-gray-500">
                                        {{ user.email }}
                                    </div>
                                </div>
                            </th>
                            <td class="px-6 py-3">
                                <div
                                    class="flex items-center"
                                    v-if="!user.is_active && !user.is_deleted"
                                >
                                    <div
                                        class="h-2.5 w-2.5 rounded-full bg-orange me-2"
                                    ></div>
                                    Pas enregistré
                                </div>
                                <div
                                    class="flex items-center"
                                    v-else-if="user.id == admin"
                                >
                                    <div
                                        class="h-2.5 w-2.5 rounded-full bg-green me-2"
                                    ></div>
                                    Actif
                                </div>

                                <DropdownRadio
                                    v-else
                                    :id="`radio-${user.id}`"
                                    :manualClose="manualClose"
                                    @manualClosed="manualClose = false"
                                >
                                    <template v-slot:button>
                                        <div class="flex items-center">
                                            <div
                                                :class="`h-2.5 w-2.5 rounded-full me-2 ${
                                                    !user.is_deleted
                                                        ? 'bg-green'
                                                        : 'bg-red'
                                                }`"
                                                class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"
                                            ></div>
                                            {{
                                                !user.is_deleted
                                                    ? "Actif"
                                                    : "Désactivé"
                                            }}
                                        </div>
                                    </template>
                                    <template v-slot:radio>
                                        <button
                                            @click="
                                                updateStatus(user.id, 'status')
                                            "
                                            class="group w-full flex justify-between items-center hover:bg-gray-100 px-4 py-2 rounded-lg dark:hover:bg-gray-600 duration-300"
                                        >
                                            <div class="flex items-center">
                                                <div
                                                    :class="`h-2.5 w-2.5 rounded-full me-2 ${
                                                        user.is_deleted
                                                            ? 'bg-green'
                                                            : 'bg-red'
                                                    }`"
                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"
                                                ></div>
                                                {{
                                                    user.is_deleted
                                                        ? "Activer"
                                                        : "Désactiver"
                                                }}
                                            </div>
                                            <span
                                                class="flex items-center mr-2 group-hover:mr-0 duration-300"
                                            >
                                                <svg
                                                    class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 14 10"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M1 5h12m0 0L9 1m4 4L9 9"
                                                    />
                                                </svg>
                                            </span>
                                        </button>
                                    </template>
                                </DropdownRadio>
                            </td>
                            <td class="px-6 py-3">
                                <div
                                    v-if="user.id == admin"
                                    class="flex items-center"
                                >
                                    <div
                                        class="h-2.5 w-2.5 rounded-full bg-green me-2"
                                    ></div>
                                    Administrateur principal
                                </div>
                                <DropdownRadio
                                    v-else
                                    :id="`radio-admin-${user.id}`"
                                    :manualClose="manualClose"
                                    @manualClosed="manualClose = false"
                                >
                                    <template v-slot:button>
                                        <div class="flex items-center">
                                            <div
                                                :class="`h-2.5 w-2.5 rounded-full me-2 ${
                                                    user.is_admin
                                                        ? 'bg-green'
                                                        : 'bg-red'
                                                }`"
                                                class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"
                                            ></div>
                                            {{
                                                user.is_admin
                                                    ? "Administrateur"
                                                    : "Utilisateur"
                                            }}
                                        </div>
                                    </template>
                                    <template v-slot:radio>
                                        <button
                                            @click="
                                                updateStatus(user.id, 'admin')
                                            "
                                            class="group w-full flex justify-between items-center hover:bg-gray-100 px-4 py-2 rounded-lg dark:hover:bg-gray-600 duration-300"
                                        >
                                            <div class="flex items-center">
                                                <div
                                                    :class="`h-2.5 w-2.5 rounded-full me-2 ${
                                                        !user.is_admin
                                                            ? 'bg-green'
                                                            : 'bg-red'
                                                    }`"
                                                    class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"
                                                ></div>
                                                {{
                                                    !user.is_admin
                                                        ? "Définir admin"
                                                        : "Définir utilisateur"
                                                }}
                                            </div>
                                            <span
                                                class="flex items-center mr-2 group-hover:mr-0 duration-300"
                                            >
                                                <svg
                                                    class="rtl:rotate-180 w-3.5 h-3.5 ms-2"
                                                    aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 14 10"
                                                >
                                                    <path
                                                        stroke="currentColor"
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M1 5h12m0 0L9 1m4 4L9 9"
                                                    />
                                                </svg>
                                            </span>
                                        </button>
                                    </template>
                                </DropdownRadio>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
