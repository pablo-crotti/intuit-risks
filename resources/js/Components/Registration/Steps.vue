<script setup>
defineProps({
    step: {
        type: Number,
        required: true,
    },
});
</script>

<template>
    <ol
        class="items-center w-full space-y-4 sm:flex sm:space-x-20 sm:space-y-0 rtl:space-x-reverse"
    >
        <li
            :class="`flex items-center space-x-2.5 rtl:space-x-reverse ${step > 1 ? 'text-primary-500 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400'}`"
        >
            <span
                :class="`flex items-center justify-center w-8 h-8 border-2 rounded-full shrink-0  ${step > 1 ? 'border-primary-500 dark:border-primary-400' : 'border-gray-500 dark:border-gray-400'}`"
            >
                1
            </span>
            <span>
                <h3 class="font-medium leading-tight">Infos utilisateur</h3>
                <p class="text-sm">Pour vous connecter en tout simplicité</p>
            </span>
        </li>
        <li
        :class="`flex items-center space-x-2.5 rtl:space-x-reverse ${step > 2 ? 'text-primary-500 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400'}`"
        >
            <span
            :class="`flex items-center justify-center w-8 h-8 border-2 rounded-full shrink-0  ${step > 2 ? 'border-primary-500 dark:border-primary-400' : 'border-gray-500 dark:border-gray-400'}`"
            >
                2
            </span>
            <span>
                <h3 class="font-medium leading-tight">Infos organissation</h3>
                <p class="text-sm">Pour donner vie à votre société</p>
            </span>
        </li>
        <li
        :class="`flex items-center space-x-2.5 rtl:space-x-reverse ${step > 3 ? 'text-primary-500 dark:text-primary-400' : 'text-gray-500 dark:text-gray-400'}`"
        >
            <span
            :class="`flex items-center justify-center w-8 h-8 border-2 rounded-full shrink-0  ${step > 3 ? 'border-primary-500 dark:border-primary-400' : 'border-gray-500 dark:border-gray-400'}`"
            >
                3
            </span>
            <span>
                <h3 class="font-medium leading-tight">Sélection de risques</h3>
                <p class="text-sm">Identifier et prioriser</p>
            </span>
        </li>
    </ol>
</template>
