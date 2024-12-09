<script setup>
import {ref, onMounted, watch} from "vue";
import {format, addHours, parseISO} from "date-fns"
import {utcToZonedTime} from "date-fns-tz";
import useSettings from "@/Composables/useSettings";
import {isTimePast, convertTime12to24} from "@/helpers";
import DialogModal from "@/Components/Modal/DialogModal.vue"
import PrimaryButton from "@/Components/Button/PrimaryButton.vue"
import SecondaryButton from "@/Components/Button/SecondaryButton.vue"
import ExclamationCircleIcon from "@/Icons/ExclamationCircle.vue"
import { Link } from '@inertiajs/vue3'
import FlatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import '@css/overrideFlatPickr.css'

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    date: {
        type: String,
        default: '',
    },
    time: {
        type: String,
        default: '',
    },
    isSubmitActive: {
        type: Boolean,
        default: true
    }
})

const emit = defineEmits(['close', 'update']);

const date = ref();
const time = ref();
const hasErrors = ref(false);

const timePicker = ref();

const {timeZone, timeFormat, weekStartsOn} = useSettings();

const setDateTime = () => {
    if (props.show) {
        if (!props.date && !props.time) {
            // Display the next time if the date and time are null
            const currentTime = utcToZonedTime(new Date().toISOString(), timeZone)
            const [nextDate, nextHour] = format(addHours(currentTime, 1), 'Y-MM-dd H').split(' ');

            date.value = nextDate
            time.value = `${nextHour}:00`
            return;
        }

        date.value = props.date;
        time.value = props.time;
    }
}

const validate = () => {
    return new Promise(resolve => {
        // Prevent time value in the past
        const selected = new Date(parseISO(`${date.value} ${time.value}`));

        if (isTimePast(selected, timeZone)) {
            hasErrors.value = true;
            resolve(false);
            return;
        }

        hasErrors.value = false;
        resolve(true);
    });
}

onMounted(() => {
    setDateTime();
});

watch(() => props.show, () => {
    if (props.show) {
        setDateTime();
    }
});

watch([date, time], () => {
    validate();
});

const confirm = async () => {
    const hour = timePicker.value.querySelector('.flatpickr-hour').value;
    const minutes = timePicker.value.querySelector('.flatpickr-minute').value;

    if (timeFormat === 24) {
        time.value = `${hour}:${minutes}`; // we make sure we have the data that was entered manually (on keyup)
    } else {
        const ampm = timePicker.value.querySelector('.flatpickr-am-pm').textContent;
        time.value = convertTime12to24(`${hour}:${minutes} ${ampm}`);
    }

    const isValid = await validate();

    if (!isValid) {
        return;
    }

    emit('update', {
        date: date.value,
        time: time.value
    });

    close();
}

const close = () => {
    emit('close');
}

const configDatePicker = {
    inline: true,
    dateFormat: 'Y-m-d',
    minDate: "today",
    locale: {
        firstDayOfWeek: weekStartsOn
    }
}

const configTimePicker = {
    inline: true,
    enableTime: true,
    noCalendar: true,
    dateFormat: timeFormat === 24 ? "H:i" : "h:i K",
    time_24hr: timeFormat === 24,
    minuteIncrement: 1,
    defaultHour: time.value ? parseInt(time.value.split(':')[0]) : 0,
    defaultMinute: time.value ? parseInt(time.value.split(':')[1]) : 0
}
</script>

<template>
    <DialogModal :show="show" @close="close" max-width="max-w-2xl">
        <template #title>
            Schedule post
        </template>

        <template #content>
            <div class="flex space-x-lg">
                <div>
                    <div class="text-sm font-medium text-gray-700 mb-xs">
                        Date
                    </div>
                    <FlatPickr v-model="date" :config="configDatePicker"/>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-700 mb-xs">
                        Time
                    </div>
                    <FlatPickr ref="timePicker" v-model="time" :config="configTimePicker"/>
                </div>
            </div>

            <div v-if="hasErrors" class="mt-md flex items-center text-red-600">
                <ExclamationCircleIcon class="w-5 h-5"/>
                <span class="ml-xs">The selected time is in the past.</span>
            </div>
        </template>

        <template #footer>
            <div class="flex justify-between w-full">
                <div>
                    <Link :href="route('settings.timezone')" class="text-sm text-gray-600 hover:text-gray-900">
                        Timezone: {{ timeZone }}
                    </Link>
                </div>
                <div class="flex items-center space-x-sm">
                    <SecondaryButton @click="close">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton @click="confirm" :disabled="!isSubmitActive || hasErrors">
                        Schedule
                    </PrimaryButton>
                </div>
            </div>
        </template>
    </DialogModal>
</template>
