<script setup>
import {Head} from '@inertiajs/vue3';
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import useNotifications from "@/Composables/useNotifications";
import useSelectable from "@/Composables/useSelectable";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import PrimaryButton from "@/Components/Button/PrimaryButton.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Account from "@/Components/Account/Account.vue";
import AccountEntities from "@/Pages/Accounts/AccountEntities.vue";
import ConfirmationModal from "@/Components/Modal/ConfirmationModal.vue";

const props = defineProps({
    accounts: {
        type: Array,
        required: true
    }
});

const {notify} = useNotifications();
const {selectedItems, selectAll, isSelected, toggleSelect, toggleSelectAll, clearSelected} = useSelectable();

const showEntitiesModal = ref(false);
const showDeleteModal = ref(false);
const selectedAccount = ref(null);

const openEntitiesModal = (account) => {
    selectedAccount.value = account;
    showEntitiesModal.value = true;
};

const closeEntitiesModal = () => {
    selectedAccount.value = null;
    showEntitiesModal.value = false;
};

const openDeleteModal = () => {
    showDeleteModal.value = true;
};

const closeDeleteModal = () => {
    showDeleteModal.value = false;
};

const deleteSelected = () => {
    router.delete(route('accounts.destroy', {ids: selectedItems.value}), {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Accounts deleted successfully.'
            });

            clearSelected();
            closeDeleteModal();
        }
    });
};
</script>

<template>
    <div>
        <Head title="Accounts"/>

        <PageHeader>
            <template #header>
                <h1 class="text-2xl font-semibold text-gray-900">
                    Accounts
                </h1>
            </template>
        </PageHeader>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-lg">
                            <div class="flex items-center gap-sm">
                                <input type="checkbox"
                                       :checked="selectAll"
                                       @change="toggleSelectAll(accounts.map(account => account.id))"
                                       class="form-checkbox">

                                <span class="text-sm text-gray-500">
                                    {{ selectedItems.length }} selected
                                </span>
                            </div>

                            <div v-if="selectedItems.length"
                                 class="flex items-center gap-sm">
                                <DangerButton @click="openDeleteModal">
                                    Delete Selected
                                </DangerButton>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            <div v-for="account in accounts"
                                 :key="account.id"
                                 class="relative">
                                <div class="absolute top-2 left-2">
                                    <input type="checkbox"
                                           :checked="isSelected(account.id)"
                                           @change="toggleSelect(account.id)"
                                           class="form-checkbox">
                                </div>

                                <button @click="openEntitiesModal(account)"
                                        class="block w-full text-left">
                                    <Account :provider="account.provider"
                                            :name="account.name"
                                            :img-url="account.image"
                                            :entities="account.entities"/>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AccountEntities v-if="showEntitiesModal"
                        :show="showEntitiesModal"
                        :account="selectedAccount"
                        @close="closeEntitiesModal"/>

        <ConfirmationModal :show="showDeleteModal"
                          @close="closeDeleteModal">
            <template #title>
                Delete Accounts
            </template>

            <template #content>
                Are you sure you want to delete the selected accounts? This action cannot be undone.
            </template>

            <template #footer>
                <SecondaryButton @click="closeDeleteModal">
                    Cancel
                </SecondaryButton>

                <DangerButton @click="deleteSelected"
                             class="ml-sm">
                    Delete
                </DangerButton>
            </template>
        </ConfirmationModal>
    </div>
</template>
