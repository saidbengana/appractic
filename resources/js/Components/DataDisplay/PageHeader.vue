<template>
    <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <slot name="header"/>
                <slot name="actions"/>
            </div>
            <slot name="description"/>
        </div>
    </div>
</template>
