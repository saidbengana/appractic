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
        </div>
    </div>
</template>
