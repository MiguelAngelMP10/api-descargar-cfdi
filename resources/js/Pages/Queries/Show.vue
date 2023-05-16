<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {router, Link, usePage} from '@inertiajs/vue3'
import moment from "moment";
import {ref} from "vue";
import {useToast} from "vue-toast-notification";

let props = defineProps({
    query: {
        type: Object,
        required: true,
    },
});
let query = ref(props.query);

let dateTimePeriodEndFormat = moment(query.dateTimePeriodEnd).format('DD/MM/YYYY h:mm:ss A');
let dateTimePeriodStartFormat = moment(query.dateTimePeriodStart).format('DD/MM/YYYY h:mm:ss A');
let toast = useToast();
let downloadPackages = (query_id) => {
    router.get(route('download.packages', query_id), {}, {
        preserveScroll: true,
        replace: true,
        preserveState: true,
        onSuccess: () => {
            if (usePage().props.flash.success !== null) {
                toast.success(usePage().props.flash.success)
            }

            if (usePage().props.flash.error !== null) {
                toast.error(usePage().props.flash.error)
            }
        }
    });
};

let checkDownloadPackages = (packages) => {
    let newArray = packages.filter(pac => pac.path === '')
    return newArray.length > 0;
};


</script>

<template>
    <AppLayout title="Queries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Queries
            </h2>
        </template>
        <div class="py-12">
            <div class="max mx-auto sm:px-6 lg:px-6">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="space-y-6 mx-6">
                        <div class="border-b border-gray-900/10 pb-12">
                            <div class="mt-10 grid grid-cols-1 gap-x-3 gap-y-0.5 sm:grid-cols-6">

                                <div class="sm:col-span-1">
                                    <label for="first-name"
                                           class="block text-sm font-medium leading-6 text-gray-900">Id</label>
                                    <div class="mt-2">
                                        <input type="text" :value=query.id
                                               class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               disabled>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <label for="first-name"
                                           class="block text-sm font-medium leading-6 text-gray-900">RFC
                                    </label>
                                    <div class="mt-2">
                                        <input type="text" :value=query.rfc
                                               class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               disabled>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <label for="last-name"
                                           class="block text-sm font-medium leading-6 text-gray-900">End Point</label>
                                    <div class="mt-2">
                                        <input type="text" :value=query.endPoint
                                               class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               disabled>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <label for="last-name"
                                           class="block text-sm font-medium leading-6 text-gray-900">Download
                                        Type</label>
                                    <div class="mt-2">
                                        <input type="text" :value=query.downloadType
                                               class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               disabled>
                                    </div>
                                </div>
                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Request
                                        Type</label>
                                    <input type="text" :value=query.requestType
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                                        Time Period Start</label>
                                    <input type="text" :value=dateTimePeriodStartFormat
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date
                                        Time Period End</label>
                                    <input type="text" :value=dateTimePeriodEndFormat
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-2">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Request
                                        Id</label>
                                    <input type="text" :value=query.requestId
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Numero
                                        CFDIs</label>
                                    <input type="text" :value=query.numeroCFDIs
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Document
                                        Type</label>
                                    <input type="text" :value=query.documentType
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Document Status</label>
                                    <input type="text" :value=query.documentStatus
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Complemento Cfdi</label>
                                    <input type="text" :value=query.complementoCfdi
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>


                                <div class="sm:col-span-2">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Uuid</label>
                                    <input type="text" :value=query.uuid
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>


                                <div class="sm:col-span-1">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Status Code</label>
                                    <input type="text" :value=query.statusCode
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>


                                <div class="sm:col-span-2">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Status Message</label>
                                    <input type="text" :value=query.statusMessage
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Cuenta de terceros</label>
                                    <input type="text" :value=query.rfcOnBehalf
                                           class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                           disabled>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="message"
                                           class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Rfc Matches</label>
                                    <div v-for="item in JSON.parse(query.rfcMatches)">
                                        <input type="text" :value="item"
                                               class="mb-6 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               disabled>
                                    </div>
                                </div>

                            </div>
                            <div class="my-10">
                                <div class="flex justify-center gap-x-16 mb-3">
                                    <div><p class="text-lg font-bold text-center">Packages</p></div>
                                    <div>
                                        <button v-if="query.packeges.length>0 && checkDownloadPackages(query.packeges)"
                                                class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800"
                                                @click="downloadPackages(query.id)"
                                        >
                                          <span
                                              class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                              Download packages
                                          </span>
                                        </button>
                                    </div>
                                </div>


                                <div class="relative overflow-x-auto mt5" v-if="query.packeges.length>0">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr class="text-center">
                                            <th scope="col" class="px-6 py-3">
                                                Package Id
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Path
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Status Code
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                statusMessage
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                package Size
                                            </th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center"
                                            v-for="response in  query.packeges">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ response.packageId }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ response.path }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.statusCode }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.statusMessage }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.packageSize }}
                                            </td>

                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="my-10">
                                <p class="text-lg font-bold text-center">History Response</p>
                                <div class="relative overflow-x-auto mt5" v-if="query.resposes_query.length>0">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr class="text-center">
                                            <th scope="col" class="px-6 py-3">
                                                Status Code
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Status Message
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Status Request Message
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Status Request Name
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Code Request Value
                                            </th>
                                            <th scope="col" class="px-6 py-3">
                                                Code Request Message
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-center"
                                            v-for="response in  query.resposes_query">
                                            <th scope="row"
                                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                {{ response.statusCode }}
                                            </th>
                                            <td class="px-6 py-4">
                                                {{ response.statusMessage }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.statusRequestName }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.statusRequestMessage }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.codeRequestName }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ response.codeRequestMessage }}
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </div>


                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <Link :href="route('queries.index')"
                                      class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                      <span
                                          class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                         <i class="fa-solid fa-list-ol"></i> List of queries
                                      </span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
