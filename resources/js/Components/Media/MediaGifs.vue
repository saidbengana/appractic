<script setup>
import {computed, onMounted} from "vue";
import {usePage, Link} from "@inertiajs/vue3";
import useMedia from "@/Composables/useMedia";
import MediaSelectable from "@/Components/Media/MediaSelectable.vue";
import MediaFile from "@/Components/Media/MediaFile.vue";
import Masonry from "@/Components/Layout/Masonry.vue";
import SearchInput from "@/Components/Util/SearchInput.vue";
import MediaCredit from "@/Components/Media/MediaCredit.vue";
import NoResult from "@/Components/Util/NoResult.vue";
import Alert from "@/Components/Util/Alert.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps({
    columns: {
        type: Number,
        default: 3
    }
})

const enabled = computed(() => {
    return usePage().props.is_configured_service.tenor;
})

const {
    isLoaded,
    keyword,
    page,
    items,
    endlessPagination,
    selected,
    toggleSelect,
    deselectAll,
    isSelected,
    createObserver
} = useMedia('appractic.media.fetchGifs');

onMounted(() => {
    if (enabled.value) {
        createObserver();
    }
});

defineExpose({selected, deselectAll})
</script>
<template>
    <div v-if="enabled">
        <SearchInput v-model="keyword" placeholder="Search Tenor GIFs"/>

        <div v-if="items.length" class="mt-lg">
            <Masonry :items="items" :columns="columns">
                <template #default="{item}">
                    <MediaSelectable v-if="item" :active="isSelected(item)" @click="toggleSelect(item)">
                        <MediaFile :media="item"/>
                        <MediaCredit>via Tenor</MediaCredit>
                    </MediaSelectable>
                </template>
            </Masonry>
        </div>

        <div v-if="isLoaded && !items.length" class="mt-lg">
            <NoResult>No GIFs found</NoResult>
        </div>

        <div ref="endlessPagination" class="-z-10 w-full"/>
    </div>

    <div v-else>
        <Alert type="info">
            <template #title>Tenor GIFs is not configured</template>
            <template #description>
                To use Tenor GIFs, you need to configure the API key in the
                <Link :href="route('appractic.settings.services')" class="text-indigo-600 hover:text-indigo-900">Services Settings</Link>.
            </template>
        </Alert>
    </div>
</template>
