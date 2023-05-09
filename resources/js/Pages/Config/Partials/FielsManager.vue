<script setup>
import {ref, watch} from 'vue';
import {useForm, usePage} from '@inertiajs/vue3';
import ActionMessage from '@/Components/ActionMessage.vue';
import ActionSection from '@/Components/ActionSection.vue';
import Checkbox from '@/Components/Checkbox.vue';
import ConfirmationModal from '@/Components/ConfirmationModal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import FormSection from '@/Components/FormSection.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import SectionBorder from '@/Components/SectionBorder.vue';
import TextInput from '@/Components/TextInput.vue';
import {useToast} from 'vue-toast-notification';

let toast = useToast();

const props = defineProps({
    fiels: Array
});

const addFielForm = useForm({
        key: '',
        cer: '',
        password: '',
    });

const deleteApiTokenForm = useForm({});
const apiTokenBeingDeleted = ref(null);

const addFielToUser = () => {
    addFielForm.post(route('config-fiel.store'), {
        preserveScroll: true,
        onSuccess: () => {
            addFielForm.reset();
            if (usePage().props.flash.success != null) {
                toast.success(usePage().props.flash.success);
            }

            if (usePage().props.flash.error != null) {
                toast.error(usePage().props.flash.error);
            }
        },
    });
};
const confirmApiTokenDeletion = (token) => {
    apiTokenBeingDeleted.value = token;
};

const deleteApiToken = () => {
    deleteApiTokenForm.delete(route('api-tokens.destroy', apiTokenBeingDeleted.value), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => (apiTokenBeingDeleted.value = null),
    });
};


</script>

<template>
    <div>

        <FormSection @submitted="addFielToUser">
            <template #title>
                Agregar Nueva FIEL
            </template>

            <template #description>
                La Firma Electrónica Avanzada "Fiel" es un conjunto de datos que se adjuntan a un mensaje electrónico,
                cuyo propósito es identificar al emisor del mensaje como autor legítimo de éste, tal y como si se
                tratara de una firma autógrafa.
            </template>

            <template #form>
                <div class="col-span-full sm:col-span-full">
                    <InputLabel for="key" value="Contenido Key"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                    <textarea id="key" rows="4" v-model="addFielForm.key"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Contenido Key"></textarea>
                    <InputError :message="addFielForm.errors.key" class="mt-2"/>
                </div>

                <div class="col-span-full sm:col-span-full">
                    <InputLabel for="key" value="Contenido Cer"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                    <textarea id="key" rows="4" v-model="addFielForm.cer"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                              placeholder="Contenido cer"></textarea>
                    <InputError :message="addFielForm.errors.cer" class="mt-2"/>
                </div>

                <div class="col-span-full sm:col-span-full">
                    <InputLabel for="password" value="Password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"/>
                    <TextInput type="password" v-model="addFielForm.password"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                    <InputError :message="addFielForm.errors.password" class="mt-2"/>
                </div>

            </template>

            <template #actions>
                <ActionMessage :on="addFielForm.recentlySuccessful" class="mr-3">
                    Created.
                </ActionMessage>

                <PrimaryButton :class="{ 'opacity-25': addFielForm.processing }"
                               :disabled="addFielForm.processing">
                    Create
                </PrimaryButton>
            </template>
        </FormSection>


        <div v-if="fiels.length > 0">
            <SectionBorder/>
            <div class="mt-10 sm:mt-0">
                <ActionSection>
                    <template #title>
                        Administrar Fiels
                    </template>
                    <template #description>
                        Puede eliminar cualquiera de sus fiels existentes si ya no los necesita.
                    </template>
                    <template #content>
                        <div class="space-y-6">
                            <div v-for="fiel in fiels" :key="fiel.id" class="flex items-center justify-between">
                                <div class="break-all">
                                    {{ fiel.rfc }}
                                </div>
                                <div class="break-all">
                                    {{ fiel.legalName }}
                                </div>

                                <div class="flex items-center ml-2">
                                    <div v-if="fiel.created_at" class="text-sm text-gray-400">
                                        Created at {{ fiel.created_at }}
                                    </div>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500"
                                            @click="confirmApiTokenDeletion('aaa')">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </ActionSection>
            </div>
        </div>

        <ConfirmationModal :show="apiTokenBeingDeleted != null" @close="apiTokenBeingDeleted = null">
            <template #title>
                Delete API Token
            </template>

            <template #content>
                Are you sure you would like to delete this API token?
            </template>

            <template #footer>
                <SecondaryButton @click="apiTokenBeingDeleted = null">
                    Cancel
                </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': deleteApiTokenForm.processing }"
                    :disabled="deleteApiTokenForm.processing"
                    @click="deleteApiToken"
                >
                    Delete
                </DangerButton>
            </template>
        </ConfirmationModal>

    </div>
</template>
