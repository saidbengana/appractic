<script setup>
import {computed} from 'vue';

const props = defineProps({
    media: {
        type: Array,
        required: true
    }
});

const remainingCount = computed(() => {
    return props.media.length > 4 ? props.media.length - 4 : 0;
});

const displayMedia = computed(() => {
    return props.media.slice(0, 4);
});

const gridClasses = computed(() => {
    const count = displayMedia.value.length;
    
    if (count === 3) {
        return {
            wrapper: 'grid grid-cols-2 gap-1',
            first: 'row-span-2',
            others: ''
        };
    }
    
    return {
        wrapper: 'grid grid-cols-2 grid-rows-2 gap-1',
        first: '',
        others: ''
    };
});
</script>

<template>
    <div :class="['relative', gridClasses.wrapper]">
        <template v-if="displayMedia.length === 3">
            <div :class="['relative aspect-w-1 aspect-h-2', gridClasses.first]">
                <img :src="displayMedia[0].url"
                     :alt="displayMedia[0].alt"
                     class="object-cover w-full h-full rounded-lg">
            </div>
            <div class="grid grid-rows-2 gap-1">
                <div v-for="(item, index) in displayMedia.slice(1)"
                     :key="index"
                     class="relative aspect-w-1 aspect-h-1">
                    <img :src="item.url"
                         :alt="item.alt"
                         class="object-cover w-full h-full rounded-lg">
                </div>
            </div>
        </template>
        <template v-else>
            <div v-for="(item, index) in displayMedia"
                 :key="index"
                 class="relative aspect-w-1 aspect-h-1">
                <img :src="item.url"
                     :alt="item.alt"
                     class="object-cover w-full h-full rounded-lg">
                <div v-if="index === 3 && remainingCount > 0"
                     class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg">
                    <span class="text-white text-xl font-semibold">
                        +{{ remainingCount }}
                    </span>
                </div>
            </div>
        </template>
    </div>
</template>
