<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import Multiselect from "vue-multiselect";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watchEffect } from "vue";

const isModalEditOpen = ref(false);

const props = defineProps({
    outgoing_mail: Object,
    unit: Object,
});

const form = useForm({
    outgoing_mail_id: props.outgoing_mail.id,
    note: "",
    status: "",
    to: "",
});

const openModal = () => {
    isModalEditOpen.value = true;
    form.errors = {};
};

const verifikasiSurat = () => {
    form.post(route("outgoing-mail.verifikasi"), {
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
    isModalEditOpen.value = false;
};

watchEffect(() => {
    if (isModalEditOpen.value) {
        form.errors = {};
        form.name = props.type?.name;
    }
});

const units = props.unit?.map((unit) => ({
    label: unit.name + " -- (" + unit.unit.name + ")",
    id: unit.id,
}));

const status = [
    { name: "Acc", value: 1 },
    { name: "Revisi", value: 0 },
];
</script>

<template>
    <div
        class="text-red-400 hover:text-white hover:bg-red-400 text-sm cursor-pointer border-2 border-red-300 rounded-2 px-2"
        @click="openModal"
    >
        <font-awesome-icon :icon="['fas', 'edit']" /> Verifikasi
    </div>

    <Modal :show="isModalEditOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-5 mx-6">
            <h5 class="dark:text-slate-200">
                Verifikasi Surat : {{ props.outgoing_mail.full_number }}
            </h5>
        </div>
        <form @submit.prevent="verifikasiSurat" class="m-5">
            <div>
                <InputLabel for="catatan" value="Catatan " :isRequired="true" />

                <textarea
                    id="catatan"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.note"
                    autofocus
                    autocomplete="catatan"
                />

                <InputError class="mt-2" :message="form.errors.note" />
            </div>

            <div class="w-full flex justify-between mt-2">
                <div class="w-4/12">
                    <InputLabel
                        for="Status"
                        value="Status"
                        :isRequired="true"
                    />

                    <multiselect
                        v-model="form.status"
                        :options="status"
                        :searchable="true"
                        :show-labels="true"
                        :allow-empty="false"
                        label="name"
                        id="Status"
                        track-by="name"
                        placeholder="-- Pilih Status --"
                    ></multiselect>

                    <InputError class="mt-2" :message="form.errors.status" />
                </div>
            </div>

            <div class="mt-4">
                <InputLabel for="to" :isRequired="false">
                    <template #default>Dikirim / Dikembalikan Ke </template>
                </InputLabel>

                <multiselect
                    v-model="form.to"
                    :options="units"
                    :searchable="true"
                    :show-labels="true"
                    :allow-empty="false"
                    label="label"
                    track-by="label"
                    placeholder="-- Pilih User/Unit --"
                ></multiselect>
                <InputError class="mt-2" :message="form.errors.to" />
            </div>

            <div class="mt-6 flex justify-start">
                <div>
                    <PrimaryButton class="me-3 mb-4">Verifikasi</PrimaryButton>
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
