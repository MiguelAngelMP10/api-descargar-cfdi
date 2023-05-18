<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import JsonViewer from 'vue-json-viewer'
import axios from "axios";
import {ref} from "vue";
import {useForm} from "@inertiajs/vue3";
import {useToast} from "vue-toast-notification";

const form = useForm({
    cfdis: [],
})

let cfdisJson = ref('');
let toast = useToast();

let submit = () => {
    axios.post('api/v1/cfdi-to-json', form, {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }).then((response) => {
        toast.success('Cfdis converted to json')
        cfdisJson.value = response.data;
    }).catch((error) => {
        toast.error(error.response.data.errors.cfdis[0], {
            position: 'top'
        })
    });
};

</script>
<template>
    <AppLayout title=" Cfdi to json">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cfdi a json
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-full mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid md:grid-cols-2 sm:grid gap-4">
                        <div>
                            <form @submit.prevent="submit">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                                       for="multiple_files">
                                    Elegir
                                    archivos
                                </label>
                                <input @input="form.cfdis = $event.target.files"
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                       id="multiple_files" type="file" multiple accept="text/xml" name="cfdis">
                                <p class="my-1 text-sm text-gray-500 dark:text-gray-300">.xml</p>

                                <button
                                    type="submit"
                                    class="bg-transparent mt-3 hover:bg-purple-500 text-purple-700 font-semibold hover:text-white py-2 px-4 w-1/4 border border-purple-500 hover:border-transparent rounded"
                                ><i class="fa-solid fa-file-code"></i> Convertir
                                </button>
                            </form>
                        </div>

                        <div>
                            <json-viewer :value="cfdisJson"
                                         :expand-depth=2
                                         copyable
                                         boxed
                                         sort></json-viewer>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </AppLayout>
</template>
