<script setup>
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import Multiselect from "vue-multiselect";
import FileInput from "@/Components/FileInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import PurpleButton from "@/Components/PurpleButton.vue";

const isModalOpen = ref(false);

const props = defineProps({
  priority: Object,
  classification: Object,
  externalTypes: Object,
  userDepartment: Object,
});

const form = useForm({
  agenda_number: "Nomor Generate Otomatis !",
  agenda_date: new Date(),
  letter_number: "",
  letter_date: "",
  external_type: "",
  classification: "",
  priority: "",
  description: "",
  from_user: "",
  from_ext: "",
  forwarded_to: "",
  forwarded_date: "",
  file_pdf: null,
  subject: ""
});

const formatDate = (date) => {
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();

  return `${year}-${month}-${day}`;
}
const openModal = () => {
  isModalOpen.value = true;
  form.reset();
};
const onPriorityChange = (selectedOption) => {
  console.log(selectedOption);
  this.form.priority_id = selectedOption ? selectedOption.id : null;
};
const createNewExternal = () => {
  form.post(route("external-mail.store"), {
    headers: {
      "Content-Type": "multipart/form-data",
    },
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      closeModal();
      // form.reset();
    },
    onError: () => {
      console.log(form);
    },

    // onFinish: () => form.reset(),
  });
};
const buildFromList = props.userDepartment;
const fromList = buildFromList.map((el) => ({
  label:
      el.name +
      " -- (" +
      el.detail_department.title +
      " / " +
      el.detail_department.bod.title +
      ")",
  id: el.id,
}));
fromList.push({
  id: "EXT",
  label: "Eksternal"
});

const buildForwardedList = props.userDepartment;
const forwardedList = buildForwardedList.map((el) => ({
  label:
      el.name +
      " -- (" +
      el.detail_department.title +
      " / " +
      el.detail_department.bod.title +
      ")",
  id: el.id,
}));
// const fromList = ref([]);
//
// watch(buildFromList, (newList) => {
//   form.from_user = "";
//   fromList.value = newList.map((el) => ({
//     label:
//         el.name +
//         " -- (" +
//         el.detail_department.title +
//         " / " +
//         el.detail_department.bod.title +
//         ")",
//     id: el.id,
//   }));
// }, {immediate: true});
//
// console.log(fromList);
const closeModal = () => {
  form.reset();
  isModalOpen.value = false;
};

// const buildSignMailList = getParentDepartmentHirarki(
//     props.sign_mail_list,
//     usePage().props.auth.detail_department.parent_id,
//     null
// );
//
// watch(
//     buildToMailList,
//     (newList) => {
//       form.to = "";
//       send_to_list.value = newList.map((detail_department) => ({
//         label:
//             detail_department.name +
//             " -- (" +
//             detail_department.detail_department.title +
//             " / " +
//             detail_department.detail_department.bod.title +
//             ")",
//         id: detail_department.id,
//       }));
//     },
//     { immediate: true }
// );
//
// const sign_mail_list = buildSignMailList.map((detail_department) => ({
//   label:
//       detail_department.name +
//       " -- (" +
//       detail_department.detail_department.title +
//       " / " +
//       detail_department.detail_department.bod.title +
//       ")",
//   id: detail_department.id,
//   parent_id: detail_department.detail_department.parent_id,
// }));

const priority = props.priority?.map((p) => ({
  name: p.name,
  id: p.id,
}));

const classification = props.classification?.map((classification) => ({
  name: classification.name,
  id: classification.id,
}));

const externalTypes = props.externalTypes?.map((external) => ({
  name: external.name,
  id: external.id,
}));
console.log(externalTypes)
</script>

<template>
  <PurpleButton
      @click="openModal">
    <font-awesome-icon :icon="['fas', 'plus']"/>
    Tambah Data
  </PurpleButton>
  <Modal :show="isModalOpen" @close="closeModal" maxWidth="4xl">
    <div class="mb-8 mx-3">
      <h5 class="dark:text-slate-200">
        <font-awesome-icon :icon="['fas', 'paper-plane']"/>
        Buat : Surat Masuk Eksternal
      </h5>
    </div>
    <form @submit.prevent="createNewExternal" class="m-5">
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel for="agenda_number" value="Nomor Agenda" :isRequired="true"/>

          <TextInput
              readonly
              id="agenda_number"
              type="text"
              autofocus
              autocomplete="agenda_number"
              class="mt-1 cursor-not-allowed block w-1/2 text-red-500"
              v-model="form.agenda_number"
          />
          <InputError class="mt-2" :message="form.errors.agenda_number"/>
        </div>
        <div class="w-1/2 pl-3">
          <InputLabel for="agenda_date" value="Tanggal Agenda" :isRequired="true"/>

          <VueDatePicker readonly id="agenda_date" v-model="form.agenda_date" locale="id" :enable-time-picker="false"
                         autofocus
                         autocomplete="agenda_date" :format="formatDate" auto-apply>
          </VueDatePicker>
          <InputError class="mt-2" :message="form.errors.agenda_date"/>
        </div>
      </div>
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel for="letter_number" value="Nomor Surat" :isRequired="true"/>
          <TextInput
              id="letter_number"
              type="text"
              autofocus
              autocomplete="letter_number"
              v-model="form.letter_number"
          />
          <InputError class="mt-2" :message="form.errors.letter_number"/>
        </div>
        <div class="w-1/2 pl-3">
          <InputLabel for="letter_date" value="Tanggal Surat" :isRequired="true"/>

          <VueDatePicker id="letter_date" v-model="form.letter_date" locale="id" :enable-time-picker="false" autofocus
                         autocomplete="letter_date" :format="formatDate" auto-apply>
          </VueDatePicker>

          <InputError class="mt-2" :message="form.errors.letter_date"/>
        </div>
      </div>
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/3">
          <InputLabel
              for="external_type"
              value="Bentuk Surat"
              :isRequired="true"
          />

          <multiselect
              v-model="form.external_type"
              :options="externalTypes"
              :searchable="true"
              :show-labels="true"
              :allow-empty="false"
              label="name"
              track-by="name"
              placeholder="-- Pilih Bentuk Surat --"
          ></multiselect>

          <InputError class="mt-2" :message="form.errors.external_type"/>
        </div>
        <div class="w-1/3 pl-3">
          <InputLabel
              for="classification"
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

          <InputError class="mt-2" :message="form.errors.classification"/>
        </div>
        <div class="w-1/3 pl-3">
          <InputLabel
              for="priority"
              value="Derajat"
              :isRequired="true"
          />
          <multiselect
              v-model="form.priority"
              :options="priority"
              :searchable="true"
              :show-labels="true"
              :allow-empty="false"
              label="name"
              track-by="name"
              placeholder="-- Pilih Derajat --"
          ></multiselect>

          <InputError class="mt-2" :message="form.errors.priority"/>
        </div>
      </div>
      <div class="mt-2">
        <InputLabel
            for="perihal"
            value="Perihal"
            :isRequired="true"
        />

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
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel
              for="Dari"
              value="Dari"
              :isRequired="true"
          />

          <multiselect
              v-model="form.from_user"
              :options="fromList"
              :searchable="true"
              :show-labels="true"
              :allow-empty="false"
              label="label"
              track-by="label"
              placeholder="-- Pilih Dari --"
          ></multiselect>

          <InputError
              class="mt-2"
              :message="form.errors.from_user"
          />
        </div>
        <div class="w-1/2 pl-3">
          <InputLabel
              for="keterangan_eksternal"
              value="Keterangan Eksternal"
              :isRequired="true"
          />
          <TextInput
              id="keterangan_eksternal"
              type="text"
              class="mt-1 block w-full"
              v-model="form.from_ext"
              autofocus
              autocomplete="Keterangan Eksternal ..."
              placeholder="Keterangan Eksternal ..."
          />
        </div>
      </div>
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel
              for="Diteruskan Kepada"
              value="Diteruskan Kepada"
              :isRequired="true"
          />

          <multiselect
              v-model="form.forwarded_to"
              :options="forwardedList"
              :searchable="true"
              :show-labels="true"
              :allow-empty="false"
              label="label"
              track-by="label"
              placeholder="-- Pilih Diteruskan Kepada ... --"
          ></multiselect>

          <InputError
              class="mt-2"
              :message="form.errors.forwarded_to"
          />
        </div>
        <div class="w-1/2 pl-3">
          <InputLabel
              for="tanggal_diteruskan"
              value="Tanggal Diteruskan"
              :isRequired="true"
          />

          <VueDatePicker id="forwarded_date" v-model="form.forwarded_date" locale="id" :enable-time-picker="false"
                         autofocus
                         autocomplete="forwarded_date" :format="formatDate" auto-apply auto-position="top">
          </VueDatePicker>

          <InputError
              class="mt-2"
              :message="form.errors.forwarded_date"
          />
        </div>
      </div>
      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel
              for="file_pdf"
              value="File Lampiran"
              :isRequired="true"
          />

          <FileInput
              id="File Lampiran"
              class="mt-1 block w-full"
              accept=".pdf"
              v-model="form.file_pdf"
          />

          <InputError
              class="mt-2"
              :message="form.errors.file_pdf"
          />
        </div>
        <div class="w-1/2 pl-3">
          <InputLabel for="keterangan" value="Keterangan" :isRequired="true"/>

          <TextInput
              id="keterangan"
              type="text"
              class="mt-1 block full"
              v-model="form.description"
              autofocus
              autocomplete="Keterangan"
              placeholder="Keterangan ..."
          />

          <InputError class="mt-2" :message="form.errors.description"/>
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