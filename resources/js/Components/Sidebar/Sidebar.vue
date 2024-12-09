<script setup>
import {Link} from '@inertiajs/vue3';
import DashboardIcon from '@/Components/Icons/DashboardIcon.vue';
import CalendarIcon from '@/Components/Icons/CalendarIcon.vue';
import SettingsIcon from '@/Components/Icons/SettingsIcon.vue';

const navigation = [
    {name: 'Dashboard', href: route('dashboard'), icon: DashboardIcon},
    {name: 'Calendar', href: route('calendar'), icon: CalendarIcon},
    {name: 'Settings', href: route('settings'), icon: SettingsIcon},
]
</script>

<template>
    <div class="flex h-full flex-1 flex-col">
        <div class="flex flex-1 flex-col overflow-y-auto pb-4">
            <div class="flex h-16 flex-shrink-0 items-center px-6">
                <img class="h-8 w-auto" src="/images/logo.svg" alt="Appractic"/>
            </div>

            <nav class="mt-5 flex-1 space-y-1 px-3">
                <Link
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        route().current(item.href)
                            ? 'bg-stone-100 text-stone-900'
                            : 'text-stone-700 hover:bg-stone-50 hover:text-stone-900',
                        'group flex items-center rounded-md px-3 py-2 text-sm font-medium'
                    ]"
                >
                    <component
                        :is="item.icon"
                        :class="[
                            route().current(item.href) ? 'text-stone-500' : 'text-stone-400 group-hover:text-stone-500',
                            'mr-3 h-6 w-6 flex-shrink-0'
                        ]"
                        aria-hidden="true"
                    />
                    {{ item.name }}
                </Link>
            </nav>
        </div>
    </div>
</template>
