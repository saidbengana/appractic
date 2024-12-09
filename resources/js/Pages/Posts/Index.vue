<script setup>
import {onMounted, onUnmounted, ref, watch} from "vue";
import {Head} from '@inertiajs/vue3';
import {router} from "@inertiajs/vue3";
import emitter from "@/Services/emitter";
import useNotifications from "@/Composables/useNotifications";
import {cloneDeep, pickBy, throttle} from "lodash";
import useSelectable from "@/Composables/useSelectable";
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';
import PostsFilter from '@/Components/Post/PostsFilter.vue';
import Tabs from "@/Components/Navigation/Tabs.vue"
import Tab from "@/Components/Navigation/Tab.vue"
import Panel from "@/Components/Surface/Panel.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";
import Table from "@/Components/DataDisplay/Table.vue";
import TableRow from "@/Components/DataDisplay/TableRow.vue";
import TableCell from "@/Components/DataDisplay/TableCell.vue";
import SecondaryButton from "@/Components/Button/SecondaryButton.vue";
import PureDangerButton from "@/Components/Button/PureDangerButton.vue";
import DangerButton from "@/Components/Button/DangerButton.vue"
import PostItem from "@/Components/Post/PostItem.vue";
import SelectableBar from "@/Components/DataDisplay/SelectableBar.vue";
import ConfirmationModal from "@/Components/Modal/ConfirmationModal.vue";
import Pagination from "@/Components/Navigation/Pagination.vue";
import NoResult from "@/Components/Util/NoResult.vue";
import TrashIcon from "@/Icons/Trash.vue";

const props = defineProps({
    filter: {
        type: Object,
        default: {}
    },
    posts: {
        type: Object,
    },
    has_failed_posts: {
        type: Boolean,
        default: false
    }
});

const filter = ref({
    keyword: props.filter.keyword,
    status: props.filter.status,
    tags: props.filter.tags,
    accounts: props.filter.accounts
});

const {
    selectedRecords,
    putPageRecords,
    selectAllRecords,
    isSelectedRecord,
    toggleSelectRecord,
    toggleSelectAllRecords,
    clearSelectedRecords
} = useSelectable();

const itemsId = () => {
    return props.posts.data.map(post => post.id);
};

onMounted(() => {
    putPageRecords(itemsId());

    emitter.on('postDelete', id => {
        selectedRecords.value = selectedRecords.value.filter(recordId => recordId !== id);
    });
});

onUnmounted(() => {
    emitter.off('postDelete');
});

const {notify} = useNotifications();

const showDeleteModal = ref(false);

const deletePosts = () => {
    router.delete(route('posts.destroy', {ids: selectedRecords.value}), {
        preserveScroll: true,
        onSuccess: () => {
            notify({
                type: 'success',
                message: 'Posts deleted successfully.'
            });

            clearSelectedRecords();
            showDeleteModal.value = false;
        }
    });
};
</script>

<template>
    <Head title="Posts"/>

    <div class="row-py mb-2xl">
        <PageHeader title="Posts"/>

        <div class="mt-xl">
            <PostsFilter v-model:filter="filter"/>
        </div>

        <div class="mt-xl">
            <div v-if="has_failed_posts" class="mb-xl">
                <Tabs>
                    <Tab :href="route('posts.index', {status: 'failed'})" :active="filter.status === 'failed'">
                        Failed Posts
                    </Tab>
                </Tabs>
            </div>

            <Panel>
                <div class="flex flex-col gap-md">
                    <div class="flex items-center justify-between gap-md">
                        <div class="flex items-center gap-md">
                            <Checkbox
                                :model-value="selectAllRecords"
                                @update:model-value="toggleSelectAllRecords"
                            />

                            <div v-if="selectedRecords.length > 0">
                                <PureDangerButton @click="showDeleteModal = true">
                                    <template #icon>
                                        <TrashIcon class="w-lg"/>
                                    </template>
                                    Delete
                                </PureDangerButton>
                            </div>
                        </div>

                        <div class="flex items-center gap-md">
                            <SecondaryButton :href="route('posts.create')">
                                Create Post
                            </SecondaryButton>
                        </div>
                    </div>

                    <Table>
                        <TableRow v-for="post in posts.data" :key="post.id">
                            <TableCell class="w-[40px]">
                                <Checkbox
                                    :model-value="isSelectedRecord(post.id)"
                                    @update:model-value="toggleSelectRecord(post.id)"
                                />
                            </TableCell>
                            <TableCell>
                                <PostItem :post="post"/>
                            </TableCell>
                        </TableRow>
                    </Table>

                    <div v-if="posts.data.length === 0">
                        <NoResult>No posts found.</NoResult>
                    </div>
                </div>
            </Panel>

            <div v-if="posts.meta.total > posts.meta.per_page" class="mt-xl">
                <Pagination :links="posts.meta.links"/>
            </div>
        </div>
    </div>

    <ConfirmationModal
        :show="showDeleteModal"
        @close="showDeleteModal = false"
        @confirm="deletePosts"
    >
        <template #title>
            Delete Posts
        </template>

        <template #content>
            Are you sure you want to delete these posts? This action cannot be undone.
        </template>

        <template #footer>
            <div class="flex justify-end gap-md">
                <SecondaryButton @click="showDeleteModal = false">
                    Cancel
                </SecondaryButton>

                <DangerButton @click="deletePosts">
                    Delete
                </DangerButton>
            </div>
        </template>
    </ConfirmationModal>
</template>
