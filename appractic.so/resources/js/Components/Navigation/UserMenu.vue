<script setup>
import {Link} from '@inertiajs/vue3';
import {Menu, MenuButton, MenuItems, MenuItem} from '@headlessui/vue';
import UserCircle from "../../Icons/UserCircle.vue";
import PencilSquare from "../../Icons/PencilSquare.vue";
import ArrowRightOnRectangleIcon from "@/Icons/ArrowRightOnRectangle.vue";
import {routes} from "@/routes.js";

const {user} = useAuth();

const open = ref(false);
</script>
<template>
    <Menu as="div" class="relative">
        <MenuButton
            class="flex items-center space-x-sm text-primary-600 hover:text-primary-900 focus:outline-none transition duration-150 ease-in-out">
            <UserCircle class="!w-9 !h-9 text-primary-400"/>
            <span class="text-sm font-medium">{{ user.name }}</span>
        </MenuButton>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <MenuItems
                class="absolute right-0 bottom-0 mb-12 w-48 py-xs rounded-md bg-white shadow-lg ring-1 ring-primary-200 ring-opacity-5 focus:outline-none">
                <MenuItem v-slot="{ active }">
                    <Link :href="route(routes.account)"
                          :class="[active ? 'bg-primary-50' : '', 'block px-md py-xs text-sm text-primary-700']">
                        <template #icon>
                            <PencilSquare/>
                        </template>
                        Edit profile
                    </Link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                    <Link :href="route(routes.logout)"
                          method="post"
                          as="button"
                          class="w-full text-left"
                          :class="[active ? 'bg-primary-50' : '', 'block px-md py-xs text-sm text-primary-700']">
                        <template #icon>
                            <ArrowRightOnRectangleIcon/>
                        </template>
                        Sign out
                    </Link>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>
</template>
