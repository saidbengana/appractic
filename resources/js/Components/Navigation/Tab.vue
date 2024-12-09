<script setup>
import {Link} from "@inertiajs/vue3";

defineProps({
    href: {
        type: String,
        required: true
    },
    active: {
        type: Boolean,
        default: false
    }
});
</script>

<template>
    <Link :href="href"
          :class="{
              'border-primary-500 text-primary-500': active,
              'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': !active
          }"
          class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
        <slot/>
    </Link>
</template>
