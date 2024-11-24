<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watchEffect, watch } from "vue";

const isModalOpen = ref(false);

const props = defineProps({
    type: Object,
});

const form = useForm({
    name: "",
    letter_format: "",
    type_id: props.type?.id,
});

const openModal = () => {
    isModalOpen.value = true;
    form.reset();
};

const createNewUnit = () => {
    form.post(route("sub-type.store"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },

        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.reset;
    isModalOpen.value = false;
};
</script>

<template>
    <div
        class="cursor-pointer text-sm uppercase font-semibold bg-slate-700 px-5 py-2 text-slate-50 rounded-lg"
        @click="openModal"
    >
        <i class="fa fa-plus mr-1"></i>
        Tambah Data
    </div>

    <Modal :show="isModalOpen" @close="closeModal">
        <div class="mb-8 mx-6">
            <h5 class="dark:text-slate-200">
                Tambah SubType : {{ props.type?.name }}
            </h5>
        </div>
        <form @submit.prevent="createNewUnit" class="m-5">
            <div>
                <InputLabel for="name" value="Name" :isRequired="true" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    autofocus
                    autocomplete="name"
                    placeholder="Nama Sub Tipe Surat"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-2">
                <InputLabel
                    for="format_surat"
                    value="Format Nomor Surat"
                    :isRequired="true"
                />

                <TextInput
                    id="format_surat"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.letter_format"
                    autofocus
                    autocomplete="letter_format"
                    placeholder="Format Nomor Surat"
                />

                <InputError class="mt-2" :message="form.errors.letter_format" />
            </div>

            <div class="mt-6 flex justify-start">
                <div>
                    <PrimaryButton class="me-3 mb-4">Simpan</PrimaryButton>
                </div>
                <div>
                    <SecondaryButton class="py-4 px-6" @click="closeModal">
                        Cancel
                    </SecondaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
