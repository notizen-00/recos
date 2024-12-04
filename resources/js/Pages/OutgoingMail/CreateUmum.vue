<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Modal from "@/Components/Modal.vue";
import Multiselect from "vue-multiselect";
import FileInput from "@/Components/FileInput.vue";
import { QuillEditor } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const isModalOpen = ref(false);
const props = defineProps({
    sub_types: Object,
    detail_department: Object,
    priority: Object,
    classification: Object,
    orgSubjects: Object,
});

const form = useForm({
    subject: "",
    sub_type_id: props.sub_types.id,
    form_type: props.sub_types.form_type,
    nomor: "Nomor Generate Otomatis !",
    mail_date: "",
    detail_department_id: usePage().props.auth.detail_department.name,
    to: "",
    priority: "",
    classification: "",
    sign_user: "",
    attachment: "",
    attachment_file: null,
    content: "",
    cc: "",
    org_subject_id: "",
    recipients: "",
});

const openModal = () => {
    isModalOpen.value = true;
    form.reset();
};

const onPriorityChange = (selectedOption) => {
    console.log(selectedOption);
    this.form.priority_id = selectedOption ? selectedOption.id : null;
};

const createNewdetail_department = () => {
    form.post(route("outgoing-mail.store"), {
        headers: {
            "Content-Type": "multipart/form-data",
        },
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            closeModal();
            form.reset();
        },
        onError: () => {
            console.log(form);
        },

        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    form.reset;
    isModalOpen.value = false;
};
const customLabel = ({ name, id }) => {
    return name;
};
const detail_departments = props.detail_department?.map(
    (detail_department) => ({
        label:
            detail_department.name +
            " -- (" +
            detail_department.detail_department.title +
            ")",
        id: detail_department.id,
    })
);

const detail_departmentParents = props.detail_department
    ?.filter(
        (detail_department) =>
            detail_department.detail_department.parent_id == 0
    )
    .map((detail_department) => ({
        label:
            detail_department.name +
            " -- (" +
            detail_department.detail_department.title +
            ")",
        id: detail_department.id,
    }));

const priority = props.priority?.map((p) => ({
    name: p.name,
    id: p.id,
}));

const classification = props.classification?.map((classification) => ({
    name: classification.name,
    id: classification.id,
}));

const orgSubjects = props.orgSubjects?.map((org) => ({
    name: org.name,
    id: org.id,
}));
console.log(orgSubjects);
</script>
<template>
    <div
        class="cursor-pointer text-sm uppercase font-semibold dark:bg-slate-700 bg-slate-500 px-5 py-2 text-slate-50 rounded-lg"
        @click="openModal"
    >
        <i class="fa fa-plus mr-1"></i>
        Tambah Data
    </div>
    <Modal :show="isModalOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-8 mx-3">
            <h5 class="dark:text-slate-200">
                <font-awesome-icon :icon="['fas', 'paper-plane']" />
                Buat :
                {{ props.sub_types.name }} [{{ props.sub_types.letter_format }}]
            </h5>
        </div>
        <form @submit.prevent="createNewdetail_department" class="m-5">
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel for="nomor" value="Nomor" />

                    <TextInput
                        id="nomor"
                        readonly
                        disabled
                        type="text"
                        class="mt-1 cursor-not-allowed dark:bg-slate-500 bg-slate-800 block w-1/2 text-white"
                        autofocus
                        autocomplete="nomor"
                        v-model="form.nomor"
                    />
                </div>
                <div class="w-1/2">
                    <InputLabel
                        for="Tanggal"
                        value="Tanggal"
                        class="mx-3"
                        :isRequired="true"
                    />

                    <TextInput
                        id="Tanggal"
                        type="date"
                        class="mt-1 block w-full mx-3"
                        v-model="form.mail_date"
                        autofocus
                        autocomplete="tanggal"
                        placeholder="Tanggal Ditetapkan .."
                    />

                    <InputError class="mt-2" :message="form.errors.mail_date" />
                </div>
            </div>
            <div class="mt-2">
                <InputLabel for="Kepada" value="Kepada" :isRequired="true" />

                <multiselect
                    v-model="form.recipients"
                    :options="detail_departments"
                    :searchable="true"
                    :show-labels="true"
                    :allow-empty="false"
                    :multiple="true"
                    label="label"
                    track-by="label"
                    placeholder="-- Pilih User/detail_department --"
                ></multiselect>
                <InputError class="mt-2" :message="form.errors.recipients" />
            </div>
            <div class="mt-2">
                <InputLabel for="Dari" value="Dari" :isRequired="true" />

                <multiselect
                    v-model="form.sign_user"
                    :options="detail_departmentParents"
                    :searchable="true"
                    :show-labels="true"
                    :allow-empty="false"
                    label="label"
                    track-by="label"
                    placeholder="-- Pilih Dari --"
                ></multiselect>
                <InputError class="mt-2" :message="form.errors.sign_user" />
            </div>
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel
                        for="Lampiran"
                        value="Lampiran"
                        :isRequired="true"
                    />

                    <TextInput
                        id="Lampiran"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.attachment"
                        autofocus
                        autocomplete="Lampiran"
                        placeholder="Lampiran .."
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.attachment"
                    />
                </div>
                <div class="w-1/2">
                    <InputLabel
                        class="mx-3"
                        for="File Lampiran"
                        value="File Lampiran"
                        :isRequired="true"
                    />

                    <FileInput
                        id="File Lampiran"
                        class="mt-1 block w-full mx-3"
                        accept=".pdf"
                        v-model="form.attachment_file"
                    />

                    <InputError
                        class="mt-2"
                        :message="form.errors.attachment_file"
                    />
                </div>
            </div>
            <div class="mt-2">
                <InputLabel for="perihal" value="Perihal" :isRequired="true" />

                <TextInput
                    id="perihal"
                    type="text"
                    class="mt-1 block full"
                    v-model="form.subject"
                    autofocus
                    autocomplete="Perihal"
                    placeholder="Perihal ..."
                />

                <InputError class="mt-2" :message="form.errors.subject" />
            </div>
            <div class="mt-2">
                <InputLabel for="isi" value="Isi" :isRequired="true" />

                <QuillEditor
                    v-model:content="form.content"
                    @update:content="(content) => (form.content = content)"
                    contentType="html"
                    theme="snow"
                    style="min-height: 120px"
                />

                <InputError class="mt-2" :message="form.errors.content" />
            </div>
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel
                        for="Klasifikasi"
                        value="Klasifikasi"
                        :isRequired="true"
                    />

                    <multiselect
                        v-model="form.classification"
                        :options="classification"
                        :searchable="true"
                        :show-labels="true"
                        :allow-empty="false"
                        label="name"
                        track-by="name"
                        placeholder="-- Pilih Klasifikasi --"
                    ></multiselect>

                    <InputError
                        class="mt-2"
                        :message="form.errors.classification"
                    />
                </div>
                <div class="w-1/2">
                    <InputLabel
                        for="Derajat"
                        value="Derajat"
                        class="mx-3"
                        :isRequired="true"
                    />

                    <multiselect
                        v-model="form.priority"
                        :options="priority"
                        :searchable="true"
                        :show-labels="true"
                        :allow-empty="false"
                        :modelValue="id"
                        label="name"
                        track-by="name"
                        class="mx-3"
                        placeholder="-- Pilih Prioritas --"
                    ></multiselect>

                    <InputError class="mt-2" :message="form.errors.priority" />
                </div>
            </div>
            <div class="w-full flex justify-between mt-2">
                <div class="w-1/2">
                    <InputLabel
                        for="Kode Subjek Organisasi"
                        value="Kode Subjek Organisasi"
                        :isRequired="true"
                    />
                    <multiselect
                        v-model="form.org_subject_id"
                        :options="orgSubjects"
                        :searchable="true"
                        :show-labels="true"
                        :allow-empty="false"
                        label="name"
                        track-by="name"
                        placeholder="-- Pilih Kode Subjek Organisasi --"
                    ></multiselect>
                    <InputError
                        class="mt-2"
                        :message="form.errors.org_subject_id"
                    />
                </div>
                <div class="w-1/2">
                    <InputLabel
                        for="Dikirim Ke"
                        value="Dikirim Ke"
                        class="mx-3"
                        :isRequired="true"
                    />

                    <multiselect
                        v-model="form.to"
                        :options="detail_departments"
                        :searchable="true"
                        :show-labels="true"
                        :allow-empty="false"
                        label="label"
                        track-by="label"
                        class="mx-3"
                        placeholder="-- Pilih User/detail_department --"
                    ></multiselect>
                    <InputError class="mt-2" :message="form.errors.to" />
                </div>
            </div>
            <div class="mt-2">
                <InputLabel for="cc" :isRequired="false">
                    <template #default>Tembusan</template>
                </InputLabel>

                <multiselect
                    v-model="form.cc"
                    :options="detail_departments"
                    :searchable="true"
                    :show-labels="true"
                    :allow-empty="false"
                    :multiple="true"
                    label="label"
                    track-by="label"
                    placeholder="-- Pilih User/detail_department --"
                ></multiselect>
                <InputError class="mt-2" :message="form.errors.cc" />
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
