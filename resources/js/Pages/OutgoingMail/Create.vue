<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watchEffect, watch } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

const isModalOpen = ref(false);

const props = defineProps({
    sub_types: Object,
    unit: Object,
});

const form = useForm({
    subject: "",
    nomor: "Nomor Generate Otomatis !",
    mail_place: "",
    mail_date: "",
    unit_id: usePage().props.auth.unit.name,
    to: "",
    sign_user: "UPATIK",
});

const openModal = () => {
    isModalOpen.value = true;
    form.reset();
};

console.log(props.unit);

const createNewUnit = () => {
    form.post(route("outgoing-mail.store"), {
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

const unitParents = props.unit?.map((unit) => ({
    label: unit.name + " -- (" + unit.unit.name + ")",
    value: unit.id,
}));
</script>

<template>
    <div
        class="cursor-pointer text-sm uppercase font-semibold bg-slate-700 px-5 py-2 text-slate-50 rounded-lg"
        @click="openModal"
    >
        <i class="fa fa-plus mr-1"></i>
        Tambah Data
    </div>

    <Modal :show="isModalOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-8 mx-3">
            <h5 class="dark:text-slate-200">
                <font-awesome-icon :icon="['fas', 'paper-plane']" /> Buat :
                {{ props.sub_types.name }} [{{ props.sub_types.letter_format }}]
            </h5>
        </div>
        <form @submit.prevent="createNewUnit" class="m-5">
            <div>
                <InputLabel for="nomor" value="Nomor" />

                <TextInput
                    id="nomor"
                    readonly
                    disabled
                    type="text"
                    class="mt-1 cursor-not-allowed bg-slate-500/80 block w-1/2 text-white"
                    autofocus
                    autocomplete="nomor"
                    v-model="form.nomor"
                />
            </div>

            <div>
                <InputLabel for="tentang" value="Tentang" :isRequired="true" />

                <TextInput
                    id="tentang"
                    type="text"
                    class="mt-1 block full"
                    v-model="form.subject"
                    autofocus
                    autocomplete="tentang"
                    placeholder="Subject ..."
                />

                <InputError class="mt-2" :message="form.errors.subject" />
            </div>

            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel
                        for="Ditetapkan Di"
                        value="Ditetapkan Di"
                        :isRequired="true"
                    />

                    <TextInput
                        id="Ditetapkan di"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.mail_place"
                        autofocus
                        autocomplete="Ditetapkan Di"
                        placeholder="Ex : Jember"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.mail_place"
                    />
                </div>

                <div class="w-1/2">
                    <InputLabel
                        for="Tgl Ditetapkan"
                        value="Tgl Ditetapkan"
                        class="mx-3"
                        :isRequired="true"
                    />

                    <TextInput
                        id="Tgl Ditetapkan"
                        type="date"
                        class="mt-1 block w-full mx-3"
                        v-model="form.mail_date"
                        autofocus
                        autocomplete="tgl_ditetapkan"
                        placeholder="Tanggal Ditetapkan .."
                    />

                    <InputError class="mt-2" :message="form.errors.mail_date" />
                </div>
            </div>

            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel
                        for="Dibuat Oleh"
                        value="Dibuat Oleh"
                        :isRequired="true"
                    />

                    <TextInput
                        id="Dibuat Oleh"
                        type="text"
                        readonly
                        class="mt-1 block w-full bg-slate-500/80 text-white cursor-not-allowed"
                        v-model="form.unit_id"
                        autofocus
                        autocomplete="Dibuat Oleh"
                    />

                    <InputError class="mt-2" :message="form.errors.unit_id" />
                </div>

                <div class="w-1/2">
                    <InputLabel
                        for="TTD Oleh"
                        value="TTD Oleh"
                        class="mx-3"
                        :isRequired="true"
                    />

                    <TextInput
                        id="TTD Oleh"
                        type="text"
                        class="mt-1 block w-full mx-3"
                        v-model="form.sign_user"
                        autofocus
                        autocomplete="tgl_ditetapkan"
                        placeholder="UPATIK"
                    />

                    <InputError class="mt-2" :message="form.errors.sign_user" />
                </div>
            </div>

            <div class="mt-4">
                <InputLabel for="to" :isRequired="false">
                    <template #default>Di Kirim Ke </template>
                </InputLabel>

                <SelectInput
                    id="to"
                    class="mt-1 block w-full"
                    v-model="form.to"
                    required
                    :dataSet="unitParents"
                >
                </SelectInput>
                <InputError class="mt-2" :message="form.errors.to" />
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
