<script setup>
import {computed} from "vue";
import {format} from "date-fns";

const props = defineProps({
    weekStartsOn: {
        type: Number,
        required: true
    },
    days: {
        type: Array,
        required: true
    }
})

const weekdays = computed(() => {
    return props.days.map(day => {
        const date = new Date(`${day.date}T00:00:00`);
        return {
            ...day,
            weekday: format(date, 'EEE'),
            dayOfMonth: format(date, 'd')
        };
    });
})
</script>
<template>
    <div class="grid grid-cols-8 border-b border-b-gray-200">
        <div class="h-[60px] bg-gray-50"/>

        <template v-for="day in weekdays" :key="day.date">
            <div class="h-[60px] flex flex-col items-center justify-center text-center border-l border-l-gray-200">
                <div class="text-sm text-gray-900">{{ day.weekday }}</div>
                <div class="text-sm text-gray-500">{{ day.dayOfMonth }}</div>
            </div>
        </template>
    </div>
</template>
