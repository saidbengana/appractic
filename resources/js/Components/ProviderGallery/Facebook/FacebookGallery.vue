<script setup>
import {computed} from 'vue';
import OneImage from './OneImage.vue';
import TwoImage from './TwoImage.vue';
import ThreeAndMoreImage from './ThreeAndMoreImage.vue';
import Video from './Video.vue';

const props = defineProps({
    media: {
        type: Array,
        required: true
    }
});

const mediaCount = computed(() => props.media.length);

const hasVideo = computed(() => {
    return props.media.some(item => item.type === 'video');
});
</script>

<template>
    <div class="relative">
        <template v-if="hasVideo">
            <Video :media="media[0]"/>
        </template>
        <template v-else>
            <OneImage v-if="mediaCount === 1" :media="media[0]"/>
            <TwoImage v-else-if="mediaCount === 2" :media="media"/>
            <ThreeAndMoreImage v-else :media="media"/>
        </template>
    </div>
</template>
