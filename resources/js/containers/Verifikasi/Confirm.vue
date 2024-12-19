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
import EditUmum from "@/Pages/OutgoingMail/EditUmum.vue";
import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getParentDepartmentHirarki } from "@/services/hirarki";

const isModalEditOpen = ref(false);

const props = defineProps({
    outgoing_mail: Object,
    user_department: Object,
});

const to_sender = {
    id: props.outgoing_mail.user_id,
};

const form = useForm({
    outgoing_mail_id: props.outgoing_mail.id,
    is_confirm: true,
    to: to_sender,
    status: "",
});

const isHiding = ref(false);

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
    }
});

const status = [
    { name: "Setuju", value: 1 },
    { name: "Tolak", value: 0 },
];

const onSelectStatus = (value) => {
    //   console.log(value);
    if (value.value == 1) {
        isHiding.value = true;
    } else {
        isHiding.value = false;
    }
};
</script>

<template>
    <div
        class="text-green-400 hover:text-white hover:bg-green-400 text-sm cursor-pointer border-2 border-green-300 rounded-2 px-2"
        @click="openModal"
    >
        <font-awesome-icon :icon="['fas', 'user-check']" /> Konfirmasi
    </div>

    <Modal :show="isModalEditOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-5 mx-6">
            <h5 class="dark:text-slate-200">
                Konfirmasi Surat : {{ props.outgoing_mail.subject }}
            </h5>

            <div class="mb-5 mx-6">
                <hr class="bg-black h-1" />
                <p class="text-sm text-slate-700">
                    Dengan menyetujui surat ini maka Nomor Surat dan TTD akan di
                    generate secara otomatis !
                </p>

                <div class="w-full flex justify-start text-sm"></div>
                <div class="w-full flex justify-start text-sm">
                    <div class="w-1/6">Perihal</div>
                    <div class="w-3/4">
                        <b>{{ props.outgoing_mail.subject }}</b>
                    </div>
                </div>
            </div>
        </div>
        <form @submit.prevent="verifikasiSurat" class="m-5">
            <div class="w-full flex justify-between mt-2">
                <div class="w-full">
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
                        @select="onSelectStatus"
                        :allow-empty="false"
                        label="name"
                        id="Status"
                        track-by="name"
                        placeholder="-- Pilih Status --"
                    ></multiselect>

                    <InputError class="mt-2" :message="form.errors.status" />
                </div>
            </div>

            <div class="mt-6 flex justify-start">
                <div>
                    <PrimaryButton class="me-3 mb-4">Konfirmasi</PrimaryButton>
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
