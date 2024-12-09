<script setup>
import ExclamationIcon from "@/Components/Icons/ExclamationIcon.vue";

defineProps(['message'])
</script>

<template>
    <p v-if="message" class="inline-flex items-center text-red-500 leading-loose text-sm">
        <span class="mr-xs"><ExclamationIcon class="!w-5 !-5"/></span>
        <span>{{ message }}</span>
    </p>
</template>
