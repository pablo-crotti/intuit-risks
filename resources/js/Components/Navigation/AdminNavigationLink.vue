<script>
export default {
    props: {
        href: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        isActive: {
            type: Boolean,
            required: false,
            default: false,
        },
    },
};
</script>
<template>
    <li>
        <a
            :href="href"
            :class="{
                'flex items-center p-2 text-primary-500 dark:text-primary-400':
                    isActive,
                'flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group':
                    !isActive,
            }"
        >
            <svg
                :class="{
                    'w-5 h-5 text-primary-500 dark:text-primary-400': isActive,
                    'w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-200':
                        !isActive,
                }"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="currentColor"
                viewBox="0 0 22 21"
            >
                <slot />
            </svg>
            <span class="ms-3">{{ title }}</span>
        </a>
    </li>
</template>
