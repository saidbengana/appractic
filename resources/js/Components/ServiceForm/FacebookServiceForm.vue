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
    app_id: props.service.app_id || '',
    app_secret: props.service.app_secret || '',
    redirect_url: props.service.redirect_url || '',
});

const errors = ref({});
const processing = ref(false);

const submit = () => {
    processing.value = true;
    errors.value = {};

    router.post(route('services.facebook.store'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Facebook service settings updated successfully.'
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
                v-model="form.app_id"
                :error="errors.app_id"
                label="App ID"
                placeholder="Enter your Facebook App ID"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.app_secret"
                :error="errors.app_secret"
                label="App Secret"
                type="password"
                placeholder="Enter your Facebook App Secret"
                required
            />
        </div>

        <div>
            <TextInput
                v-model="form.redirect_url"
                :error="errors.redirect_url"
                label="Redirect URL"
                placeholder="Enter your OAuth Redirect URL"
                required
            />
            <p class="mt-2 text-sm text-gray-500">
                Add this URL to your Facebook App OAuth settings
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
