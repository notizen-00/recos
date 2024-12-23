<script setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import Modal from "@/Components/Modal.vue";
import Multiselect from "vue-multiselect";
import FileInput from "@/Components/FileInput.vue";
import "@vueup/vue-quill/dist/vue-quill.snow.css";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {getParentDepartmentHirarki} from "@/services/hirarki";
import {Ckeditor} from "@ckeditor/ckeditor5-vue";
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
  Underline
} from 'ckeditor5';
import 'ckeditor5/ckeditor5.css';


const script = document.createElement("script");
script.src = "https://cdn.ckeditor.com/ckeditor5/36.0.1/full/ckeditor.js";

ClassicEditor.defaultConfig = {
  toolbar: {
    items: [
      'heading',
      'style',
      '|',
      'fontSize',
      'fontFamily',
      'fontColor',
      'fontBackgroundColor',
      '|',
      'bold',
      'italic',
      'underline',
      '|',
      'link',
      'insertImage',
      'insertTable',
      'highlight',
      'blockQuote',
      '|',
      'alignment',
      '|',
      'bulletedList',
      'numberedList',
      'todoList',
      'outdent',
      'indent'
    ],
    shouldNotGroupWhenFull: false
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
    Underline
  ],
  balloonToolbar: ['bold', 'italic', '|', 'link', 'insertImage', '|', 'bulletedList', 'numberedList'],
  fontFamily: {
    supportAllValues: true
  },
  fontSize: {
    options: [10, 12, 14, 16, 18, 20, 22],
    supportAllValues: true,
  },
  heading: {
    options: [
      {
        model: 'paragraph',
        title: 'Paragraph',
        class: 'ck-heading_paragraph',
      },
      {
        model: 'heading1',
        view: 'h1',
        title: 'Heading 1',
        class: 'ck-heading_heading1'
      },
      {
        model: 'heading2',
        view: 'h2',
        title: 'Heading 2',
        class: 'ck-heading_heading2'
      },
      {
        model: 'heading3',
        view: 'h3',
        title: 'Heading 3',
        class: 'ck-heading_heading3'
      },
      {
        model: 'heading4',
        view: 'h4',
        title: 'Heading 4',
        class: 'ck-heading_heading4'
      },
      {
        model: 'heading5',
        view: 'h5',
        title: 'Heading 5',
        class: 'ck-heading_heading5'
      },
      {
        model: 'heading6',
        view: 'h6',
        title: 'Heading 6',
        class: 'ck-heading_heading6'
      }
    ]
  },
  htmlSupport: {
    allow: [
      {
        name: /^.*$/,
        styles: true,
        attributes: true,
        classes: true
      }
    ]
  },
  image: {
    toolbar: [
      'toggleImageCaption',
      'imageTextAlternative',
      '|',
      'imageStyle:inline',
      'imageStyle:wrapText',
      'imageStyle:breakText',
      '|',
      'resizeImage'
    ]
  },
  link: {
    addTargetToExternalLinks: true,
    defaultProtocol: 'https://',
    decorators: {
      toggleDownloadable: {
        mode: 'manual',
        label: 'Downloadable',
        attributes: {
          download: 'file'
        }
      }
    }
  },
  list: {
    properties: {
      styles: true,
      startIndex: true,
      reversed: true
    }
  },
  menuBar: {
    isVisible: true
  },
  style: {
    definitions: [
      {
        name: 'Article category',
        element: 'h3',
        classes: ['category']
      },
      {
        name: 'Title',
        element: 'h2',
        classes: ['document-title']
      },
      {
        name: 'Subtitle',
        element: 'h3',
        classes: ['document-subtitle']
      },
      {
        name: 'Info box',
        element: 'p',
        classes: ['info-box']
      },
      {
        name: 'Side quote',
        element: 'blockquote',
        classes: ['side-quote']
      },
      {
        name: 'Marker',
        element: 'span',
        classes: ['marker']
      },
      {
        name: 'Spoiler',
        element: 'span',
        classes: ['spoiler']
      },
      {
        name: 'Code (dark)',
        element: 'pre',
        classes: ['fancy-code', 'fancy-code-dark']
      },
      {
        name: 'Code (bright)',
        element: 'pre',
        classes: ['fancy-code', 'fancy-code-bright']
      }
    ]
  },
  table: {
    contentToolbar: ['tableColumn', 'tableRow', 'mergeTableCells', 'tableProperties', 'tableCellProperties']
  },
  allowedContent: true, // Jangan filter atribut atau elemen
  licenseKey: 'GPL'
}

const isModalOpen = ref(false);
const props = defineProps({
  sub_types: Object,
  detail_department: Object,
  sign_mail_list: Object,
  priority: Object,
  classification: Object,
  orgSubjects: Object,
});

const form = useForm({
  subject: "",
  sub_type_id: props.sub_types.id,
  form_type: props.sub_types.form_type,
  nomor: "Nomor Generate Otomatis !",
  mail_date: new Date().toISOString().split("T")[0],
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
const customLabel = ({name, id}) => {
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

  console.log(buildToMailList.value);
};

const buildSignMailList = getParentDepartmentHirarki(
    props.sign_mail_list,
    usePage().props.auth.detail_department.parent_id,
    null
);

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
    {immediate: true}
);

const sign_mail_list = buildSignMailList.map((detail_department) => ({
  label:
      detail_department.name +
      " -- (" +
      detail_department.detail_department.title +
      " / " +
      detail_department.detail_department.bod.title +
      ")",
  id: detail_department.id,
  parent_id: detail_department.detail_department.parent_id,
}));

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
</script>
<template>
  <div
      class="cursor-pointer text-sm uppercase font-semibold dark:bg-slate-700 bg-slate-500 px-5 py-2 text-slate-50 rounded-lg"
      @click="openModal">
    <i class="fa fa-plus mr-1"></i>
    Tambah Data
  </div>
  <Modal :show="isModalOpen" @close="closeModal" maxWidth="4xl">
    <div class="mb-8 mx-3">
      <h5 class="dark:text-slate-200">
        <font-awesome-icon :icon="['fas', 'paper-plane']"/>
        Buat :
        {{ props.sub_types.name }} [{{ props.sub_types.letter_format }}]
      </h5>
    </div>
    <form @submit.prevent="createNewdetail_department" class="m-5">
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel for="nomor" value="Nomor"/>

          <TextInput
              id="nomor"
              readonly
              disabled
              type="text"
              class="mt-1 cursor-not-allowed dark:bg-slate-500 bg-slate-800 block w-1/2 text-red-500"
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
              readonly
              class="mt-1 block w-full mx-3"
              v-model="form.mail_date"
              autofocus
              autocomplete="tanggal"
              placeholder="Tanggal Ditetapkan .."
          />

          <InputError class="mt-2" :message="form.errors.mail_date"/>
        </div>
      </div>
      <div class="mt-2">
        <InputLabel for="Kepada" value="Kepada" :isRequired="true"/>

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
        <InputError class="mt-2" :message="form.errors.recipients"/>
      </div>
      <div class="mt-2">
        <InputLabel for="Dari" value="Dari" :isRequired="true"/>

        <multiselect
            v-model="form.sign_user"
            :options="sign_mail_list"
            :searchable="true"
            @select="onSelectMailList"
            :show-labels="true"
            :allow-empty="false"
            label="label"
            track-by="label"
            placeholder="-- Pilih Dari --"
        ></multiselect>
        <InputError class="mt-2" :message="form.errors.sign_user"/>
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
        <InputLabel for="perihal" value="Perihal" :isRequired="true"/>

        <TextInput
            id="perihal"
            type="text"
            class="mt-1 block full"
            v-model="form.subject"
            autofocus
            autocomplete="Perihal"
            placeholder="Perihal ..."
        />

        <InputError class="mt-2" :message="form.errors.subject"/>
      </div>
      <div class="mt-2">
        <InputLabel for="isi" value="Isi" :isRequired="true"/>

        <!--        <QuillEditor-->
        <!--            v-model:content="form.content"-->
        <!--            @update:content="(content) => (form.content = content)"-->
        <!--            contentType="html"-->
        <!--            theme="snow"-->
        <!--            style="min-height: 120px"-->
        <!--            toolbar="full"-->
        <!--        />-->
        <!--        <ckeditor :editor="ClassicEditor" v-model:content="form.content"></ckeditor>-->
        <ckeditor :editor="ClassicEditor" v-model="form.content"></ckeditor>
        <InputError class="mt-2" :message="form.errors.content"/>
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

          <InputError class="mt-2" :message="form.errors.priority"/>
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
          <InputError class="mt-2" :message="form.errors.to"/>
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
        <InputError class="mt-2" :message="form.errors.cc"/>
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

<style>
figure.table {
  display: flex;
  justify-content: center; /* Atur perataan tabel di tengah */
  max-width: 100%;
  overflow-x: auto; /* Tampilkan scrollbar horizontal jika terlalu lebar */
}

figure.table table {
  width: 100%; /* Sesuaikan dengan lebar figure */
  max-width: inherit; /* Batasi agar tetap dalam figure */
  border-collapse: collapse;
}

figure.table table td,
figure.table table th {
  padding: 8px; /* Padding untuk konten */
}
</style>