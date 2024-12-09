<script setup>
import {computed} from 'vue';
import {formatDate} from '@/Utils/date';
import useProviderClassesColor from '@/Composables/useProviderClassesColor';
import Avatar from '@/Components/DataDisplay/Avatar.vue';

const props = defineProps({
    post: {
        type: Object,
        required: true
    }
});

const {providerColor} = useProviderClassesColor();

const formattedDate = computed(() => {
    return formatDate(props.post.scheduled_at || props.post.created_at);
});
</script>

<template>
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Header -->
        <div class="p-4 flex items-center space-x-2">
            <Avatar :src="post.account.image" :size="40"/>
            <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <p class="text-sm font-semibold text-gray-900 truncate">
                            {{ post.account.name }}
                        </p>
                        <span class="mx-1 text-gray-500">·</span>
                        <span class="text-sm text-gray-500">{{ formattedDate }}</span>
                    </div>
                </div>
                <p class="text-sm text-gray-500 truncate">
                    @{{ post.account.username }}
                </p>
            </div>
        </div>

        <!-- Content -->
        <div class="px-4 pb-4">
            <div class="text-sm text-gray-900 whitespace-pre-wrap break-words" v-html="post.content"></div>
        </div>

        <!-- Media -->
        <div v-if="post.media && post.media.length > 0" class="relative">
            <div class="aspect-w-16 aspect-h-9">
                <img :src="post.media[0].url" 
                     :alt="post.media[0].alt"
                     class="object-cover w-full h-full">
            </div>
            <div v-if="post.media.length > 1"
                 class="absolute top-2 right-2 bg-black bg-opacity-75 text-white text-sm px-2 py-1 rounded">
                +{{ post.media.length - 1 }}
            </div>
        </div>

        <!-- Footer -->
        <div class="px-4 py-2 border-t border-gray-100">
            <div class="flex items-center justify-between text-gray-500">
                <button class="flex items-center space-x-2 hover:text-gray-700">
                    <span class="text-sm">Favorite</span>
                </button>
                <button class="flex items-center space-x-2 hover:text-gray-700">
                    <span class="text-sm">Boost</span>
                </button>
                <button class="flex items-center space-x-2 hover:text-gray-700">
                    <span class="text-sm">Reply</span>
                </button>
            </div>
        </div>
    </div>
</template>
