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
        <div v-for="(item, index) in media.slice(0, 2)"
             :key="index"
             class="relative aspect-w-1 aspect-h-1">
            <img :src="item.url"
                 :alt="item.alt"
                 class="object-cover w-full h-full rounded-lg">
            <div v-if="item.description"
                 class="absolute bottom-0 left-0 right-0 p-2 bg-black bg-opacity-50 text-white text-sm">
                {{ item.description }}
            </div>
        </div>
    </div>
</template>

<style scoped>
.grid-cols-2 > div:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.grid-cols-2 > div:last-child {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
</style>
