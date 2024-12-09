<script setup>
defineProps({
    media: {
        type: Object,
        required: true
    }
});
</script>

<template>
    <div class="relative">
        <div class="aspect-w-16 aspect-h-9">
            <img :src="media.url"
                 :alt="media.alt"
                 class="object-cover w-full h-full rounded-lg">
            <div v-if="media.description"
                 class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-50 text-white text-sm">
                {{ media.description }}
            </div>
        </div>
    </div>
</template>
