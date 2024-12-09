<script setup>
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import {usePopper} from "@vueuse/core";
import Panel from "@/Components/Surface/Panel.vue";
import UserCircleIcon from "@/Components/Icons/UserCircleIcon.vue";
import CogIcon from "@/Components/Icons/CogIcon.vue";
import LogoutIcon from "@/Components/Icons/LogoutIcon.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const reference = ref(null);
const popper = ref(null);

const {isOpen, open, close} = usePopper(reference, popper, {
    placement: 'bottom-end',
    middleware: ['offset', {options: {offset: 10}}],
    strategy: 'fixed'
});
</script>

<template>
    <div>
        <button ref="reference"
                @click="open"
                type="button"
                class="flex items-center gap-sm text-sm font-medium text-gray-500 hover:text-gray-700">
            <img v-if="user.profile_photo_url"
                 :src="user.profile_photo_url"
                 :alt="user.name"
                 class="w-8 h-8 rounded-full">

            <UserCircleIcon v-else class="w-8 h-8"/>

            {{ user.name }}
        </button>

        <Panel v-if="isOpen"
               ref="popper"
               class="z-50 w-48">
            <div class="p-xs">
                <Link :href="route('profile.show')"
                      class="flex items-center gap-sm p-sm text-sm text-gray-600 hover:text-gray-900 rounded-md hover:bg-gray-50">
                    <CogIcon class="w-4 h-4"/>
                    Settings
                </Link>

                <Link :href="route('logout')"
                      method="post"
                      as="button"
                      class="flex items-center gap-sm p-sm text-sm text-gray-600 hover:text-gray-900 rounded-md hover:bg-gray-50 w-full">
                    <LogoutIcon class="w-4 h-4"/>
                    Logout
                </Link>
            </div>
        </Panel>
    </div>
</template>
