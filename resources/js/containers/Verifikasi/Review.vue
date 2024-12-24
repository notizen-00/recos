<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import Multiselect from "vue-multiselect";
import TextInput from "@/Components/TextInput.vue";
import FileInput from "@/Components/FileInput.vue";
import EditUmum from "@/Pages/OutgoingMail/EditUmum.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getParentDepartmentHirarki } from "@/services/hirarki";
import { Ckeditor } from "@ckeditor/ckeditor5-vue";
// import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
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
    heading: {
        options: [
            {
                model: "paragraph",
                title: "Paragraph",
                class: "ck-heading_paragraph",
            },
            {
                model: "heading1",
                view: "h1",
                title: "Heading 1",
                class: "ck-heading_heading1",
            },
            {
                model: "heading2",
                view: "h2",
                title: "Heading 2",
                class: "ck-heading_heading2",
            },
            {
                model: "heading3",
                view: "h3",
                title: "Heading 3",
                class: "ck-heading_heading3",
            },
            {
                model: "heading4",
                view: "h4",
                title: "Heading 4",
                class: "ck-heading_heading4",
            },
            {
                model: "heading5",
                view: "h5",
                title: "Heading 5",
                class: "ck-heading_heading5",
            },
            {
                model: "heading6",
                view: "h6",
                title: "Heading 6",
                class: "ck-heading_heading6",
            },
        ],
    },
    htmlSupport: {
        allow: [
            {
                name: /^.*$/,
                styles: true,
                attributes: true,
                classes: true,
            },
        ],
    },
    image: {
        toolbar: [
            "toggleImageCaption",
            "imageTextAlternative",
            "|",
            "imageStyle:inline",
            "imageStyle:wrapText",
            "imageStyle:breakText",
            "|",
            "resizeImage",
        ],
    },
    link: {
        addTargetToExternalLinks: true,
        defaultProtocol: "https://",
        decorators: {
            toggleDownloadable: {
                mode: "manual",
                label: "Downloadable",
                attributes: {
                    download: "file",
                },
            },
        },
    },
    list: {
        properties: {
            styles: true,
            startIndex: true,
            reversed: true,
        },
    },
    menuBar: {
        isVisible: true,
    },
    style: {
        definitions: [
            {
                name: "Article category",
                element: "h3",
                classes: ["category"],
            },
            {
                name: "Title",
                element: "h2",
                classes: ["document-title"],
            },
            {
                name: "Subtitle",
                element: "h3",
                classes: ["document-subtitle"],
            },
            {
                name: "Info box",
                element: "p",
                classes: ["info-box"],
            },
            {
                name: "Side quote",
                element: "blockquote",
                classes: ["side-quote"],
            },
            {
                name: "Marker",
                element: "span",
                classes: ["marker"],
            },
            {
                name: "Spoiler",
                element: "span",
                classes: ["spoiler"],
            },
            {
                name: "Code (dark)",
                element: "pre",
                classes: ["fancy-code", "fancy-code-dark"],
            },
            {
                name: "Code (bright)",
                element: "pre",
                classes: ["fancy-code", "fancy-code-bright"],
            },
        ],
    },
    table: {
        contentToolbar: [
            "tableColumn",
            "tableRow",
            "mergeTableCells",
            "tableProperties",
            "tableCellProperties",
        ],
    },
    allowedContent: true, // Jangan filter atribut atau elemen
    licenseKey: "GPL",
};

const isModalEditOpen = ref(false);

const props = defineProps({
    outgoing_mail: Object,
    user_department: Object,
    detail_department: Object,
});

const form = useForm({
    outgoing_mail_id: props.outgoing_mail.id,
    note: "",
    status: "",
    to: "",
    attachment: props.outgoing_mail.attachment,
    content: props.outgoing_mail.content,
    attachment_file: null,
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
        form.name = props.type?.name;
    }
});

const buildDepartmentHirarki = getParentDepartmentHirarki(
    props.user_department,
    usePage().props.auth.detail_department.parent_id,
    null
);

const user_departments = buildDepartmentHirarki.map((ud) => ({
    label:
        ud.name +
        " -- (" +
        ud.detail_department.title +
        " / " +
        ud.detail_department.bod.title +
        ")",
    id: ud.id,
}));

const status = [
    { name: "Teruskan", value: 1 },
    { name: "Revisi", value: 0 },
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
        class="text-red-400 hover:text-white hover:bg-red-400 text-sm cursor-pointer border-2 border-red-300 rounded-2 px-2"
        @click="openModal"
    >
        <font-awesome-icon :icon="['fas', 'edit']" /> Verifikasi
    </div>

    <Modal :show="isModalEditOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-5 mx-6">
            <h5 class="dark:text-slate-200">
                <font-awesome-icon :icon="['fas', 'edit']" /> Verifikasi &
                Update : #{{ props.outgoing_mail.subject }}
            </h5>
        </div>
        <!-- <EditUmum
            v-if="props.outgoing_mail"
            :detail_department="props.detail_department"
            :outgoing_mail="props.outgoing_mail"
        /> -->

        <form @submit.prevent="verifikasiSurat" class="m-5">
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
                <InputLabel for="isi" value="Isi Konten" :isRequired="true" />

                <ckeditor
                    :editor="ClassicEditor"
                    v-model="form.content"
                ></ckeditor>

                <InputError class="mt-2" :message="form.errors.content" />
            </div>
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

            <div v-if="isHiding" class="mt-4">
                <InputLabel for="to" :isRequired="false">
                    <template #default>Diteruskan Ke </template>
                </InputLabel>

                <multiselect
                    v-model="form.to"
                    :options="user_departments"
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
