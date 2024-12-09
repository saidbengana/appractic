<script setup>
import {computed} from "vue";

const props = defineProps({
    weekStartsOn: {
        type: Number,
        required: true
    }
})

const weekdays = computed(() => {
    const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

    if (props.weekStartsOn === 0) {
        return weekdays;
    }

    return [
        ...weekdays.slice(props.weekStartsOn),
        ...weekdays.slice(0, props.weekStartsOn)
    ];
})
</script>
<template>
    <div class="grid grid-cols-7 text-center">
        <template v-for="weekday in weekdays" :key="weekday">
            <div class="h-[60px] flex items-center justify-center text-gray-500">
                <span class="text-sm">{{ weekday }}</span>
            </div>
        </template>
    </div>
</template>
