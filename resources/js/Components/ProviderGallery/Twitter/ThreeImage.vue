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
        <div class="relative aspect-w-2 aspect-h-2">
            <img :src="media[0].url"
                 :alt="media[0].alt"
                 class="object-cover w-full h-full rounded-lg">
        </div>
        <div class="grid grid-rows-2 gap-1">
            <div v-for="(item, index) in media.slice(1, 3)"
                 :key="index"
                 class="relative aspect-w-1 aspect-h-1">
                <img :src="item.url"
                     :alt="item.alt"
                     class="object-cover w-full h-full rounded-lg">
            </div>
        </div>
    </div>
</template>

<style scoped>
.grid-cols-2 > div:first-child {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.grid-rows-2 > div:first-child {
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
}

.grid-rows-2 > div:last-child {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
}
</style>
