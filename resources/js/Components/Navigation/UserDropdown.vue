<script setup>
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import {Link} from '@inertiajs/vue3';
import UserIcon from '@/Components/Icons/UserIcon.vue';
import LogoutIcon from '@/Components/Icons/LogoutIcon.vue';

</script>

<template>
    <Menu as="div" class="relative">
        <MenuButton
            class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <span class="sr-only">Open user menu</span>
            <div class="h-8 w-8 rounded-full bg-stone-200 p-1">
                <UserIcon class="h-full w-full text-stone-600"/>
            </div>
        </MenuButton>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95"
        >
            <MenuItems
                class="absolute right-0 z-50 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                <MenuItem v-slot="{ active }">
                    <Link :href="route('profile.edit')"
                          :class="[active ? 'bg-stone-100' : '', 'group flex w-full items-center px-4 py-2 text-sm text-stone-700']">
                        <UserIcon class="mr-3 h-5 w-5 text-stone-400 group-hover:text-stone-500"/>
                        Profile
                    </Link>
                </MenuItem>
                <MenuItem v-slot="{ active }">
                    <Link :href="route('logout')" method="post" as="button"
                          :class="[active ? 'bg-stone-100' : '', 'group flex w-full items-center px-4 py-2 text-sm text-stone-700']">
                        <LogoutIcon class="mr-3 h-5 w-5 text-stone-400 group-hover:text-stone-500"/>
                        Sign out
                    </Link>
                </MenuItem>
            </MenuItems>
        </transition>
    </Menu>
</template>
