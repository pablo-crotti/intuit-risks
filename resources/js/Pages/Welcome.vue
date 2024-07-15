<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template>
    <Head title="Welcome" />
    <div
        class="w-screen h-screen flex flex-col justify-center items-center gap-4 gradient-bg"
    >
        <h1
            class="text-3xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-5xl lg:text-6xl text-gray-900 dark:text-white"
        >
            Intuit<span class="text-primary-500 dark:text-primary-400"
                >Risks</span
            >
        </h1>

        <h2
            class="text-xl text-center md:text-left font-extrabold leading-none tracking-tight md:text-4xl text-gray-900 dark:text-white"
        >
            <div class="inline-flex">
                La gestion de risques
                <div class="animated-text">
                    <div class="text-primary-500 dark:text-primary-400 line">
                        facile
                    </div>
                    <div class="text-primary-500 dark:text-primary-400 line">
                        intuitive
                    </div>
                    <div class="text-primary-500 dark:text-primary-400 line">
                        efficace
                    </div>
                </div>
            </div> 
        </h2>
        <div class="flex justify-center gap-4 mt-10" v-if="!canLogin">
            <a
                :href="route('dashboard')"
                class="cursor-pointer relative inline-flex items-center rounded-lg border-2 px-6 py-2 text-lg font-medium text-white md:py-3 md:px-8 border-primary-600 bg-primary-600 hover:border-primary-500 hover:bg-primary-500 duration-300"
                >Tableau de bord</a
            >
        </div>
        <div class="flex justify-center gap-4 mt-10" v-else>
            <a
                :href="route('login')"
                class="cursor-pointer relative inline-flex items-center rounded-lg border-2 border-white px-6 py-2 text-lg font-medium text-white md:py-3 md:px-8 hover:border-gray-300 hover:bg-gray-300 hover:text-gray-900 duration-300"
                >Se connecter</a
            >
            <a
                v-if="canRegister"
                :href="route('register')"
                class="cursor-pointer relative inline-flex items-center rounded-lg border-2 px-6 py-2 text-lg font-medium text-white md:py-3 md:px-8 border-primary-600 bg-primary-600 hover:border-primary-500 hover:bg-primary-500 duration-300"
                >Créer un compte</a
            >
        </div>
    </div>
</template>
<style>
.gradient-bg {
background: rgb(55,65,113);
background: linear-gradient(0deg, rgba(55,65,113,1) 0%, rgba(17,24,39,1) 100%); 
}
@media screen and (max-width: 767px) {
    .animated-text {
        overflow: hidden;
        height: 1.25rem;
        margin: 0;
        padding: 0;
    }
    .line {
        line-height: 1.25rem;
        margin: 0;
        padding: 0;
        text-align: left;
        padding-left: 0.4rem;
    }
    .line:first-child {
        animation: b 5s infinite;
    }
    @keyframes b {
        0% {
            margin-top: 0px;
        }
        25% {
            margin-top: -1.25rem;
        }
        50% {
            margin-top: -2.5rem;
        }
        75% {
            margin-top: -1.25rem;
        }
        100% {
            margin-top: 0px;
        }
    }
}

@media screen and (min-width: 768px) {
    .animated-text {
        overflow: hidden;
        height: 2.7rem;
    }
    .line {
        line-height: 2.7rem;
        padding-left: 0.8rem;
    }
    .line:first-child {
        animation: a 5s infinite;
    }
    @keyframes a {
        0% {
            margin-top: 0px;
        }
        25% {
            margin-top: -2.7rem;
        }
        50% {
            margin-top: -5.4rem;
        }
        75% {
            margin-top: -2.7rem;
        }
        100% {
            margin-top: 0px;
        }
    }
}
</style>
