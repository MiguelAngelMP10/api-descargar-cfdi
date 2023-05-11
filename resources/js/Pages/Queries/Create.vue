<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router, usePage, useForm} from '@inertiajs/vue3'
import {useToast} from 'vue-toast-notification';
import {reactive} from "vue";

const props = defineProps(
    {
        errors: Object,
        endpoint: Object,
        downloadType: Object,
        requestType: Object,
        documentType: Object,
        complementoCfdi: Object,
        documentStatus: Object,
        fiels: Object,
    }
)
const form = reactive({
    rfc: String,
    endPoint: ['cfdi'],
    period_start: '',
    period_end: '',
    downloadType: ['issued'],
    requestType: ['metadata'],
    documentType: '',
    complementoCfdi: '',
    documentStatus: 'undefined',
    uuid: '',
    rfcMatches: [],
    rfcOnBehalf: ''
});
let toast = useToast();
let submit = () => {
        router.post("/queries", form, {
                preserveScroll: true,
                replace: true, preserveState: true,
                onSuccess: () => {
                    if (usePage().props.flash.success !== null) {
                        toast.success(usePage().props.flash.success)
                    }

                    if (usePage().props.flash.error !== null) {
                        toast.error(usePage().props.flash.error)
                    }
                }
            }
        )
    }
;

let addRfcMatches = () => {
    if (form.rfcMatches.length < 5) {
        form.rfcMatches.push('');
    }
};

let deleteRfcMatches = () => {
    if ((form.rfcMatches.length > 0 && form.rfcMatches.length < 5) || form.rfcMatches.length < 5) {
        form.rfcMatches.pop();
    }
};

</script>


<template>
    <AppLayout title="New query">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                New query
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="space-y-12 mx-6">
                        <div class="border-b border-gray-900/10 pb-12">
                            <form @submit.prevent="submit">


                                <div class="max-w-full mx-auto sm:px-6 lg:px-8 m-11">

                                    <div class="mb-4">
                                        <label for="rfc"
                                               class="block my-4 font-semibold text-gray-900 dark:text-white">RFC</label>
                                        <select id="rfc"
                                                v-model="form.rfc"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                :class="(errors.rfc)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''">
                                            <option v-for="(item, key) in fiels" :value="item.rfc">
                                                {{ item.rfc }} -
                                                {{ item.legalName }}
                                            </option>
                                        </select>
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{
                                                errors.rfc
                                            }}</p>
                                    </div>


                                    <div class="mb-4">
                                        <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                                            Tipos de Comprobantes Fiscales Digitales
                                        </h3>
                                        <label class="inline-flex relative items-center mb-4 mr-4 cursor-pointer"
                                               v-for="(value, key) in endpoint">
                                            <input type="checkbox" :value=key v-model="form.endPoint"
                                                   name="endPoint[]"
                                                   class="sr-only peer"
                                                   :class="(errors.endPoint)?' bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400 ':''"
                                            >
                                            <div
                                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                            <span
                                                class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                :class="(errors.endPoint)?'text-red-700 dark:text-red-500':''">
                                                    {{ value }}</span>
                                        </label>

                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            {{ errors.endPoint }}
                                        </p>

                                    </div>
                                    <h1 class="mb-4 font-semibold text-gray-900 dark:text-white">Periodo</h1>
                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="period[start]"
                                                   class="block text-gray-700 text-sm font-bold mb-2"
                                                   :class="(errors.period_start)?'text-red-700 dark:text-red-500':''"
                                            >Inicio</label>
                                            <input type="date" id="period[start]" v-model="form.period_start"
                                                   class="block w-full"
                                                   :class="(errors.period_start)?'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400 ':''">

                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ errors.period_start }}</p>


                                        </div>

                                        <div>
                                            <label for="period[end]"
                                                   class="block text-gray-700 text-sm font-bold mb-2"
                                                   :class="(errors.period_end)?'text-red-700 dark:text-red-500':''"
                                            >Fin</label>
                                            <input type="date" name="period[end]" v-model="form.period_end"
                                                   class="block w-full"
                                                   :class="(errors.period_end)?'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400 ':''">

                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ errors.period_end }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">
                                                Tipo de
                                                descarga
                                            </h3>
                                            <label class="inline-flex relative items-center mb-4 mr-4 cursor-pointer"
                                                   v-for="(value, key) in downloadType">
                                                <input type="checkbox" :value=key v-model="form.downloadType"
                                                       name="downloadType[]"
                                                       class="sr-only peer"
                                                       :class="(errors.downloadType)?' bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400 ':''"
                                                >
                                                <div
                                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                <span
                                                    class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"
                                                    :class="(errors.downloadType)?'text-red-700 dark:text-red-500':''">
                                                    {{ value }}</span>
                                            </label>


                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{ errors.downloadType }}
                                            </p>

                                        </div>

                                        <div>
                                            <h3 class="mb-4 font-semibold text-gray-900 dark:text-white">Tipo de
                                                solicitud</h3>
                                            <label class="inline-flex relative items-center mb-4 mr-4 cursor-pointer"
                                                   v-for="(value, key) in requestType">
                                                <input type="checkbox" :value=key v-model="form.requestType"
                                                       name="requestType[]"
                                                       class="sr-only peer"
                                                       :class="(errors.requestType)?' bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400 ':''"
                                                >
                                                <div
                                                    class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                                                <span
                                                    class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300 "
                                                    :class="(errors.requestType)?'text-red-700 dark:text-red-500':''"> {{
                                                        value
                                                    }}</span>
                                            </label>


                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                                    errors.requestType
                                                }}</p>

                                        </div>

                                    </div>

                                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                                        <div>
                                            <label for="documentType"
                                                   class="block mb-2 text-sm text-gray-700 dark:text-white font-semibold"
                                                   :class="(errors.documentType)? 'text-red-700 dark:text-red-500':''">Tipo
                                                de comprobante</label>
                                            <select id="documentType"
                                                    v-model="form.documentType"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    :class="(errors.documentType)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''">
                                                <option v-for="(item, key) in documentType" :value="key">{{
                                                        item
                                                    }}
                                                </option>

                                            </select>
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                                    errors.documentType
                                                }}</p>
                                        </div>
                                        <div>
                                            <label for="complementoCfdi"
                                                   class="block mb-2 text-sm text-gray-700 dark:text-white font-semibold"
                                                   :class="(errors.complementoCfdi)? 'text-red-700 dark:text-red-500':''">
                                                Tipo de complemento
                                            </label>
                                            <select id="complementoCfdi"
                                                    v-model="form.complementoCfdi"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    :class="(errors.complementoCfdi)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''">
                                                <option v-for="(item, key) in complementoCfdi" :value="key">{{
                                                        item
                                                    }}
                                                </option>

                                            </select>
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                                    errors.complementoCfdi
                                                }}</p>
                                        </div>

                                        <div>
                                            <label for="documentStatus"
                                                   class="block mb-2 text-sm text-gray-700 dark:text-white font-semibold"
                                                   :class="(errors.documentStatus)? 'text-red-700 dark:text-red-500':''">
                                                Estado del comprobante
                                            </label>
                                            <select id="documentStatus"
                                                    v-model="form.documentStatus"
                                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                    :class="(errors.documentStatus)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''">
                                                <option v-for="(item, key) in documentStatus" :value="key">{{
                                                        item
                                                    }}
                                                </option>
                                            </select>
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                                    errors.documentStatus
                                                }}</p>
                                        </div>


                                        <div>
                                            <label for="uuid"
                                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                                   :class="(errors.uuid)? 'text-red-700 dark:text-red-500':''"
                                            >Uuid</label>
                                            <input type="text" id="uuid"
                                                   v-model="form.uuid"
                                                   aria-describedby="helper-text-explanation"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   :class="(errors.uuid)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''"
                                            >
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                                    errors.uuid
                                                }}</p>
                                        </div>
                                    </div>


                                    <div>
                                        <label for="RFC_contraparte"
                                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                               :class="(errors.rfcOnBehalf)? 'text-red-700 dark:text-red-500':''"
                                        >RFC cuenta de terceros</label>
                                        <input type="text" id="RFC_contraparte"
                                               v-model="form.rfcOnBehalf"
                                               aria-describedby="helper-text-explanation"
                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                               :class="(errors.rfcOnBehalf)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''"
                                        >
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                                errors.rfcOnBehalf
                                            }}</p>
                                    </div>

                                    <h3
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                        :class="(errors.rfcMatches)? 'text-red-700 dark:text-red-500':''"
                                    >RFC contraparte</h3>
                                    <button type="button" @click="addRfcMatches"
                                            v-if="form.rfcMatches.length < 5"
                                            class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                                        <i class="fa-solid fa-plus"></i> Agregar RFC
                                    </button>
                                    <button type="button" @click="deleteRfcMatches"
                                            v-if="(form.rfcMatches.length > 0 && form.rfcMatches.length < 5) ||form.rfcMatches.length < 5"
                                            class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-500 dark:focus:ring-red-800">
                                        <i class="fa-solid fa-minus"></i> Eliminar RFC
                                    </button>
                                    <div class="grid gap-6 mb-6 md:grid-cols-5">
                                        <div v-for="(item, key) in form.rfcMatches">
                                            <input type="text"
                                                   v-model="form.rfcMatches[key]"
                                                   aria-describedby="helper-text-explanation"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                   :class="(errors.rfcMatches)? 'bg-red-50 border border-red-500 text-red-700 dark:text-red-500 dark:bg-red-100 dark:border-red-400':''"
                                            >
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{
                                            errors.rfcMatches
                                        }}</p>


                                </div>


                                <div class="mt-6 flex items-center justify-end gap-x-6">
                                    <button type="submit"
                                            class="text-green-700 hover:text-white border border-green-700 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-600 dark:focus:ring-green-800">
                                        <i class="fa-regular fa-floppy-disk"></i> Create queries

                                    </button>
                                    <Link :href="route('queries.index')"
                                          class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-purple-600 to-blue-500 group-hover:from-purple-600 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                      <span
                                          class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                         <i class="fa-solid fa-list-ol"></i> List of queries
                                      </span>
                                    </Link>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>


