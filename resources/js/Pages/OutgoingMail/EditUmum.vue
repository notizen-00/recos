<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Modal from "@/Components/Modal.vue";
import Multiselect from "vue-multiselect";
import FileInput from "@/Components/FileInput.vue";
import { QuillEditor, Quill } from "@vueup/vue-quill";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { getParentDepartmentHirarki } from "@/services/hirarki";
import ImageUploader from "quill-image-uploader";
import QuillBetterTable from "quill-better-table";
import "quill-better-table/dist/quill-better-table.css";
const isModalOpen = ref(false);
const props = defineProps({
    sub_types: Object,
    detail_department: Object,
    outgoing_mail: Object,

    orgSubjects: Object,
});

const module = {
    name: "imageUploader",
    module: ImageUploader,
    options: {
        upload: (file) => {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append("image", file);

                axios
                    .post("/outgoing_mail/upload_foto", formData)
                    .then((res) => {
                        console.log(res);
                        resolve(res.data.url);
                    })
                    .catch((err) => {
                        reject("Upload failed");
                        console.error("Error:", err);
                    });
            });
        },
    },
};
const form = useForm({
    subject: "",
    nomor: "Nomor Generate Otomatis !",
    mail_date: "",
    detail_department_id: usePage().props.auth.detail_department.name,
    to: "",
    priority: "",
    classification: "",
    sign_user: "",
    attachment: props.outgoing_mail.attachment,
    attachment_file: null,
    content: props.outgoing_mail.content,
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

const buildParentHirarki = getParentDepartmentHirarki(
    props.detail_department,
    usePage().props.auth.detail_department.parent_id,
    null
);

const detail_departmentParents = buildParentHirarki.map(
    (detail_department) => ({
        label:
            detail_department.name +
            " -- (" +
            detail_department.detail_department.title +
            ")",
        id: detail_department.id,
    })
);
</script>
<template>
    <div class="mb-8 mx-3">
        <h5 class="dark:text-slate-200">
            <font-awesome-icon :icon="['fas', 'edit']" />
            Update & Verifikasi Data :
            {{ props.outgoing_mail.subject }}
        </h5>
    </div>
    <form @submit.prevent="createNewdetail_department" class="m-5">
        <!-- <div class="mt-2">
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
        </div> -->

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

                <InputError class="mt-2" :message="form.errors.attachment" />
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
            <InputLabel for="isi" value="Isi Konten" :isRequired="true" />

            <QuillEditor
                v-model:content="form.content"
                @update:content="(content) => (form.content = content)"
                contentType="html"
                theme="snow"
                toolbar="full"
                :modules="module"
                style="min-height: 120px"
            />

            <InputError class="mt-2" :message="form.errors.content" />
        </div>
        <div class="w-full flex justify-between mt-2">
            <div class="w-1/2">
                <!-- <InputLabel
                    for="Klasifikasi"
                    value="Klasifikasi"
                    :isRequired="true"
                /> -->

                <!-- <multiselect
                    v-model="form.classification"
                    :options="classification"
                    :searchable="true"
                    :show-labels="true"
                    :allow-empty="false"
                    label="name"
                    track-by="name"
                    placeholder="-- Pilih Klasifikasi --"
                ></multiselect> -->

                <InputError
                    class="mt-2"
                    :message="form.errors.classification"
                />
            </div>
            <div class="w-1/2">
                <!-- <InputLabel
                    for="Derajat"
                    value="Derajat"
                    class="mx-3"
                    :isRequired="true"
                /> -->

                <!-- <multiselect
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
                ></multiselect> -->

                <InputError class="mt-2" :message="form.errors.priority" />
            </div>
        </div>
        <div class="w-full flex justify-between mt-2">
            <div class="w-1/2">
                <!-- <InputLabel
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
                /> -->
            </div>
            <!-- <div class="w-1/2">
                <InputLabel
                    for="Dikirim Ke"
                    value="Dikirim Ke"
                    class="mx-3"
                    :isRequired="true"
                />

                <multiselect
                    v-model="form.to"
                    :options="send_to_list"
                    :searchable="true"
                    :show-labels="true"
                    :allow-empty="false"
                    :disabled="!form.sign_user"
                    :class="{ 'cursor-not-allowed': !form.sign_user }"
                    label="label"
                    track-by="label"
                    class="mx-3"
                    placeholder="-- Pilih User/detail_department --"
                ></multiselect>
                <InputError class="mt-2" :message="form.errors.to" />
            </div> -->
        </div>

        <div class="mt-6 flex justify-start">
            <div>
                <PrimaryButton class="me-3 mb-4">Update</PrimaryButton>
            </div>
            <div>
                <SecondaryButton class="py-4 px-6" @click="closeModal">
                    Cancel
                </SecondaryButton>
            </div>
        </div>
    </form>
</template>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
