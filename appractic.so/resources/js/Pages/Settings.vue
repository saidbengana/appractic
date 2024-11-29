<script setup>
import {Head} from '@inertiajs/vue3';
import {ref, watch} from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Card from '@/Components/Surface/Card.vue';
import CardContent from '@/Components/Surface/CardContent.vue';
import CardFooter from '@/Components/Surface/CardFooter.vue';
import Input from '@/Components/Form/Input.vue';
import Label from '@/Components/Form/Label.vue';
import TextArea from '@/Components/Form/TextArea.vue';
import PrimaryButton from '@/Components/Button/PrimaryButton.vue';
import useForm from '@/Composables/useForm';
import {routes} from '@/routes.js';
import {useToast} from 'vue-toastification';

const toast = useToast();

const props = defineProps({
    settings: Object
});

const form = useForm({
    app_name: props.settings.app_name,
    app_url: props.settings.app_url,
    date_format: props.settings.date_format,
    time_format: props.settings.time_format,
    timezone: props.settings.timezone,
    giphy_api_key: props.settings.giphy_api_key,
    unsplash_api_key: props.settings.unsplash_api_key,
    pexels_api_key: props.settings.pexels_api_key,
    pixabay_api_key: props.settings.pixabay_api_key,
    google_analytics_id: props.settings.google_analytics_id,
    custom_head_tags: props.settings.custom_head_tags
});

const submit = () => {
    form.put(route(routes.settings.update), {
        preserveScroll: true,
        onSuccess: () => {
            toast.success('Settings updated successfully');
        }
    });
};
</script>

<template>
    <AppLayout>
        <Head>
            <title>Settings - {{ $page.props.appractic.name }}</title>
        </Head>

        <div class="max-w-5xl mx-auto px-md sm:px-lg">
            <form @submit.prevent="submit">
                <Card>
                    <CardContent>
                        <div class="space-y-lg">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">General Settings</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Configure your application's general settings.
                                </p>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="app_name" value="Application Name"/>
                                    <Input id="app_name"
                                           v-model="form.app_name"
                                           type="text"
                                           class="mt-1 block w-full"
                                           required/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="app_url" value="Application URL"/>
                                    <Input id="app_url"
                                           v-model="form.app_url"
                                           type="url"
                                           class="mt-1 block w-full"
                                           required/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="date_format" value="Date Format"/>
                                    <Input id="date_format"
                                           v-model="form.date_format"
                                           type="text"
                                           class="mt-1 block w-full"
                                           required/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="time_format" value="Time Format"/>
                                    <Input id="time_format"
                                           v-model="form.time_format"
                                           type="text"
                                           class="mt-1 block w-full"
                                           required/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="timezone" value="Timezone"/>
                                    <Input id="timezone"
                                           v-model="form.timezone"
                                           type="text"
                                           class="mt-1 block w-full"
                                           required/>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-lg">
                                <h3 class="text-lg font-medium text-gray-900">Media Integration</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Configure your media service API keys.
                                </p>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="giphy_api_key" value="GIPHY API Key"/>
                                    <Input id="giphy_api_key"
                                           v-model="form.giphy_api_key"
                                           type="text"
                                           class="mt-1 block w-full"/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="unsplash_api_key" value="Unsplash API Key"/>
                                    <Input id="unsplash_api_key"
                                           v-model="form.unsplash_api_key"
                                           type="text"
                                           class="mt-1 block w-full"/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="pexels_api_key" value="Pexels API Key"/>
                                    <Input id="pexels_api_key"
                                           v-model="form.pexels_api_key"
                                           type="text"
                                           class="mt-1 block w-full"/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="pixabay_api_key" value="Pixabay API Key"/>
                                    <Input id="pixabay_api_key"
                                           v-model="form.pixabay_api_key"
                                           type="text"
                                           class="mt-1 block w-full"/>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-lg">
                                <h3 class="text-lg font-medium text-gray-900">Analytics & Custom Code</h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Configure analytics tracking and custom HTML code.
                                </p>
                            </div>

                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="google_analytics_id" value="Google Analytics ID"/>
                                    <Input id="google_analytics_id"
                                           v-model="form.google_analytics_id"
                                           type="text"
                                           class="mt-1 block w-full"/>
                                </div>

                                <div class="col-span-6 sm:col-span-4">
                                    <Label for="custom_head_tags" value="Custom Head Tags"/>
                                    <TextArea id="custom_head_tags"
                                             v-model="form.custom_head_tags"
                                             class="mt-1 block w-full h-32"
                                             placeholder="<!-- Add your custom HTML tags here -->"/>
                                </div>
                            </div>
                        </div>
                    </CardContent>

                    <CardFooter>
                        <PrimaryButton :class="{ 'opacity-25': form.processing }"
                                     :disabled="form.processing">
                            Save Changes
                        </PrimaryButton>
                    </CardFooter>
                </Card>
            </form>
        </div>
    </AppLayout>
</template>
