<script setup>
import {computed, ref} from "vue";
import {
    format,
    addDays,
    subDays,
    getDate,
    getYear,
    getMonth,
    startOfWeek,
    endOfWeek,
    addWeeks,
    subWeeks,
    getHours,
    getMinutes,
    setHours,
    setMinutes
} from "date-fns"
import {utcToZonedTime} from "date-fns-tz";
import {isDatePast} from "@/helpers";
import DateIndicator from "@/Components/Calendar/Week/DateIndicator.vue";
import DateSelector from "@/Components/Calendar/Week/DateSelector.vue";
import Weekdays from "@/Components/Calendar/Week/Weekdays.vue";
import WeekDayTimeItem from "@/Components/Calendar/Week/WeekDayTimeItem.vue";

const props = defineProps({
    timeZone: {
        required: false,
        type: String,
        default: 'UTC'
    },
    initialDate: {
        required: false,
        type: [String, Date],
        default: (props) => {
            return format(utcToZonedTime(new Date().toISOString(), props.timeZone), 'yyyy-MM-dd')
        }
    },
    weekStartsOn: {
        required: false,
        type: Number,
        default: 0
    },
    posts: {
        required: false,
        type: Array,
        default: []
    }
});

const emit = defineEmits(['dateSelected'])

const selectedDate = ref(new Date(`${props.initialDate}T00:00:00`));

const today = computed(() => {
    return format(utcToZonedTime(new Date().toISOString(), props.timeZone), 'yyyy-MM-dd')
});

const days = computed(() => {
    const weekStart = startOfWeek(selectedDate.value, {weekStartsOn: props.weekStartsOn});
    const weekEnd = endOfWeek(selectedDate.value, {weekStartsOn: props.weekStartsOn});

    let days = [];
    let day = weekStart;

    while (day <= weekEnd) {
        days.push({
            date: format(day, 'yyyy-MM-dd'),
            isDisabled: isDatePast(day, props.timeZone),
            posts: getDayPosts(day)
        });

        day = addDays(day, 1);
    }

    return days;
});

const hours = computed(() => {
    return Array.from({length: 24}, (_, i) => i);
});

const getDayPosts = (date) => {
    return props.posts.filter((post) => {
        return format(date, 'yyyy-MM-dd') === post.scheduled_at.date;
    });
}

const getPostsAtTime = (date, hour) => {
    return props.posts.filter((post) => {
        const postDate = format(date, 'yyyy-MM-dd');
        const postHour = getHours(new Date(`${post.scheduled_at.date}T${post.scheduled_at.time}`));
        return postDate === post.scheduled_at.date && postHour === hour;
    });
}

const selectDate = (value) => {
    selectedDate.value = value;
    emit('dateSelected', value);
}
</script>
<template>
    <div class="bg-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between py-lg row-px">
            <div class="flex items-center space-x-xs mb-xs md:mb-0">
                <DateSelector
                    :current-date="today"
                    :selected-date="selectedDate"
                    @dateSelected="selectDate"
                />
                <DateIndicator :selected-date="selectedDate"/>
            </div>

            <slot name="header"/>
        </div>

        <Weekdays :weekStartsOn="weekStartsOn" :days="days"/>

        <div class="calendar-week-height relative border-t border-t-gray-200">
            <div class="absolute inset-0">
                <div class="grid grid-cols-8 h-full divide-x divide-gray-200">
                    <div class="col-span-1 bg-gray-50">
                        <div v-for="hour in hours" :key="hour" class="h-[60px] -mt-3 pl-sm">
                            <span class="text-xs text-gray-500">{{ hour.toString().padStart(2, '0') }}:00</span>
                        </div>
                    </div>

                    <div class="col-span-7 grid grid-cols-7">
                        <div v-for="day in days" :key="day.date" class="relative">
                            <div v-for="hour in hours" :key="hour" class="h-[60px] border-b border-gray-200">
                                <WeekDayTimeItem
                                    :day="day"
                                    :hour="hour"
                                    :posts="getPostsAtTime(day.date, hour)"
                                    :time-zone="timeZone"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
