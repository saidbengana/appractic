<script setup>
defineProps({
    media: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div class="relative grid grid-cols-2 gap-1">
        <div v-for="(item, index) in media" 
             :key="index"
             class="relative aspect-w-1 aspect-h-1">
            <img :src="item.url"
                 :alt="item.alt"
                 class="object-cover w-full h-full rounded-lg">
        </div>
    </div>
</template>
