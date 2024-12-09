<script setup>
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import useMedia from "@/Composables/useMedia";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import AddMedia from "@/Components/Media/AddMedia.vue";
import MediaUploads from "@/Components/Media/MediaUploads.vue";
import MediaGifs from "@/Components/Media/MediaGifs.vue";
import MediaStock from "@/Components/Media/MediaStock.vue";

const props = defineProps({
    media: {
        type: Object,
        required: true
    }
});

const {uploadingFiles, uploadErrors, isUploading, hasUploadErrors, uploadFiles, removeUploadError} = useMedia();

const tab = ref('uploads');

const setTab = (value) => {
    tab.value = value;
};

const isTabSelected = (value) => {
    return tab.value === value;
};

const onFilesDrop = (files) => {
    uploadFiles(files);
};
</script>

<template>
    <div>
        <Head title="Media"/>

        <PageHeader>
            <template #header>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Media
                </h1>
            </template>

            <template #actions>
                <AddMedia @upload="uploadFiles"/>
            </template>
        </PageHeader>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex items-center gap-sm mb-lg">
                            <PrimaryButton @click="setTab('uploads')"
                                         :class="{'!bg-primary-50': isTabSelected('uploads')}">
                                Uploads
                            </PrimaryButton>

                            <PrimaryButton @click="setTab('gifs')"
                                         :class="{'!bg-primary-50': isTabSelected('gifs')}">
                                GIFs
                            </PrimaryButton>

                            <PrimaryButton @click="setTab('stock')"
                                         :class="{'!bg-primary-50': isTabSelected('stock')}">
                                Stock
                            </PrimaryButton>
                        </div>

                        <MediaUploads v-if="isTabSelected('uploads')"
                                    :media="media"
                                    :uploading-files="uploadingFiles"
                                    :upload-errors="uploadErrors"
                                    @remove-error="removeUploadError"
                                    @drop="onFilesDrop"/>

                        <MediaGifs v-if="isTabSelected('gifs')"/>

                        <MediaStock v-if="isTabSelected('stock')"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
