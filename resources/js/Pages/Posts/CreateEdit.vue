<script setup>
import {computed, provide, reactive, ref, watch} from "vue";
import {Head, useForm} from '@inertiajs/vue3';
import {router} from "@inertiajs/vue3";
import {cloneDeep, debounce} from "lodash";
import useMounted from "@/Composables/useMounted";
import usePost from "@/Composables/usePost";
import usePostVersions from "@/Composables/usePostVersions";
import useNotifications from "@/Composables/useNotifications";
import PageHeader from "@/Components/DataDisplay/PageHeader.vue";
import PostForm from "@/Components/Post/PostForm.vue";
import PostActions from "@/Components/Post/PostActions.vue";
import PostPreviewProviders from "@/Components/Post/PostPreviewProviders.vue"
import SecondaryButton from "@/Components/Button/SecondaryButton.vue"
import PostStatus from "@/Components/Post/PostStatus.vue";
import Alert from "@/Components/Util/Alert.vue";
import PostLimitErrors from "@/Components/Post/PostLimitErrors.vue";
import EyeIcon from "@/Icons/Eye.vue"
import EyeOffIcon from "@/Icons/EyeOff.vue"

const props = defineProps(['post', 'schedule_at', 'accounts', 'prefill']);

const post = props.post ? cloneDeep(props.post) : null;

const context = reactive({
    textLimit: [],
    mediaLimit: []
});

provide('postCtx', context);

const {isMounted} = useMounted();
const showPreview = ref(false);
const isLoading = ref(false);
const triedToSave = ref(false);
const hasError = ref(false);

const {isInHistory, isScheduleProcessing, editAllowed} = usePost();
const {versionObject} = usePostVersions();
const {notify} = useNotifications();

const form = useForm({
    accounts: post ? post.accounts.map(account => account.id) : [],
    versions: post ? post.versions : [versionObject(0, true, props.prefill.body)],
    tags: post ? post.tags : [],
    date: post ? post.scheduled_at.date : props.schedule_at.date,
    time: post ? post.scheduled_at.time : props.schedule_at.time,
});

const postAccounts = computed(() => {
    if (isInHistory.value) {
        return post.accounts;
    }

    return props.accounts.filter(account => form.accounts.includes(account.id));
});

const store = debounce((data) => {
    if (!editAllowed.value) {
        return;
    }

    isLoading.value = true;

    router.post(route('posts.store'), data, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Post saved successfully.'
            });

            triedToSave.value = false;
        },
        onError: () => {
            triedToSave.value = true;
        }
    });
}, 500);

const update = debounce((data) => {
    if (!editAllowed.value) {
        return;
    }

    isLoading.value = true;

    router.patch(route('posts.update', post.id), data, {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Post updated successfully.'
            });

            triedToSave.value = false;
        },
        onError: () => {
            triedToSave.value = true;
        }
    });
}, 500);

const save = () => {
    if (!editAllowed.value) {
        return;
    }

    const data = {
        accounts: form.accounts,
        versions: form.versions,
        tags: form.tags,
        schedule_at: {
            date: form.date,
            time: form.time
        }
    };

    if (post) {
        update(data);
    } else {
        store(data);
    }
};

const watchTags = () => {
    watch(() => form.tags, () => {
        save();
    }, {deep: true});
};

// PostTags component deal directly with tag itself, such as renaming & changing the color,
// in this case, it's necessary to track the 'post.tags' props and update them.
// This if statement will only work in edit mode and when the page is loaded directly.
if (props.post) {
    watchTags();
}

watch(() => form.accounts, () => {
    save();
}, {deep: true});

watch(() => form.versions, () => {
    save();
}, {deep: true});

watch(() => form.date, () => {
    save();
});

watch(() => form.time, () => {
    save();
});

watch(() => context.textLimit, () => {
    hasError.value = context.textLimit.length > 0;
}, {deep: true});

watch(() => context.mediaLimit, () => {
    hasError.value = context.mediaLimit.length > 0;
}, {deep: true});
</script>

<template>
    <div>
        <Head :title="post ? 'Edit Post' : 'Create Post'"/>

        <div class="row-py mb-2xl">
            <PageHeader :title="post ? 'Edit Post' : 'Create Post'">
                <template #right>
                    <div class="flex items-center gap-md">
                        <div v-if="post" class="flex items-center gap-sm">
                            <PostStatus :status="post.status"/>
                        </div>

                        <div class="flex items-center gap-sm">
                            <SecondaryButton @click="showPreview = !showPreview">
                                <template #icon>
                                    <EyeIcon v-if="!showPreview" class="w-lg"/>
                                    <EyeOffIcon v-else class="w-lg"/>
                                </template>
                                {{ showPreview ? 'Hide Preview' : 'Show Preview' }}
                            </SecondaryButton>
                        </div>
                    </div>
                </template>
            </PageHeader>

            <div v-if="hasError" class="mt-xl">
                <Alert type="error">
                    <PostLimitErrors :text-limit="context.textLimit" :media-limit="context.mediaLimit"/>
                </Alert>
            </div>

            <div class="mt-xl">
                <div class="grid grid-cols-12 gap-xl">
                    <div :class="{'col-span-12': !showPreview, 'col-span-6': showPreview}">
                        <PostForm
                            :accounts="props.accounts"
                            :post-accounts="postAccounts"
                            :versions="form.versions"
                            :tags="form.tags"
                            :date="form.date"
                            :time="form.time"
                            :is-loading="isLoading"
                            :tried-to-save="triedToSave"
                            :is-in-history="isInHistory"
                            :is-schedule-processing="isScheduleProcessing"
                            @update:accounts="form.accounts = $event"
                            @update:versions="form.versions = $event"
                            @update:tags="form.tags = $event"
                            @update:date="form.date = $event"
                            @update:time="form.time = $event"
                        >
                            <template #actions>
                                <PostActions
                                    :post="post"
                                    :has-error="hasError"
                                    :is-loading="isLoading"
                                    :is-in-history="isInHistory"
                                    :is-schedule-processing="isScheduleProcessing"
                                />
                            </template>
                        </PostForm>
                    </div>

                    <div v-if="showPreview" class="col-span-6">
                        <PostPreviewProviders
                            :accounts="postAccounts"
                            :versions="form.versions"
                            :is-in-history="isInHistory"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
