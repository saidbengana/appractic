<script setup>
import {computed} from "vue";
import DialogModal from "@/Components/Modal/DialogModal.vue"
import ExclamationIcon from "@/Components/Icons/ExclamationIcon.vue"

const emit = defineEmits(['close']);

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    maxWidth: {
        type: String,
        default: 'md',
    },
    closeable: {
        type: Boolean,
        default: true,
    },
    variant: {
        type: String,
        default: 'warning'
    }
});

const exclamationBgClasses = computed(() => {
    return {
        'warning': 'bg-orange-100',
        'danger': 'bg-red-100',
    }[props.variant];
});

const exclamationIconClasses = computed(() => {
    return {
        'warning': 'text-orange-600',
        'danger': 'text-red-600',
    }[props.variant];
});

const close = () => {
    emit('close');
};
</script>

<template>
    <DialogModal
        :show="show"
        :max-width="maxWidth"
        :closeable="closeable"
        @close="close"
    >
        <template #header>
            <div class="flex items-center">
                <div :class="[exclamationBgClasses, 'h-12 w-12 shrink-0 flex items-center justify-center rounded-full']">
                    <ExclamationIcon :class="[exclamationIconClasses, 'h-6 w-6']"/>
                </div>

                <div class="ml-md">
                    <slot name="title"/>
                </div>
            </div>
        </template>

        <template #body>
            <div class="mt-sm">
                <slot name="content"/>
            </div>
        </template>

        <template #footer>
            <slot name="footer"/>
        </template>
    </DialogModal>
</template>
