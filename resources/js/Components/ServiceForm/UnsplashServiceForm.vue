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
    access_key: props.service.access_key || '',
    secret_key: props.service.secret_key || '',
});

const errors = ref({});
const processing = ref(false);

const submit = () => {
    processing.value = true;
    errors.value = {};

    router.post(route('services.unsplash.store'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Unsplash service settings updated successfully.'
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
                v-model="form.access_key"
                :error="errors.access_key"
                label="Access Key"
                type="password"
                placeholder="Enter your Unsplash Access Key"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.secret_key"
                :error="errors.secret_key"
                label="Secret Key"
                type="password"
                placeholder="Enter your Unsplash Secret Key"
                required
            />
            <p class="mt-2 text-sm text-gray-500">
                Get your API keys from the <a href="https://unsplash.com/developers" target="_blank" class="text-primary-600 hover:text-primary-500">Unsplash Developer Dashboard</a>
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
