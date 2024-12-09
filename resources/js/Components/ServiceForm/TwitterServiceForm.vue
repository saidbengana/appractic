<script setup>
import {ref} from 'vue';
import {router} from '@inertiajs/vue3';
import useNotifications from '@/Composables/useNotifications';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import SecondaryButton from '@/Components/Button/SecondaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';

const props = defineProps({
    service: {
        type: Object,
        required: true
    }
});

const {notify} = useNotifications();

const form = ref({
    api_key: props.service.api_key || '',
    api_key_secret: props.service.api_key_secret || '',
    access_token: props.service.access_token || '',
    access_token_secret: props.service.access_token_secret || '',
    bearer_token: props.service.bearer_token || '',
    client_id: props.service.client_id || '',
    client_secret: props.service.client_secret || '',
});

const errors = ref({});
const processing = ref(false);

const submit = () => {
    processing.value = true;
    errors.value = {};

    router.post(route('services.twitter.store'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Twitter service settings updated successfully.'
            });
            processing.value = false;
        },
        onError: (err) => {
            errors.value = err;
            processing.value = false;
        }
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-6">
        <div>
            <TextInput
                v-model="form.api_key"
                :error="errors.api_key"
                label="API Key"
                type="password"
                placeholder="Enter your Twitter API Key"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.api_key_secret"
                :error="errors.api_key_secret"
                label="API Key Secret"
                type="password"
                placeholder="Enter your Twitter API Key Secret"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.access_token"
                :error="errors.access_token"
                label="Access Token"
                type="password"
                placeholder="Enter your Twitter Access Token"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.access_token_secret"
                :error="errors.access_token_secret"
                label="Access Token Secret"
                type="password"
                placeholder="Enter your Twitter Access Token Secret"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.bearer_token"
                :error="errors.bearer_token"
                label="Bearer Token"
                type="password"
                placeholder="Enter your Twitter Bearer Token"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.client_id"
                :error="errors.client_id"
                label="Client ID"
                type="password"
                placeholder="Enter your Twitter Client ID"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.client_secret"
                :error="errors.client_secret"
                label="Client Secret"
                type="password"
                placeholder="Enter your Twitter Client Secret"
                required
            />
            <p class="mt-2 text-sm text-gray-500">
                Get your API keys from the <a href="https://developer.twitter.com/en/portal/dashboard" target="_blank" class="text-primary-600 hover:text-primary-500">Twitter Developer Portal</a>
            </p>
        </div>

        <div class="flex items-center justify-end space-x-3">
            <SecondaryButton type="button" :disabled="processing">
                Cancel
            </SecondaryButton>
            <PrimaryButton type="submit" :loading="processing">
                Save Changes
            </PrimaryButton>
        </div>
    </form>
</template>
