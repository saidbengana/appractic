<script setup>
import {computed} from "vue";
import {capitalize} from "lodash";
import usePostVersions from "@/Composables/usePostVersions";
import ProviderIcon from "@/Components/Account/ProviderIcon.vue";

const props = defineProps({
    selectedAccounts: {
        required: true,
        type: Array
    },
    versions: {
        required: true,
        type: Array
    }
});

const {getAccountVersion} = usePostVersions();

const providers = computed(() => {
    const providers = {};

    props.selectedAccounts.forEach((account) => {
        if (!providers[account.provider]) {
            providers[account.provider] = {
                name: account.provider,
                version: getAccountVersion(props.versions, account.id)
            };
        }
    });

    return providers;
});

const hasProviders = computed(() => {
    return Object.keys(providers.value).length > 0;
});
</script>

<template>
    <div v-if="hasProviders" class="flex items-center gap-xs">
        <template v-for="provider in providers" :key="provider.name">
            <div class="flex items-center gap-xs">
                <ProviderIcon :provider="provider.name" class="w-4 h-4"/>
            </div>
        </template>
    </div>
</template>
