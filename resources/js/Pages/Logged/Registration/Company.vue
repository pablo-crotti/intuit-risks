<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
    organizations: {
        type: Array,
        default: () => [],
    },
    countries: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: "",
    organization: "",
    employees: "",
    sector: "",
    country: "",
    city: "",
});

const submit = () => {
    form.post(route("register.company.store"));
};
</script>

<template>
    <Head title="Enregistrer mon organisation" />

    <div
        class="min-h-screen w-screen flex justify-center flex-wrap md:flex-nowrap"
    >
        <div
            class="py-8 md:w-full md:min-h-full flex justify-center items-center bg-gray-800"
        >
            <div class="w-4/5">
                <h2
                    class="mb-4 text-3xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-5xl lg:text-5xl text-white"
                >
                    Parlez-nous de votre
                    <span class="text-primary-400">organisation</span>
                </h2>
                <p
                    class="mb-6 text-lg text-center md:text-left font-normal text-gray-200 lg:text-xl"
                >
                    Lors de la création de votre compte, nous vous demandons des
                    informations sur votre organisation pour personnaliser et
                    optimiser votre expérience. Ces données nous permettent
                    d'adapter nos analyses de risques et nos recommandations
                    spécifiques à votre secteur d'activité.
                </p>
                <p
                    class="mb-6 text-lg text-center md:text-left font-normal text-gray-200 lg:text-xl"
                >
                    En comprenant mieux votre entreprise, nous pouvons également
                    vous offrir un support plus ciblé et assurer la conformité
                    réglementaire nécessaire.
                </p>
            </div>
        </div>
        <form
            @submit.prevent="submit"
            class="w-full flex flex-col justify-center"
        >
            <div class="w-full h-max flex justify-center items-center py-8">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700"
                >
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
                        >
                            Créez votre société
                        </h1>
                        <div>
                            <InputLabel for="name"
                                >Nom de l'entreprise *</InputLabel
                            >

                            <TextInput
                                id="name"
                                type="text"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                                placeholder="IntuitRisks"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                        </div>
                        <div>
                            <InputLabel for="organization"
                                >Type d'organisation *</InputLabel
                            >

                            <select
                                id="organization"
                                v-model="form.organization"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option
                                    v-for="organization in organizations"
                                    :value="organization.id"
                                >
                                    {{ organization.name }}
                                </option>
                            </select>

                            <InputError
                                class="mt-2"
                                :message="form.errors.organization"
                            />
                        </div>
                        <div>
                            <InputLabel for="sector"
                                >Secteur d'activité *</InputLabel
                            >

                            <TextInput
                                id="sector"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.sector"
                                autocomplete="sector"
                                placeholder="Services financiers"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.sector"
                            />
                        </div>
                        <div>
                            <InputLabel for="employees"
                                >Nombre d'employés *</InputLabel
                            >

                            <TextInput
                                id="employees"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.employees"
                                autocomplete="employees"
                                placeholder="50"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.employees"
                            />
                        </div>

                        <div>
                            <InputLabel for="country">Pays *</InputLabel>

                            <select
                                id="country"
                                v-model="form.country"
                                required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            >
                                <option
                                    v-for="country in countries"
                                    :value="country.id"
                                >
                                    {{ country.name }}
                                </option>
                            </select>

                            <InputError
                                class="mt-2"
                                :message="form.errors.country"
                            />
                        </div>

                        <div>
                            <InputLabel for="city">Ville *</InputLabel>

                            <TextInput
                                id="city"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.city"
                                autocomplete="city"
                                placeholder="Zurich"
                                required
                            />

                            <InputError
                                class="mt-2"
                                :message="form.errors.city"
                            />
                        </div>

                        <PrimaryButton
                            @click="submit"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Créer ma société
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </form>
    </div>
</template>
