<script setup>
import { ref } from "vue";
import AdminNavigationLink from "@/Components/Navigation/AdminNavigationLink.vue";

import DashboardIcon from "@/Icons/Navigation/DashboardIcon.vue";
import UserImgPlaceholder from "@/Icons/UserImgPlaceholder.vue";
import RisksIcon from "@/Icons/Navigation/RisksIcon.vue";
// import ApplicationLogo from "@/Components/ApplicationLogo.vue";
// import Dropdown from "@/Components/Dropdown.vue";
// import DropdownLink from "@/Components/DropdownLink.vue";
// import NavLink from "@/Components/NavLink.vue";
// import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
// import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <nav
            class="fixed top-0 z-50 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700"
        >
            <div class="px-3 py-3 lg:px-5 lg:pl-3">
                <div class="flex items-center justify-between">
                    <div
                        class="flex items-center justify-start rtl:justify-end"
                    >
                        <button
                            data-drawer-target="logo-sidebar"
                            data-drawer-toggle="logo-sidebar"
                            aria-controls="logo-sidebar"
                            type="button"
                            class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg xl:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        >
                            <span class="sr-only">Ouvrir le menu</span>
                            <svg
                                class="w-6 h-6"
                                aria-hidden="true"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    clip-rule="evenodd"
                                    fill-rule="evenodd"
                                    d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"
                                ></path>
                            </svg>
                        </button>
                        <a href="/dashboard" class="flex ms-2 md:me-24">
                            <!-- <img
                                src="https://flowbite.com/docs/images/logo.svg"
                                class="h-8 me-3"
                                alt="FlowBite Logo"
                            /> -->
                            <span
                                class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"
                                >IntuitRisks</span
                            >
                        </a>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center ms-3">
                            <div>
                                <button
                                    type="button"
                                    class="flex text-sm rounded-full focus:ring-1 focus:ring-gray-200 dark:focus:ring-gray-200"
                                    aria-expanded="false"
                                    data-dropdown-toggle="dropdown-user"
                                >
                                    <span class="sr-only"
                                        >Ouvrir le menu utilisateur</span
                                    >
                                    <svg
                                        class="w-10 h-10 text-gray-200"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                    >
                                        <UserImgPlaceholder />
                                    </svg>
                                    <!-- <img
                                        class="w-8 h-8 rounded-full"
                                        src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                                        alt="user photo"
                                    /> -->
                                </button>
                            </div>
                            <div
                                class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                                id="dropdown-user"
                            >
                                <div class="px-4 py-3" role="none">
                                    <p
                                        class="text-sm text-gray-900 dark:text-white"
                                        role="none"
                                    >
                                        {{ $page.props.auth.user.name }}
                                    </p>
                                    <p
                                        class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                                        role="none"
                                    >
                                        {{ $page.props.auth.user.email }}
                                    </p>
                                </div>
                                <ul class="py-1" role="none">
                                    <li>
                                        <a
                                            :href="route('profile.edit')"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem"
                                            >Profil</a
                                        >
                                    </li>
                                    <li>
                                        <a
                                            :href="route('logout')"
                                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem"
                                            >Se déconnecter</a
                                        >
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <aside
            id="logo-sidebar"
            class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 xl:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidebar"
        >
            <div
                class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800"
            >
                <ul class="space-y-2 font-medium">
                    <AdminNavigationLink
                        href="/dashboard"
                        title="Tableau de bord"
                        :isActive="route().current('dashboard')"
                        ><DashboardIcon
                    /></AdminNavigationLink>
                    <AdminNavigationLink
                        href="/risks"
                        title="Risques"
                        :isActive="route().current('risks')"
                        ><RisksIcon
                    /></AdminNavigationLink>
                </ul>
            </div>
        </aside>

        <main class="p-10 mt-16 xl:ml-64">
            <slot />
        </main>
    </div>
</template>
