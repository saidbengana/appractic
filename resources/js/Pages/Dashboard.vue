<template>
  <div>
    <Head title="Dashboard"/>

    <PageHeader>
      <template #header>
        <h1 class="text-2xl font-semibold text-stone-900">
          Dashboard
        </h1>
      </template>
    </PageHeader>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <!-- Stats -->
      <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div
          v-for="item in stats"
          :key="item.name"
          class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6"
        >
          <dt>
            <div class="absolute rounded-md bg-indigo-500 p-3">
              <component
                :is="item.icon"
                class="h-6 w-6 text-white"
                aria-hidden="true"
              />
            </div>
            <p class="ml-16 truncate text-sm font-medium text-stone-500">
              {{ item.name }}
            </p>
          </dt>
          <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
            <p class="text-2xl font-semibold text-stone-900">
              <span v-if="isLoading">...</span>
              <span v-else>{{ item.value }}</span>
            </p>
          </dd>
        </div>
      </dl>

      <!-- Recent Activity -->
      <div class="mt-8">
        <div class="mx-auto max-w-7xl">
          <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
              <h3 class="text-base font-semibold leading-6 text-stone-900">
                Recent Activity
              </h3>
              <div class="mt-6">
                <div v-if="isLoading" class="text-center py-12">
                  <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-solid border-current border-r-transparent motion-reduce:animate-[spin_1.5s_linear_infinite]" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                <div v-else class="text-center py-12 text-stone-500">
                  No recent activity
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import {Head} from '@inertiajs/vue3';
import {ref, onMounted} from 'vue';
import PageHeader from '@/Components/DataDisplay/PageHeader.vue';

const stats = ref([
  { name: 'Total Posts', value: '0' },
  { name: 'Scheduled', value: '0' },
  { name: 'Published', value: '0' },
  { name: 'Failed', value: '0' },
]);

const isLoading = ref(true);

onMounted(() => {
  // Simulate loading
  setTimeout(() => {
    isLoading.value = false;
  }, 1000);
});
</script>
