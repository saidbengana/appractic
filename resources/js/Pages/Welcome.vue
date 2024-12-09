<template>
  <Head title="Welcome" />
  
  <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
        <h1 class="text-4xl font-bold text-gray-900">Appractic</h1>
      </div>

      <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2">
          <div class="p-6">
            <div class="flex items-center">
              <div class="ml-4 text-lg leading-7 font-semibold">
                Welcome to Appractic
              </div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-600 text-sm">
                Your modern solution for content management and analytics.
              </div>
            </div>
          </div>

          <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
            <div class="flex items-center">
              <div class="ml-4 text-lg leading-7 font-semibold">
                <Link
                  :href="route('login')"
                  class="text-indigo-600 hover:text-indigo-900"
                >
                  Get Started
                </Link>
              </div>
            </div>

            <div class="ml-12">
              <div class="mt-2 text-gray-600 text-sm">
                Sign in to access your dashboard and start managing your content.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'
</script>

<style>
.bg-gray-100 {
  background-color: #f7fafc;
}
</style>
