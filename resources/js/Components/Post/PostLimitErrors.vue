<script setup>
import {computed} from "vue";
import usePostVersions from "@/Composables/usePostVersions";
import {capitalize} from "lodash";
import ExclamationCircleIcon from "@/Components/Icons/ExclamationCircleIcon.vue";

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

const accountsWithMediaLimit = computed(() => {
    return props.selectedAccounts.filter((account) => {
        return account.provider_options.media_limit > 0;
    });
});

const mediaLimitByProvider = computed(() => {
    const providers = {};

    accountsWithMediaLimit.value.forEach((account) => {
        const version = getAccountVersion(props.versions, account.id);
        const mediaCount = version.content[0].media.length;

        if (!providers[account.provider] && mediaCount > account.provider_options.media_limit) {
            providers[account.provider] = {
                name: account.provider,
                limit: account.provider_options.media_limit,
                count: mediaCount
            };
        }
    });

    return providers;
});

const hasMediaLimitError = computed(() => {
    return Object.keys(mediaLimitByProvider.value).length > 0;
});
</script>

<template>
    <div v-if="hasMediaLimitError" class="flex items-center gap-sm text-red-500">
        <ExclamationCircleIcon class="w-4 h-4"/>

        <div class="text-sm">
            <template v-for="provider in mediaLimitByProvider" :key="provider.name">
                {{ capitalize(provider.name) }} allows a maximum of {{ provider.limit }} media files per post
            </template>
        </div>
    </div>
</template>
