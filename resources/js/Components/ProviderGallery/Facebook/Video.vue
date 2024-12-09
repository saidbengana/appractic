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
            <video
                :src="media.url"
                class="object-cover w-full h-full rounded-lg"
                controls
                preload="metadata"
            >
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="absolute top-2 right-2 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded">
            Video
        </div>
    </div>
</template>
