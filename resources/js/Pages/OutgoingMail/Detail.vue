<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, Text, watch } from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Modal from "@/Components/Modal.vue";

import "@vueup/vue-quill/dist/vue-quill.snow.css";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { getParentDepartmentHirarki } from "@/services/hirarki";

import { Ckeditor } from "@ckeditor/ckeditor5-vue";
import {
    Alignment,
    Autoformat,
    AutoImage,
    AutoLink,
    Autosave,
    BalloonToolbar,
    Base64UploadAdapter,
    BlockQuote,
    Bold,
    Bookmark,
    ClassicEditor,
    Code,
    Essentials,
    FindAndReplace,
    FontBackgroundColor,
    FontColor,
    FontFamily,
    FontSize,
    GeneralHtmlSupport,
    Heading,
    Highlight,
    HorizontalLine,
    ImageBlock,
    ImageCaption,
    ImageInline,
    ImageInsert,
    ImageInsertViaUrl,
    ImageResize,
    ImageStyle,
    ImageTextAlternative,
    ImageToolbar,
    ImageUpload,
    Indent,
    IndentBlock,
    Italic,
    Link,
    LinkImage,
    List,
    ListProperties,
    Mention,
    PageBreak,
    Paragraph,
    PasteFromOffice,
    RemoveFormat,
    SpecialCharacters,
    SpecialCharactersArrows,
    SpecialCharactersCurrency,
    SpecialCharactersEssentials,
    SpecialCharactersLatin,
    SpecialCharactersMathematical,
    SpecialCharactersText,
    Strikethrough,
    Style,
    Subscript,
    Superscript,
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
    TextTransformation,
    TodoList,
    Underline,
} from "ckeditor5";
import "ckeditor5/ckeditor5.css";

const script = document.createElement("script");
script.src = "https://cdn.ckeditor.com/ckeditor5/36.0.1/full/ckeditor.js";

ClassicEditor.defaultConfig = {
    toolbar: {
        items: [
            "heading",
            "style",
            "|",
            "fontSize",
            "fontFamily",
            "fontColor",
            "fontBackgroundColor",
            "|",
            "bold",
            "italic",
            "underline",
            "|",
            "link",
            "insertImage",
            "insertTable",
            "highlight",
            "blockQuote",
            "|",
            "alignment",
            "|",
            "bulletedList",
            "numberedList",
            "todoList",
            "outdent",
            "indent",
        ],
        shouldNotGroupWhenFull: false,
    },
    plugins: [
        Alignment,
        Autoformat,
        AutoImage,
        AutoLink,
        Autosave,
        BalloonToolbar,
        Base64UploadAdapter,
        BlockQuote,
        Bold,
        Bookmark,
        Code,
        Essentials,
        FindAndReplace,
        FontBackgroundColor,
        FontColor,
        FontFamily,
        FontSize,
        GeneralHtmlSupport,
        Heading,
        Highlight,
        HorizontalLine,
        ImageBlock,
        ImageCaption,
        ImageInline,
        ImageInsert,
        ImageInsertViaUrl,
        ImageResize,
        ImageStyle,
        ImageTextAlternative,
        ImageToolbar,
        ImageUpload,
        Indent,
        IndentBlock,
        Italic,
        Link,
        LinkImage,
        List,
        ListProperties,
        Mention,
        PageBreak,
        Paragraph,
        PasteFromOffice,
        RemoveFormat,
        SpecialCharacters,
        SpecialCharactersArrows,
        SpecialCharactersCurrency,
        SpecialCharactersEssentials,
        SpecialCharactersLatin,
        SpecialCharactersMathematical,
        SpecialCharactersText,
        Strikethrough,
        Style,
        Subscript,
        Superscript,
        Table,
        TableCaption,
        TableCellProperties,
        TableColumnResize,
        TableProperties,
        TableToolbar,
        TextTransformation,
        TodoList,
        Underline,
    ],
    isReadOnly: true, // Set mode readonly default
    balloonToolbar: [
        "bold",
        "italic",
        "|",
        "link",
        "insertImage",
        "|",
        "bulletedList",
        "numberedList",
    ],
    fontFamily: {
        supportAllValues: true,
    },
    fontSize: {
        options: [10, 12, 14, 16, 18, 20, 22],
        supportAllValues: true,
    },
    licenseKey: "GPL",
};

ClassicEditor.create(document.querySelector("#editor"))
    .then((editor) => {
        // Pantau perubahan readonly
        editor.on("change:isReadOnly", (evt, propertyName, isReadOnly) => {
            const toolbarElement = editor.ui.view.toolbar.element;
            toolbarElement.style.display = isReadOnly ? "none" : "flex";
        });

        // Contoh toggle mode readonly
        document
            .querySelector("#toggle-readonly")
            .addEventListener("click", () => {
                editor.isReadOnly = !editor.isReadOnly;
            });
    })
    .catch((error) => {
        console.error(error);
    });
const isModalOpen = ref(false);
const props = defineProps({
    sub_types: Object,
    detail_department: Object,
    sign_mail_list: Object,
    priority: Object,
    classification: Object,
    orgSubjects: Object,
    outgoing_mail: Object,
});

const toRecipients = ref([]);
const ccRecipients = ref([]);
const form = useForm({
    subject: props.outgoing_mail.subject,
    sub_type_id: props.sub_types.id,
    form_type: props.sub_types.form_type,
    nomor: "Nomor Generate Otomatis !",
    mail_date: props.outgoing_mail.mail_date,
    detail_department_id: usePage().props.auth.detail_department.name,
    to: "",
    priority: props.outgoing_mail.priority.name,
    classification: props.outgoing_mail.classification.name,
    sign_user: props.outgoing_mail.sign_user,
    attachment: props.outgoing_mail.attachment,
    attachment_file: null,
    content: props.outgoing_mail.content,
    cc: "",
    org_subject: props.outgoing_mail.org_subject.name,
    recipients: "",
});

const openModal = () => {
    isModalOpen.value = true;
    form.reset();
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

const buildToMailList = ref([]);
const send_to_list = ref([]);
const onSelectMailList = (value) => {
    buildToMailList.value = getParentDepartmentHirarki(
        props.sign_mail_list,
        usePage().props.auth.detail_department.parent_id,
        value.parent_id
    );
};

watch(
    buildToMailList,
    (newList) => {
        form.to = "";
        send_to_list.value = newList.map((detail_department) => ({
            label:
                detail_department.name +
                " -- (" +
                detail_department.detail_department.title +
                " / " +
                detail_department.detail_department.bod.title +
                ")",
            id: detail_department.id,
        }));
    },
    { immediate: true }
);

if (props.outgoing_mail?.outgoing_recipients) {
    toRecipients.value = props.outgoing_mail.outgoing_recipients
        .filter((recipient) => recipient.recipient_type === "to")
        .map((recipient) => ({
            label:
                recipient.recipient.name +
                " (" +
                recipient.recipient.detail_department.title +
                ")",
            id: recipient.id,
        }));

    ccRecipients.value = props.outgoing_mail.outgoing_recipients
        .filter((recipient) => recipient.recipient_type === "cc")
        .map((recipient) => ({
            label:
                recipient.recipient.name +
                " (" +
                recipient.recipient.detail_department.title +
                ")",
            id: recipient.id,
        }));
}
console.log(props.outgoing_mail.outgoing_recipients);
</script>
<template>
    <div
        class="text-violet-400 hover:text-white hover:bg-violet-400 text-sm cursor-pointer border-2 border-violet-300 rounded-2 px-2"
        @click="openModal"
    >
        <font-awesome-icon :icon="['fas', 'eye']" /> Lihat
    </div>
    <Modal :show="isModalOpen" @close="closeModal" maxWidth="5xl">
        <div class="mb-8 mx-3">
            <h5 class="dark:text-slate-200">
                <font-awesome-icon :icon="['fas', 'paper-plane']" />
                Detail Surat :
                {{ props.outgoing_mail.subject }} [{{
                    props.sub_types.letter_format
                }}]
            </h5>
        </div>

        <div class="w-full flex justify-start mt-2">
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
                    readonly
                    autocomplete="tanggal"
                    placeholder="Tanggal Ditetapkan .."
                />

                <InputError class="mt-2" :message="form.errors.mail_date" />
            </div>
        </div>
        <div class="mt-2 w-full flex justify-between">
            <div class="w-1/2">
                <InputLabel for="Kepada" value="Kepada" :isRequired="true" />

                <ul class="mx-4">
                    <li v-for="recipient in toRecipients" :key="recipient.id">
                        {{ recipient.label }}
                    </li>
                </ul>
                <InputError class="mt-2" :message="form.errors.recipients" />
            </div>
            <div class="w-1/2">
                <InputLabel
                    for="Tembusan"
                    value="Tembusan"
                    :isRequired="true"
                />

                <ul class="mx-4">
                    <li v-for="recipient in ccRecipients" :key="recipient.id">
                        {{ recipient.label }}
                    </li>
                </ul>
                <InputError class="mt-2" :message="form.errors.recipients" />
            </div>
        </div>

        <div class="mt-2">
            <InputLabel for="Dari" value="Dari" :isRequired="true" />

            <TextInput
                v-model="form.sign_user"
                readonly
                label="label"
                track-by="label"
                placeholder="-- Pilih Dari --"
            ></TextInput>
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
                    readonly
                    autofocus
                    autocomplete="Lampiran"
                    placeholder="Lampiran .."
                />

                <InputError class="mt-2" :message="form.errors.attachment" />
            </div>
            <div class="w-1/2 mx-3">
                <InputLabel
                    for="Kode Subjek Organisasi"
                    value="Kode Subjek Organisasi"
                    :isRequired="true"
                />
                <TextInput
                    v-model="form.org_subject"
                    readonly
                    label="name"
                    track-by="name"
                    placeholder="-- Pilih Kode Subjek Organisasi --"
                ></TextInput>
                <InputError
                    class="mt-2"
                    :message="form.errors.org_subject_id"
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
                readonly
                placeholder="Perihal ..."
            />

            <InputError class="mt-2" :message="form.errors.subject" />
        </div>
        <div class="mt-2">
            <InputLabel for="isi" value="Isi Konten" :isRequired="true" />

            <!-- <div v-html="props.outgoing_mail.content" class="mx-auto"></div> -->

            <ckeditor
                :editor="ClassicEditor"
                readonly
                :config="{
                    toolbar: [],
                    isReadOnly: true,
                }"
                v-model="props.outgoing_mail.content"
            ></ckeditor>

            <InputError class="mt-2" :message="form.errors.content" />
        </div>
        <div class="w-full flex justify-between mt-2">
            <div class="w-1/2">
                <InputLabel
                    for="Klasifikasi"
                    value="Klasifikasi"
                    :isRequired="true"
                />

                <TextInput
                    v-model="form.classification"
                    readonly
                    label="name"
                    track-by="name"
                    placeholder="-- Pilih Klasifikasi --"
                ></TextInput>

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

                <TextInput
                    v-model="form.priority"
                    readonly
                    label="name"
                    track-by="name"
                    class="mx-3"
                    placeholder="-- Pilih Prioritas --"
                ></TextInput>

                <InputError class="mt-2" :message="form.errors.priority" />
            </div>
        </div>
        <div class="w-full flex justify-between mt-2"></div>

        <div class="mt-6 flex justify-start w-full">
            <div class="w-full">
                <SecondaryButton
                    class="py-4 flex justify-center px-6 w-full"
                    @click="closeModal"
                >
                    Tutup
                </SecondaryButton>
            </div>
        </div>
    </Modal>
</template>

<!-- <style src="vue-multiselect/dist/vue-multiselect.min.css"></style> -->
