<script setup>
import {inject} from "vue";
import {Link} from '@inertiajs/vue3';
import MenuButton from "@/Components/Button/MenuButton.vue";
import UserDropdown from "@/Components/Navigation/UserDropdown.vue";

const appContext = inject('appContext');
</script>

<template>
    <nav class="sticky top-0 z-30 flex h-16 flex-shrink-0 border-b border-stone-200 bg-white">
        <div class="flex flex-1 justify-between px-4 sm:px-6 lg:px-8">
            <div class="flex flex-1">
                <div class="flex w-16 items-center xl:hidden">
                    <MenuButton @click="appContext.showAside = !appContext.showAside"/>
                </div>
            </div>
            <div class="ml-2 flex items-center space-x-4">
                <UserDropdown/>
            </div>
        </div>
    </nav>
</template>
