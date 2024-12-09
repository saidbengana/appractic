<script setup>
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import useNotifications from "@/Composables/useNotifications";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import Panel from "@/Components/Surface/Panel.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import ColorPicker from "@/Components/Package/ColorPicker.vue";

const props = defineProps({
    settings: {
        type: Object,
        required: true
    }
});

const {notify} = useNotifications();

const form = ref({
    primary_color: props.settings.primary_color,
    tenor_api_key: props.settings.tenor_api_key,
    unsplash_api_key: props.settings.unsplash_api_key
});

const submit = () => {
    router.put(route('settings.update'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Settings updated successfully.'
            });
        }
    });
};
</script>

<template>
    <div>
        <Head title="Settings"/>

        <PageHeader>
            <template #header>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Settings
                </h1>
            </template>
        </PageHeader>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mt-8">
                <form @submit.prevent="submit">
                    <Panel>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Primary Color
                                    </label>
                                    <div class="mt-1">
                                        <ColorPicker v-model="form.primary_color"/>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Tenor API Key
                                    </label>
                                    <div class="mt-1">
                                        <input type="text"
                                               v-model="form.tenor_api_key"
                                               class="form-input">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Unsplash API Key
                                    </label>
                                    <div class="mt-1">
                                        <input type="text"
                                               v-model="form.unsplash_api_key"
                                               class="form-input">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end px-6 py-3 bg-gray-50">
                            <PrimaryButton type="submit">
                                Save Changes
                            </PrimaryButton>
                        </div>
                    </Panel>
                </form>
            </div>
        </div>
    </div>
</template>
