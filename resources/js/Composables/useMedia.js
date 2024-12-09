import {computed, ref} from "vue";
import {nanoid} from "nanoid";
import {router} from "@inertiajs/vue3";

export default function useMedia() {
    const uploadingFiles = ref([]);
    const uploadErrors = ref([]);

    const isUploading = computed(() => {
        return uploadingFiles.value.length > 0;
    });

    const hasUploadErrors = computed(() => {
        return uploadErrors.value.length > 0;
    });

    const uploadFile = (file) => {
        const id = nanoid();

        const uploadingFile = {
            id,
            name: file.name,
            progress: 0
        };

        uploadingFiles.value.push(uploadingFile);

        const formData = new FormData();
        formData.append('file', file);

        router.post(route('media.store'), formData, {
            preserveScroll: true,
            preserveState: true,
            onProgress: (progress) => {
                const index = uploadingFiles.value.findIndex((file) => file.id === id);
                if (index !== -1) {
                    uploadingFiles.value[index].progress = Math.floor(progress.percentage);
                }
            },
            onSuccess: () => {
                const index = uploadingFiles.value.findIndex((file) => file.id === id);
                if (index !== -1) {
                    uploadingFiles.value.splice(index, 1);
                }
            },
            onError: (errors) => {
                const index = uploadingFiles.value.findIndex((file) => file.id === id);
                if (index !== -1) {
                    uploadingFiles.value.splice(index, 1);
                }

                if (errors.file) {
                    uploadErrors.value.push({
                        id: nanoid(),
                        message: errors.file
                    });
                }
            }
        });
    };

    const uploadFiles = (files) => {
        Array.from(files).forEach((file) => {
            uploadFile(file);
        });
    };

    const removeUploadError = (id) => {
        const index = uploadErrors.value.findIndex((error) => error.id === id);
        if (index !== -1) {
            uploadErrors.value.splice(index, 1);
        }
    };

    const removeMedia = (id) => {
        router.delete(route('media.destroy', id), {
            preserveScroll: true,
            preserveState: true
        });
    };

    return {
        uploadingFiles,
        uploadErrors,
        isUploading,
        hasUploadErrors,
        uploadFile,
        uploadFiles,
        removeUploadError,
        removeMedia
    };
}
