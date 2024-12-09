<script setup>
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import ServiceCard from "@/Components/Service/ServiceCard.vue";
import ServiceConnectModal from "@/Components/Service/ServiceConnectModal.vue";

const props = defineProps({
    services: {
        type: Array,
        required: true
    }
});

const showConnectModal = ref(false);
const selectedService = ref(null);

const openConnectModal = (service) => {
    selectedService.value = service;
    showConnectModal.value = true;
};

const closeConnectModal = () => {
    selectedService.value = null;
    showConnectModal.value = false;
};
</script>

<template>
    <div>
        <Head title="Services"/>

        <PageHeader>
            <template #header>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Services
                </h1>
            </template>
        </PageHeader>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mt-8">
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <ServiceCard v-for="service in services"
                               :key="service.id"
                               :service="service"
                               @connect="openConnectModal"/>
                </div>
            </div>
        </div>

        <ServiceConnectModal :show="showConnectModal"
                           :service="selectedService"
                           @close="closeConnectModal"/>
    </div>
</template>
