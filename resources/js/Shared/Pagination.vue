<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div class=" pr-2">
                <p class="text-sm text-gray-700">
                    Showing
                    <!-- space -->
                    <span class="font-medium">{{ from }}</span>
                    <!-- space -->
                    to
                    <!-- space -->
                    <span class="font-medium">{{ to }}</span>
                    <!-- space -->
                    of
                    <!-- space -->
                    <span class="font-medium">{{ total }}</span>
                    <!-- space -->
                    results
                </p>
            </div>
            <div v-if="links.length > 3">
                <div class="flex flex-wrap my-8">
                    <template v-for="(link, key) in links" key="key">
                        <div
                            v-if="link.url === null"
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                            v-html="link.label"
                        />

                        <Link
                            v-else
                            class="mr-1 mb-1 px-4 py-3 text-sm leading-4 border rounded hover:bg-indigo-400 focus:border-primary focus:text-white"
                            :class="{ 'bg-indigo-800 text-white': link.active }"
                            :href="link.url"
                            v-html="link.label"
                            preserve-scroll
                        />
                    </template>
                </div>
            </div>

        </div>
    </div>


</template>

<script setup>
import {Link} from '@inertiajs/vue3';

defineProps({
    links: Array,
    total: Number,
    from: Number,
    to: Number
});

</script>
