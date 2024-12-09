<script setup>
const props = defineProps({
    active: {
        type: Boolean,
        default: false
    }
})
</script>
<template>
    <div class="relative cursor-pointer" :class="{'ring-2 ring-indigo-500': active}">
        <slot/>
    </div>
</template>
