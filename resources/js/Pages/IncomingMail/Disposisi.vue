<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import {
    getChildrenDepartmentHirarki,
    getHierarchyTwoSteps,
} from "@/services/hirarki.js";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import YellowButton from "@/Components/YellowButton.vue";
import Modal from "@/Components/Modal.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Multiselect from "vue-multiselect";
import TextArea from "@/Components/TextArea.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import CheckboxArray from "@/Components/CheckboxArray.vue";

const isModalOpen = ref(false);

const props = defineProps({
    outgoing_mail: Object,
    followUpTypes: Object,
    userDepartment: Object,
});

const form = useForm({
    outgoing_mail_id: props.outgoing_mail.id,
    recipients: [],
    follow_up_type: "",
    follow_up_message: "",
});

const openModal = () => {
    isModalOpen.value = true;
    form.reset();
};

const createNewDisposition = () => {
    form.post(route("external-mail-forwarding.store"), {
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            closeModal();
        },
        onError: () => {
            console.log(form);
        },
    });
};

const closeModal = () => {
    form.reset();
    isModalOpen.value = false;
};

const buildRecipientList = getHierarchyTwoSteps(
    props.userDepartment,
    usePage().props.auth.user.id
);

console.log(buildRecipientList);

const recipientList = buildRecipientList.map((el) => ({
    label: el.title + el.parent_id,
    id: el.id + "; -- (" + el.title + " / " + el.bod.title + ")",
}));

const followUpTypes = props.followUpTypes.map((el) => ({
    name: el.name,
    id: el.id,
}));
</script>

<template>
    <div
        class="text-yellow-400 hover:text-white hover:bg-yellow-400 text-sm cursor-pointer border-2 border-yellow-300 rounded-2 px-2"
        @click="openModal"
    >
        <font-awesome-icon :icon="['fas', 'magnifying-glass']" /> Disposisi
    </div>
    <Modal :show="isModalOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-8 mx-3">
            <h5 class="dark:text-slate-200">
                <font-awesome-icon :icon="['fas', 'envelopes-bulk']" />
                Buat Disposisi: Surat Masuk Eksternal
            </h5>
        </div>
        <form @submit.prevent="createNewDisposition" class="m-5">
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel for="agenda_number" value="Nomor Agenda" />
                    <TextInput
                        readonly
                        disabled
                        id="agenda_number"
                        type="text"
                        autofocus
                        autocomplete="agenda_number"
                        class="mt-1 cursor-not-allowed block w-1/2"
                        v-model="props.outgoing_mail.agenda_number"
                    />
                </div>
                <div class="w-1/2 pl-3">
                    <InputLabel for="agenda_date" value="Tanggal Agenda" />
                    <TextInput
                        readonly
                        disabled
                        id="agenda_date"
                        type="text"
                        autofocus
                        autocomplete="agenda_date"
                        class="mt-1 cursor-not-allowed block w-1/2"
                        v-model="props.outgoing_mail.agenda_date"
                    />
                </div>
            </div>
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel for="letter_number" value="Nomor Surat" />
                    <TextInput
                        readonly
                        disabled
                        id="letter_number"
                        type="text"
                        autofocus
                        autocomplete="letter_number"
                        class="mt-1 cursor-not-allowed block w-1/2"
                        v-model="props.outgoing_mail.full_number"
                    />
                </div>
                <div class="w-1/2 pl-3">
                    <InputLabel for="letter_date" value="Tanggal Surat" />
                    <TextInput
                        readonly
                        disabled
                        id="letter_date"
                        type="text"
                        autofocus
                        autocomplete="letter_date"
                        class="mt-1 cursor-not-allowed block w-1/2"
                        v-model="props.outgoing_mail.mail_date"
                    />
                </div>
            </div>
            <div class="mt-2">
                <InputLabel for="perihal" value="Perihal" />

                <TextInput
                    readonly
                    disabled
                    id="perihal"
                    type="text"
                    class="mt-1 cursor-not-allowed block w-1/2"
                    v-model="props.outgoing_mail.subject"
                    autofocus
                    autocomplete="Perihal"
                    placeholder="Perihal ..."
                />
            </div>
            <h5 class="mt-3">Lembar Penerus</h5>
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <div
                        v-for="recipient in recipientList"
                        :key="recipient.id"
                        class="mt-2"
                    >
                        <div class="flex items-center space-x-4">
                            <CheckboxArray
                                :id="recipient.id"
                                v-model="form.recipients"
                                :value="recipient.id"
                                class="w-6 h-6"
                            />

                            <div class="flex-1 text-sm text-gray-700">
                                {{ recipient.label }}
                            </div>
                        </div>
                    </div>
                    <InputError
                        class="mt-2"
                        :message="form.errors.recipients"
                    />
                </div>
                <div class="w-1/2 pl-3">
                    <InputLabel for="Dari" value="Dari" :isRequired="true" />

                    <multiselect
                        v-model="form.follow_up_type"
                        :options="followUpTypes"
                        :searchable="true"
                        :show-labels="true"
                        :allow-empty="false"
                        label="name"
                        track-by="name"
                        placeholder="-- Pilih Dari --"
                    ></multiselect>

                    <InputError
                        class="mt-2"
                        :message="form.errors.follow_up_type"
                    />

                    <InputLabel
                        for="Disposisi"
                        value="Disposisi"
                        class="mt-2"
                        :isRequired="true"
                    />

                    <TextArea v-model="form.follow_up_message" />
                </div>
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
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
