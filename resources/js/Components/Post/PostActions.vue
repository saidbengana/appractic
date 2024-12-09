<script setup>
import {computed} from "vue";
import {Link} from "@inertiajs/vue3";
import {capitalize} from "lodash";
import usePost from "@/Composables/usePost";
import useSchedule from "@/Composables/useSchedule";
import usePostVersions from "@/Composables/usePostVersions";
import PostPreviewProviders from "@/Components/Post/PostPreviewProviders.vue";
import PostLimitErrors from "@/Components/Post/PostLimitErrors.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import Dropdown from "@/Components/Surface/Dropdown.vue";

const props = defineProps({
    form: {
        required: true,
        type: Object
    },
    selectedAccounts: {
        required: true,
        type: Array
    },
    processing: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(['publish', 'schedule', 'draft', 'update']);

const {
    getOriginalVersion,
    getAccountVersion,
    getIndexAccountVersion
} = usePostVersions();

const {
    isScheduled,
    isPublished,
    isDraft,
    isFailedScheduled,
    isFailedPublished
} = usePost();

const {
    getScheduleTime,
    getScheduleDate,
    getScheduleDateTime
} = useSchedule();

const isDisabled = computed(() => {
    return props.processing || !props.selectedAccounts.length;
});

const scheduleDateTime = computed(() => {
    return getScheduleDateTime(props.form.schedule_at);
});

const scheduleDate = computed(() => {
    return getScheduleDate(props.form.schedule_at);
});

const scheduleTime = computed(() => {
    return getScheduleTime(props.form.schedule_at);
});

const publish = () => {
    emit('publish');
};

const schedule = () => {
    emit('schedule');
};

const draft = () => {
    emit('draft');
};

const update = () => {
    emit('update');
};
</script>

<template>
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-sm">
            <PostPreviewProviders :selected-accounts="selectedAccounts"
                                :versions="form.versions"/>

            <PostLimitErrors :selected-accounts="selectedAccounts"
                           :versions="form.versions"/>
        </div>

        <div class="flex items-center gap-sm">
            <template v-if="!isPublished && !isScheduled">
                <SecondaryButton @click="draft"
                               :disabled="isDisabled">
                    {{ isDraft ? 'Save draft' : 'Save as draft' }}
                </SecondaryButton>

                <Dropdown align="right" width="48">
                    <template #trigger>
                        <PrimaryButton :disabled="isDisabled">
                            Schedule
                        </PrimaryButton>
                    </template>

                    <template #content>
                        <div class="p-md">
                            <div class="flex items-center gap-sm mb-sm">
                                <input type="date"
                                       v-model="form.schedule_at.date"
                                       class="form-input"
                                       :min="scheduleDate">

                                <input type="time"
                                       v-model="form.schedule_at.time"
                                       class="form-input"
                                       :min="scheduleTime">
                            </div>

                            <PrimaryButton @click="schedule"
                                         :disabled="isDisabled || !scheduleDateTime"
                                         class="w-full">
                                Schedule for {{ scheduleDateTime }}
                            </PrimaryButton>
                        </div>
                    </template>
                </Dropdown>

                <PrimaryButton @click="publish"
                             :disabled="isDisabled">
                    Publish now
                </PrimaryButton>
            </template>

            <template v-if="isScheduled || isPublished">
                <SecondaryButton v-if="isFailedScheduled || isFailedPublished"
                               @click="update"
                               :disabled="isDisabled">
                    Update
                </SecondaryButton>
            </template>
        </div>
    </div>
</template>
