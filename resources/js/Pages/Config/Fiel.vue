<script setup>
import FielsManager from '@/Pages/Config/Partials/FielsManager.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    fiels: Array,
});
</script>

<template>
    <AppLayout title="Administrar Fiels">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Administrar Fiels
            </h2>
        </template>
        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <FielsManager
                    :fiels="fiels"
                />
            </div>
        </div>
    </AppLayout>
</template>
