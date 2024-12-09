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
});

const errors = ref({});
const processing = ref(false);

const submit = () => {
    processing.value = true;
    errors.value = {};

    router.post(route('services.tenor.store'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Tenor service settings updated successfully.'
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
                placeholder="Enter your Tenor API Key"
                required
            />
            <p class="mt-2 text-sm text-gray-500">
                Get your API key from the <a href="https://tenor.com/developer/dashboard" target="_blank" class="text-primary-600 hover:text-primary-500">Tenor Developer Dashboard</a>
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
