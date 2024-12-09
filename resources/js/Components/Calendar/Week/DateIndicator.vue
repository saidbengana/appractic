<script setup>
import {computed} from "vue";
import {format} from "date-fns";

const props = defineProps({
    selectedDate: {
        type: Date,
        required: true
    }
})

const label = computed(() => {
    const weekStart = format(props.selectedDate, 'MMMM d');
    const weekEnd = format(props.selectedDate, 'MMMM d, yyyy');
    return `${weekStart} - ${weekEnd}`;
});
</script>
<template>
    <div class="text-gray-700 font-semibold text-lg">{{ label }}</div>
</template>
