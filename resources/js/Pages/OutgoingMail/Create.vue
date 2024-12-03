<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Multiselect from "vue-multiselect";
import { getParentDepartmentHirarki } from "@/services/hirarki";

const isModalOpen = ref(false);

const props = defineProps({
  sub_types: Object,
  detail_department: Object,
  priority: Object,
  sign_mail_list: Object,
  classification: Object,
});

const form = useForm({
  subject: "",
  sub_type_id: props.sub_types.id,
  form_type: props.sub_types.form_type,
  nomor: "Nomor Generate Otomatis !",
  mail_place: "",
  mail_date: "",
  detail_department_id: usePage().props.auth.detail_department.title,
  to: "",
  priority: "",
  classification: "",
  sign_user: "",
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

const startingParentId = usePage().props.auth.detail_department.parent_id;
const endingParentId = 1;

console.log(
  getParentDepartmentHirarki(
    props.detail_department,
    startingParentId,
    endingParentId
  )
);

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

const sign_mail_list = props.sign_mail_list.map((detail_department) => ({
  label:
    detail_department.name +
    " -- (" +
    detail_department.detail_department.title +
    " / " +
    detail_department.detail_department.bod.title +
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
      <div>
        <InputLabel for="nomor" value="Nomor" />

        <TextInput
          id="nomor"
          readonly
          disabled
          type="text"
          class="mt-1 cursor-not-allowed dark:bg-slate-500 bg-slate-800 block w-1/2 text-red-600"
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

          <InputError class="mt-2" :message="form.errors.mail_place" />
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
            class="mt-1 block w-full text-red-500 dark:bg-slate-500 bg-slate-800 cursor-not-allowed"
            v-model="form.detail_department_id"
            autofocus
            autocomplete="Dibuat Oleh"
          />

          <InputError
            class="mt-2"
            :message="form.errors.detail_department_id"
          />
        </div>
      </div>

      <div>
        <InputLabel
          for="TTD Oleh"
          value="TTD Oleh"
          class="mt-2"
          :isRequired="true"
        />

        <multiselect
          v-model="form.sign_user"
          :options="sign_mail_list"
          :searchable="true"
          :show-labels="true"
          :allow-empty="false"
          label="label"
          track-by="label"
          placeholder="-- Pilih detail_department TTD OLeh --"
        ></multiselect>

        <InputError class="mt-2" :message="form.errors.sign_user" />
      </div>

      <div class="w-full flex justify-between mt-2">
        <div class="w-1/2">
          <InputLabel for="Derajat" value="Derajat" :isRequired="true" />

          <multiselect
            v-model="form.priority"
            :options="priority"
            :searchable="true"
            :show-labels="true"
            :allow-empty="false"
            :modelValue="id"
            label="name"
            track-by="name"
            placeholder="-- Pilih Prioritas --"
          ></multiselect>

          <InputError class="mt-2" :message="form.errors.priority" />
        </div>

        <div class="w-1/2">
          <InputLabel
            for=""
            value="Klasifikasi"
            class="mx-3"
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
            class="mx-3"
            placeholder="-- Pilih Klasifikasi --"
          ></multiselect>

          <InputError class="mt-2" :message="form.errors.classification" />
        </div>
      </div>

      <div class="mt-4">
        <InputLabel for="to" :isRequired="false">
          <template #default>Di Kirim Ke</template>
        </InputLabel>

        <multiselect
          v-model="form.to"
          :options="detail_departments"
          :searchable="true"
          :show-labels="true"
          :allow-empty="false"
          label="label"
          track-by="label"
          placeholder="-- Pilih User/detail_department --"
        ></multiselect>
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

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
