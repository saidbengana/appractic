<script setup>
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import useNotifications from "@/Composables/useNotifications";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import Panel from "@/Components/Surface/Panel.vue";
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";

const props = defineProps({
    user: {
        type: Object,
        required: true
    }
});

const {notify} = useNotifications();

const form = ref({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: ''
});

const submit = () => {
    router.put(route('profile.update'), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            form.value.password = '';
            form.value.password_confirmation = '';

            notify({
                type: 'success',
                message: 'Profile updated successfully.'
            });
        }
    });
};
</script>

<template>
    <div>
        <Head title="Profile"/>

        <PageHeader>
            <template #header>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Profile
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
                                        Name
                                    </label>
                                    <div class="mt-1">
                                        <input type="text"
                                               v-model="form.name"
                                               class="form-input">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Email
                                    </label>
                                    <div class="mt-1">
                                        <input type="email"
                                               v-model="form.email"
                                               class="form-input">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        New Password
                                    </label>
                                    <div class="mt-1">
                                        <input type="password"
                                               v-model="form.password"
                                               class="form-input">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">
                                        Confirm Password
                                    </label>
                                    <div class="mt-1">
                                        <input type="password"
                                               v-model="form.password_confirmation"
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
