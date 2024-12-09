import {computed} from "vue";
import {usePage} from "@inertiajs/vue3";

const useSettings = () => {
    const settings = computed(() => {
        return usePage().props.settings;
    });

    const getSetting = (name) => {
        return settings.value[name];
    }

    return {
        getSetting,
        timeZone: computed(() => settings.value.timezone),
        timeFormat: computed(() => settings.value.time_format),
        weekStartsOn: computed(() => settings.value.week_starts_on)
    }
}

export default useSettings;
