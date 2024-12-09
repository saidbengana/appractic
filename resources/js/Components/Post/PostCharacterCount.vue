<script setup>
import {computed} from "vue";
import usePostVersions from "@/Composables/usePostVersions";
import {capitalize} from "lodash";

const props = defineProps({
    selectedAccounts: {
        required: true,
        type: Array
    },
    activeVersion: {
        required: true,
        type: Number
    },
    versions: {
        required: true,
        type: Array
    }
});

const {getAccountVersion} = usePostVersions();

const version = computed(() => {
    return getAccountVersion(props.versions, props.activeVersion);
});

const content = computed(() => {
    return version.value.content[0].body;
});

const accountsWithCharacterLimit = computed(() => {
    return props.selectedAccounts.filter((account) => {
        return account.provider_options.character_limit > 0;
    });
});

const characterLimitByProvider = computed(() => {
    const providers = {};

    accountsWithCharacterLimit.value.forEach((account) => {
        if (!providers[account.provider]) {
            providers[account.provider] = {
                name: account.provider,
                limit: account.provider_options.character_limit,
                count: content.value.length
            };
        }
    });

    return providers;
});

const hasCharacterLimit = computed(() => {
    return Object.keys(characterLimitByProvider.value).length > 0;
});

const isOverCharacterLimit = computed(() => {
    return Object.values(characterLimitByProvider.value).some((provider) => {
        return provider.count > provider.limit;
    });
});
</script>

<template>
    <div v-if="hasCharacterLimit" class="flex items-center gap-sm">
        <template v-for="provider in characterLimitByProvider" :key="provider.name">
            <div class="text-sm" :class="{'text-red-500': provider.count > provider.limit}">
                {{ capitalize(provider.name) }}: {{ provider.count }}/{{ provider.limit }}
            </div>
        </template>
    </div>
</template>
