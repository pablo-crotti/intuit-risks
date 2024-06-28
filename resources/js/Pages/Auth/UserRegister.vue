<script setup>
import { defineProps } from 'vue';
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";


const props = defineProps({
    user: Object,
});

const form = useForm({
    password: "",
    password_confirmation: "",
    terms: false,
    token: props.user.token,
});

const submit = () => {
    form.post(route("user.register.store"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
   
    // form.post(route("register"), {
    //     onFinish: () => form.reset("password", "password_confirmation"),
    // });
};

console.log(props.user);
</script>

<template>
    <Head title="S'enregistrer" />
    <div class="min-h-full w-screen h-screen flex justify-center flex-wrap md:flex-nowrap">
        <form @submit.prevent="submit" class="w-full">
            <div class="w-full h-full flex justify-center items-center">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
                >
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                        >
                            Choisissez un mot de passe
                        </h1>
                        <p class="text-base text-gray-900 dark:text-white">Bonjour {{ user.name }},</p>
                        <p class="text-base text-gray-900 dark:text-white">Veuillez créer un mot de passe robuste. N'oubliez pas votre couriel d'identification : </p>
                        <p class="text-base text-gray-900 dark:text-white">{{ user.email }}</p>
                        <form class="space-y-4 md:space-y-6" action="#">

                            <div>
                                <InputLabel for="password"
                                    >Mot de passe</InputLabel
                                >

                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password"
                                />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password_confirmation"
                                    >Confirmer mot de passe</InputLabel
                                >

                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    autocomplete="new-password"
                                    placeholder="••••••••"
                                    
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.password_confirmation" />
                            </div>

                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input
                                        id="terms"
                                        name="terms"
                                        v-model="form.terms"
                                        aria-describedby="terms"
                                        type="checkbox"
                                        class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800"
                                    />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label
                                        for="terms"
                                        class="font-light text-gray-500 dark:text-gray-300"
                                        >J'accepte les
                                        <a
                                            class="font-medium text-primary-600 hover:underline dark:text-primary-500"
                                            href="#"
                                            >Conditions Générales</a
                                        ></label
                                    >
                                </div>
                            </div>
                            <InputError
                                    :message="form.errors.terms" />
                            <PrimaryButton
                                @click="submit"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Créer mon mot de passe
                            </PrimaryButton>
                            
                        </form>
                    </div>
                </div>
            </div>
        </form>
        <div
            class="py-8 md:w-full md:h-full flex justify-center items-center bg-gray-800"
        >
            <div class="w-4/5">
                <h2
                    class="mb-4 text-3xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-5xl lg:text-5xl text-white"
                >
                    Rejoignez
                    <span class="text-primary-400">l'aventure</span> 
                </h2>
                <p class="mb-2 text-lg text-center md:text-left font-normal text-gray-200 lg:text-xl">
                    Vous avez été invité à rejoindre l'équipe de gestion des risques de <span class="text-primary-400">{{ user.company.name }}</span> sur notre plateforme IntuitRisks. </p>
                    <p class="mb-6 text-lg text-center md:text-left font-normal text-gray-200 lg:text-xl">Pour finaliser votre inscription et commencer à collaborer, veuillez créer votre mot de passe.</p>
            </div>
        </div>
    </div>
</template>
