<template>
    <div class="px-4 py-4 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
            <slot name="title" />
        </h2>

        <div class="w-24">
            <slot name="action" />
        </div>
    </div>
    <span class="w-full h-1 block bg-gray-200 dark:bg-gray-900"></span>
    <div class="px-4 py-4">
        <slot name="content" />
    </div>
</template>
