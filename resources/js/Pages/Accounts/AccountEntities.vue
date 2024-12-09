<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import useNotifications from "@/Composables/useNotifications";
import DialogModal from "@/Components/Modal/DialogModal.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue";
import Account from "@/Components/Account/Account.vue";

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    account: {
        type: Object,
        required: true
    }
});

const emit = defineEmits(['close']);

const {notify} = useNotifications();

const selectedEntity = ref(null);

const selectEntity = (entity) => {
    selectedEntity.value = entity;
};

const isEntitySelected = (entity) => {
    return selectedEntity.value?.id === entity.id;
};

const submit = () => {
    if (!selectedEntity.value) {
        return;
    }

    router.post(route('accounts.select-entity', props.account.id), {
        entity_id: selectedEntity.value.id
    }, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Account entity selected successfully.'
            });

            emit('close');
        }
    });
};
</script>

<template>
    <DialogModal :show="show"
                @close="$emit('close')">
        <template #title>
            Select Entity
        </template>

        <template #content>
            <div class="space-y-md">
                <div v-for="entity in account.entities"
                     :key="entity.id">
                    <button @click="selectEntity(entity)"
                            :class="{'ring-2 ring-primary-500': isEntitySelected(entity)}"
                            class="block w-full text-left rounded-lg">
                        <Account :provider="account.provider"
                                :name="entity.name"
                                :img-url="entity.image"/>
                    </button>
                </div>
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="$emit('close')">
                Cancel
            </SecondaryButton>

            <DangerButton @click="submit"
                         :disabled="!selectedEntity"
                         class="ml-sm">
                Select
            </DangerButton>
        </template>
    </DialogModal>
</template>
