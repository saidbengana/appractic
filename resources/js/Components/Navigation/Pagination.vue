<script setup>
import {computed} from "vue";
import {Link} from "@inertiajs/vue3";
import ChevronLeftIcon from "@/Components/Icons/ChevronLeftIcon.vue";
import ChevronRightIcon from "@/Components/Icons/ChevronRightIcon.vue";

const props = defineProps({
    links: {
        type: Array,
        required: true
    }
});

const pages = computed(() => {
    return props.links.filter((link) => {
        return !['Previous', 'Next'].includes(link.label);
    });
});

const previousPage = computed(() => {
    return props.links.find((link) => {
        return link.label === 'Previous';
    });
});

const nextPage = computed(() => {
    return props.links.find((link) => {
        return link.label === 'Next';
    });
});

const hasPages = computed(() => {
    return pages.value.length > 1;
});
</script>

<template>
    <div v-if="hasPages" class="flex items-center justify-between">
        <div class="flex items-center gap-sm">
            <Link v-if="previousPage"
                  :href="previousPage.url"
                  :class="{'text-gray-300 cursor-not-allowed': !previousPage.url}"
                  class="flex items-center gap-xs text-sm font-medium text-gray-500 hover:text-gray-700">
                <ChevronLeftIcon class="w-4 h-4"/>
                Previous
            </Link>
        </div>

        <div class="hidden sm:flex items-center gap-xs">
            <template v-for="(page, index) in pages" :key="index">
                <Link v-if="page.url"
                      :href="page.url"
                      :class="{'bg-primary-50 text-primary-500': page.active}"
                      class="px-3 py-1 text-sm font-medium text-gray-500 hover:text-gray-700 rounded-md">
                    {{ page.label }}
                </Link>

                <span v-else
                      class="px-3 py-1 text-sm font-medium text-gray-500">
                    {{ page.label }}
                </span>
            </template>
        </div>

        <div class="flex items-center gap-sm">
            <Link v-if="nextPage"
                  :href="nextPage.url"
                  :class="{'text-gray-300 cursor-not-allowed': !nextPage.url}"
                  class="flex items-center gap-xs text-sm font-medium text-gray-500 hover:text-gray-700">
                Next
                <ChevronRightIcon class="w-4 h-4"/>
            </Link>
        </div>
    </div>
</template>
