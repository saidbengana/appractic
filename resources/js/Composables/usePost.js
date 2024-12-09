import {computed, inject} from "vue";

export default function usePost() {
    const postCtx = inject('postCtx');

    const editAllowed = computed(() => {
        return !isDraft.value && !isPublished.value && !isScheduled.value;
    });

    const isDraft = computed(() => {
        return postCtx.status === 'draft';
    });

    const isScheduled = computed(() => {
        return postCtx.status === 'scheduled';
    });

    const isPublished = computed(() => {
        return postCtx.status === 'published';
    });

    const isFailedScheduled = computed(() => {
        return postCtx.status === 'failed-scheduled';
    });

    const isFailedPublished = computed(() => {
        return postCtx.status === 'failed-published';
    });

    const isFailed = computed(() => {
        return isFailedScheduled.value || isFailedPublished.value;
    });

    const isEditable = computed(() => {
        return isDraft.value || isFailed.value;
    });

    return {
        editAllowed,
        isDraft,
        isScheduled,
        isPublished,
        isFailedScheduled,
        isFailedPublished,
        isFailed,
        isEditable
    };
}
