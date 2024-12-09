<script setup>
import {computed} from 'vue';
import {formatNumber} from '@/Utils/number';
import {REPRESENTATIVE_DATA_TEXT} from '@/Constants/Text';
import Card from '@/Components/Surface/Card.vue';
import ReportChart from '@/Components/Chart/ReportChart.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true
    }
});

const metrics = computed(() => [
    {
        title: 'Followers',
        value: formatNumber(props.data.followers),
        change: props.data.followers_change,
        chart: props.data.followers_chart
    },
    {
        title: 'Following',
        value: formatNumber(props.data.following),
        change: props.data.following_change,
        chart: props.data.following_chart
    },
    {
        title: 'Post Reach',
        value: formatNumber(props.data.post_reach),
        change: props.data.post_reach_change,
        chart: props.data.post_reach_chart
    },
    {
        title: 'Post Engagement',
        value: formatNumber(props.data.post_engagement),
        change: props.data.post_engagement_change,
        chart: props.data.post_engagement_chart
    }
]);
</script>

<template>
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <Card v-for="metric in metrics" :key="metric.title">
            <template #header>
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-900">
                        {{ metric.title }}
                    </h3>
                    <span :class="[
                        metric.change >= 0 ? 'text-green-600' : 'text-red-600',
                        'text-sm font-medium'
                    ]">
                        {{ metric.change >= 0 ? '+' : '' }}{{ metric.change }}%
                    </span>
                </div>
            </template>

            <div class="flex items-baseline justify-between">
                <p class="text-2xl font-semibold text-gray-900">
                    {{ metric.value }}
                </p>
                <ReportChart :data="metric.chart"
                            :positive="metric.change >= 0"/>
            </div>

            <template #footer>
                <p class="text-xs text-gray-500">
                    {{ REPRESENTATIVE_DATA_TEXT }}
                </p>
            </template>
        </Card>
    </div>
</template>
