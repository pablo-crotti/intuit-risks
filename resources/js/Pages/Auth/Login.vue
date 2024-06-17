<script setup>
import Checkbox from "@/Components/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <div
        class="min-h-full w-screen h-screen flex justify-center flex-wrap md:flex-nowrap"
    >
        <form @submit.prevent="submit" class="w-full">
            <div class="w-full h-full flex justify-center items-center">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
                >
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                        >
                            Connectez-vous
                        </h1>
                        <form class="space-y-4 md:space-y-6" action="#">
                            <div>
                                <InputLabel for="email" value="Email" />

                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                    autofocus
                                    autocomplete="username"
                                    placeholder="jean.dupont@example.com"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.email"
                                />
                            </div>

                            <div class="pb-2">
                                <InputLabel
                                    for="password"
                                    value="Mot de passe"
                                />

                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password"
                                />
                            </div>
                            <Link
                                    v-if="canResetPassword"
                                    :href="route('password.request')"
                                    class="text-sm text-primary-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Vous avez oublié votre mot de passe ?
                                </Link>

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        id="remember"
                                        name="remember"
                                        v-model="form.remember"
                                        aria-describedby="remember"
                                        type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                                    />
                                </div>
                                

                                <div class="ml-3 text-sm">
                                    <label
                                        for="remember"
                                        class="font-light text-gray-500 dark:text-gray-300"
                                        >Se souvenir de moi
                                    </label>
                                </div>
                            </div>

                            <PrimaryButton
                                @click="submit"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Se connecter
                            </PrimaryButton>
                            <p
                                class="text-sm font-light text-gray-500 dark:text-gray-400"
                            >
                                Pas encore de compte ?
                                <a
                                    href="/register"
                                    class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                                    >Créez-en un !</a
                                >
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </form>
    </div>

</template>
