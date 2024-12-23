<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {ref, watchEffect} from "vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import SelectInput from "@/Components/SelectInput.vue";
import Multiselect from "vue-multiselect";
import YellowButton from "@/Components/YellowButton.vue";

const isModalEditOpen = ref(false);

const props = defineProps({
  type: Object,
  listBod: Object
});

const form = useForm({
  name: "",
  letter_format: "",
  form_type: "",
  ttd_type: "",
  bod: "",
  type_id: props.type?.type_id,
});

const openModal = () => {
  isModalEditOpen.value = true;
  form.reset();
};

const updateSubType = () => {
  form.put(route("sub-type.update", props.type.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      // form.reset();
    },

    // onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  form.reset;
  isModalEditOpen.value = false;
};

const bods = props.listBod?.map((el) => ({
  label: el.title,
  id: el.id,
}))

watchEffect(() => {
  if (isModalEditOpen.value) {
    form.errors = {};
    form.type_id = props.type?.type_id;
    form.name = props.type?.name;
    form.letter_format = props.type?.letter_format;
    form.form_type = props.type?.form_type;
    form.ttd_type = props.type?.ttd_type;

    let bod = [];
    props.type?.bod.split(',').forEach((item) => {
      let bodx = bods.find(el => el.id == item) || '';
      bod.push(bodx);
    });
    form.bod = bod;
  }
});
</script>

<template>
  <YellowButton
      @click="openModal">
    <font-awesome-icon :icon="['fas', 'pencil']"/>&nbsp;Edit
  </YellowButton>
  <Modal :show="isModalEditOpen" @close="closeModal">
    <div class="mb-8 mx-6">
      <h5 class="dark:text-slate-200">
        Edit SubType : {{ props.type?.name }}
      </h5>
    </div>
    <form @submit.prevent="updateSubType" class="m-5">
      <div>
        <InputLabel for="name" value="Name" :isRequired="true"/>

        <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            autofocus
            autocomplete="name"
            placeholder="Nama Sub Tipe Surat"
        />

        <InputError class="mt-2" :message="form.errors.name"/>
      </div>

      <div class="mt-2">
        <InputLabel
            for="format_surat"
            value="Format Nomor Surat"
            :isRequired="true"
        />

        <TextInput
            id="format_surat"
            type="text"
            class="mt-1 block w-full"
            v-model="form.letter_format"
            autofocus
            autocomplete="letter_format"
            placeholder="Format Nomor Surat"
        />

        <InputError class="mt-2" :message="form.errors.letter_format"/>
      </div>
      <div class="mt-2">
        <InputLabel for="bod" value="Bod" :isRequired="true"/>
        <multiselect
            v-model="form.bod"
            :options="bods"
            :searchable="true"
            :show-labels="true"
            :allow-empty="false"
            :multiple="true"
            label="label"
            track-by="label"
            placeholder="-- Pilih Bod ... --"
        ></multiselect>

        <InputError
            class="mt-2"
            :message="form.errors.bod"/>
      </div>
      <div class="mt-2">
        <InputLabel for="tipe_form" value="Tipe Form Surat" :isRequired="true"/>
        <SelectInput class="w-15 h-10 text-sm" v-model="form.form_type"
                     :dataSet="[{label: 'Tipe Form 1 (tanpa content)', value: '1'}, {label: 'Tipe Form 2 (dengan content)', value: '2'}]"
                     :placeholder="`--- Pilih Tipe Form ---`" style="width:100%;"/>
        <InputError class="mt-2" :message="form.errors.form_type"/>
      </div>
      <div class="mt-2">
        <InputLabel for="tipe_ttd" value="Tipe Tanda Tangan" :isRequired="true"/>
        <SelectInput class="w-15 h-10 text-sm" v-model="form.ttd_type"
                     :dataSet="[{label: 'Internal', value: '1'}, {label: 'BSrE', value: '2'}]"
                     :placeholder="`--- Pilih Tipe Tanda Tangan ---`" style="width:100%;"/>
        <InputError class="mt-2" :message="form.errors.ttd_type"/>
      </div>

      <div class="mt-20 flex justify-start">
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