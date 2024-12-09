<script setup>
import {computed} from "vue";
import {router} from "@inertiajs/vue3";
import {format} from "date-fns";
import {utcToZonedTime} from "date-fns-tz";
import CalendarPostItem from "@/Components/Calendar/CalendarPostItem.vue";
import PlusIcon from "@/Components/Icons/PlusIcon.vue"

const props = defineProps({
    day: {
        type: Object,
        required: true,
    },
    hour: {
        type: Number,
        required: true,
    },
    posts: {
        type: Array,
        required: true,
    },
    timeZone: {
        required: false,
        type: String,
        default: 'UTC'
    },
})

const add = () => {
    const now = utcToZonedTime(new Date().toISOString(), props.timeZone);
    let scheduleAt = `${props.day.date} ${props.hour.toString().padStart(2, '0')}:${format(now, 'mm')}`;
    router.visit(route('appractic.posts.create', {schedule_at: scheduleAt}));
}
</script>
<template>
    <div class="relative h-full group">
        <div
            v-if="!day.isDisabled"
            class="absolute right-0 mr-sm opacity-0 group-hover:opacity-100 transition-opacity ease-in-out duration-300">
            <button @click.prevent="add" type="button"
                    class="text-gray-400 hover:text-indigo-500 transition-colors ease-in-out duration-200">
                <PlusIcon/>
            </button>
        </div>

        <div v-if="posts.length" class="relative p-0.5 md:p-sm">
            <div class="flex flex-wrap space-y-xs w-full">
                <template v-for="post in posts" :key="post.id">
                    <CalendarPostItem :item="post"/>
                </template>
            </div>
        </div>
    </div>
</template>
