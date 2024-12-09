<script setup>
import {onBeforeUnmount, onMounted, ref, toRaw, watch} from "vue";
import {toRawIfProxy} from "@/helpers";
import {
    Chart,
    BarController,
    LineController,
    LineElement,
    PointElement,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
} from "chart.js";

import zoomPlugin from 'chartjs-plugin-zoom';

Chart.register(BarController, LineController, PointElement, LineElement, BarElement, CategoryScale, LinearScale, Tooltip, zoomPlugin);

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
})

const dom = ref();
const chartRef = ref(null);
const zoomed = ref(false);

const resetZoom = () => {
    if (!chartRef.value) {
        return;
    }

    chartRef.value.resetZoom();
    zoomed.value = false;
}

onMounted(() => {
    chartRef.value = new Chart(dom.value.getContext('2d'), {
        type: 'bar',
        data: {
            labels: props.data.labels,
            datasets: props.data.datasets
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            barPercentage: 0.75,
            interaction: {
                intersect: false,
                mode: 'index',
            },
            plugins: {
                zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        modifierKey: 'ctrl',
                    },
                    zoom: {
                        drag: {
                            enabled: true,
                        },
                        mode: 'x',
                        onZoomComplete: () => (zoomed.value = true),
                    },
                },
                tooltip: {
                    backgroundColor: '#1F1B4B',
                    titleSpacing: 4,
                    bodySpacing: 8,
                    padding: 20,
                    displayColors: false,
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';
                            let value = context.raw;

                            if (typeof value === 'number') {
                                value = Math.abs(value);
                            }

                            return `${label}: ${value}`;
                        }
                    },
                },
            },
            scales: {
                y1: {
                    ticks: {
                        color: 'rgba(100, 116, 139, 1)',
                        precision: 0,
                    },
                    position: 'left',
                    beginAtZero: false,
                    grid: {
                        display: false,
                    },
                },
                y2: {
                    ticks: {
                        color: 'rgba(100, 116, 139, 1)',
                        precision: 0,
                    },
                    position: 'right',
                    beginAtZero: false,
                    grid: {
                        display: false,
                    },
                },
                x: {
                    ticks: {
                        color: 'rgba(100, 116, 139, 1)',
                    },
                    grid: {
                        display: false,
                    },
                },
            },
        },
    });
});

watch(
    () => toRawIfProxy(props.data),
    (newValue) => {
        if (!chartRef.value) {
            return;
        }

        chartRef.value.data = toRaw(newValue);
        chartRef.value.update();
    },
    {deep: true}
);

onBeforeUnmount(() => {
    if (chartRef.value) {
        chartRef.value.destroy();
    }
});
</script>

<template>
    <div class="relative">
        <canvas ref="dom"></canvas>
        <button v-if="zoomed"
                @click="resetZoom"
                class="absolute top-0 right-0 text-xs text-blue-600 hover:text-blue-500">
            Reset zoom
        </button>
    </div>
</template>
