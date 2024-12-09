<script setup>
import {Head} from '@inertiajs/vue3';
import {computed, ref} from "vue";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import CalendarSwitchType from "@/Components/Calendar/CalendarSwitchType.vue";
import CalendarToolbar from "@/Components/Calendar/CalendarToolbar.vue";
import CalendarMonth from "@/Components/Calendar/Month/CalendarMonth.vue";
import CalendarWeek from "@/Components/Calendar/Week/CalendarWeek.vue";

const props = defineProps({
    posts: {
        type: Object,
        required: true
    }
});

const type = ref('month');

const setType = (value) => {
    type.value = value;
};

const isTypeSelected = (value) => {
    return type.value === value;
};

const component = computed(() => {
    return type.value === 'month' ? CalendarMonth : CalendarWeek;
});
</script>

<template>
    <div>
        <Head title="Calendar"/>

        <PageHeader>
            <template #header>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Calendar
                </h1>
            </template>

            <template #actions>
                <CalendarSwitchType :type="type"
                                  @select="setType"/>
            </template>
        </PageHeader>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <CalendarToolbar/>

                        <component :is="component"
                                 :posts="posts"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
