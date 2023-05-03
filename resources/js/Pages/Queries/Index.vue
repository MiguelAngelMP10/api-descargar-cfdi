<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Shared/Pagination.vue';
import {ref, watch} from "vue";
import {router, Link, usePage} from '@inertiajs/vue3'
import moment from "moment";


let props = defineProps({
    queries: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: "",
    },
});

let search = ref(props.search);

watch(search, (value) => {
    router.get(`/queries?search=${value}`, {}, {replace: true, preserveState: true,});
});

</script>

<template>
    <AppLayout title="Queries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Queries
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center mb-6">
                        <label for="voice-search" class="sr-only">Search</label>
                        <div class="relative w-full">
                            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                     viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                          d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                          clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="search" id="voice-search" v-model="search"
                                   class="w-0 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-1/4 pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Search..." required>
                        </div>
                        <Link :href="route('queries.create')"
                              class="bg-transparent hover:bg-purple-500 text-purple-700 font-semibold hover:text-white py-2 px-4 w-1/4 border border-purple-500 hover:border-transparent rounded">
                            <i class="fa-solid fa-plus"></i> Create new query
                        </Link>
                    </div>
                </div>

                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead
                            class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-gray-900 dark:text-gray-400 border">
                        <tr>
                            <th scope="col" class="py-3 px-0.5 text-center border" rowspan="2">
                                Num.
                            </th>
                            <th scope="col" class="py-3 px-0.5 text-center border" rowspan="2">
                                RFC
                            </th>
                            <th scope="col" class="py-3 text-center border" rowspan="2">
                                End Point
                            </th>
                            <th scope="col" class="py-3 text-center border" rowspan="2">
                                Download Type
                            </th>
                            <th scope="col" class="py-3 text-center border" rowspan="2">
                                Request Type
                            </th>
                            <th scope="col" class="py-3 text-center border" colspan="2">
                                Period
                            </th>
                            <th scope="col" class="py-3 text-center border" rowspan="2">
                                Request Id
                            </th>
                            <th scope="col" class="py-3 text-center border" rowspan="2">
                                numeroCFDIs
                            </th>

                            <th scope="col" class="py-3 text-center border" rowspan="2" colspan="3">
                                Acciones
                            </th>
                        </tr>
                        <tr>
                            <th scope="col" class="py-3 text-center border">
                                Start
                            </th>
                            <th scope="col" class="py-3 text-center border">
                                End
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-if="queries.data.length===0" class="border dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="11" class="text-3xl text-center text-black font-semibold"><i
                                class="fa-solid fa-triangle-exclamation"></i> No se encuentran registros con el
                                cliterio de busqueda: {{ props.search }}
                            </td>
                        </tr>


                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 text-sm"
                            v-for="(query, index) in queries.data">

                            <th scope="row"
                                class="text-gray-900 whitespace-nowrap dark:text-white text-center">
                                {{ queries.from + index }}
                            </th>

                            <td class="py-4 px-6">
                                {{ query.rfc }}
                            </td>
                            <td class="py-4 px-6">
                                {{ query.endPoint }}
                            </td>
                            <td class="py-4 px-6">
                                {{ query.downloadType }}
                            </td>
                            <td class="py-4 px-6">
                                {{ query.requestType }}
                            </td>

                            <td class="py-4 px-6">
                                {{ moment(query.dateTimePeriodStart).format('DD/MM/YYYY h:mm:ss A') }}
                            </td>
                            <td class="py-4 px-6">
                                {{ moment(query.dateTimePeriodEnd).format('DD/MM/YYYY h:mm:ss A') }}
                            </td>
                            <td class="py-4 px-6">
                                {{ query.requestId }}
                            </td>
                            <td class="py-4 px-6">
                                {{ query.numeroCFDIs }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <Link :href="route('queries.show',  query)"
                                      class="font-semibold text-blue-600 dark:text-blue-500 hover:underline"> Detalles
                                </Link>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href=""
                                   class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">Verificar</a>
                            </td>

                            <td class="py-4 px-6 text-right">
                                <a href=""
                                   class="font-semibold text-blue-600 dark:text-blue-500 hover:underline">Paquetes</a>
                            </td>

                        </tr>

                        <tr>
                        </tr>


                        </tbody>
                    </table>


                    <div class="bg-white border-gray-200 flex justify-center">
                        <Pagination :links="queries.links" :total="queries.total" :from="queries.from"
                                    :to="queries.to"/>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>
