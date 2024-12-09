<script setup>
defineProps({
    media: {
        type: Array,
        required: true
    }
});
</script>

<template>
    <div class="relative grid grid-cols-2 grid-rows-2 gap-1">
        <div v-for="(item, index) in media.slice(0, 4)"
             :key="index"
             class="relative aspect-w-1 aspect-h-1">
            <img :src="item.url"
                 :alt="item.alt"
                 class="object-cover w-full h-full rounded-lg">
        </div>
    </div>
</template>

<style scoped>
.grid-cols-2.grid-rows-2 > div:nth-child(1) {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    border-top-right-radius: 0;
}

.grid-cols-2.grid-rows-2 > div:nth-child(2) {
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    border-top-left-radius: 0;
}

.grid-cols-2.grid-rows-2 > div:nth-child(3) {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    border-bottom-right-radius: 0;
}

.grid-cols-2.grid-rows-2 > div:nth-child(4) {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
</style>
