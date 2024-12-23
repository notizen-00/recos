<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import Multiselect from "vue-multiselect";
import PurpleButton from "@/Components/PurpleButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const isModalOpen = ref(false);

const props = defineProps({
  listParent: Object,
  listBod: Object,
  listFuncDep: Object,
  listUnit: Object,
});

const form = useForm({
  name: "",
  funcdep: "",
  unit: "",
  code: "",
  bod: "",
  parent: "",
});

const openModal = () => {
  isModalOpen.value = true;
  form.reset();
};

const createNewUnit = () => {
  form.post(route("unit.store"), {
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
const parents = props.listParent?.map((unit) => ({
  label: unit.title,
  id: unit.id,
}));
const funcDeps = props.listFuncDep?.map((el) => ({
  label: el.title,
  id: el.id,
}));
const units = props.listUnit?.map((el) => ({
  label: el.title,
  id: el.id,
}));
const bods = props.listBod?.map((el) => ({
  label: el.title,
  id: el.id,
}))
</script>

<template>
  <PurpleButton
      @click="openModal">
    <font-awesome-icon :icon="['fas', 'plus']"/>
    Tambah Data
  </PurpleButton>

  <Modal :show="isModalOpen" @close="closeModal">
    <div class="mb-8 mx-6">
      <h5 class="dark:text-slate-200">Tambah Unit</h5>
    </div>
    <form @submit.prevent="createNewUnit" class="m-5">
      <div class="mt-2">
        <InputLabel for="name" value="Name" :isRequired="true"/>

        <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            autofocus
            autocomplete="name"
            placeholder="Nama Unit"
        />

        <InputError class="mt-2" :message="form.errors.name"/>
      </div>
      <div class="mt-2">
        <InputLabel for="funcdep" value="Function Department" :isRequired="true"/>
        <multiselect
            v-model="form.funcdep"
            :options="funcDeps"
            :searchable="true"
            :show-labels="true"
            :allow-empty="false"
            label="label"
            track-by="label"
            placeholder="-- Pilih Function Department ... --"
        ></multiselect>

        <InputError
            class="mt-2"
            :message="form.errors.funcdep"/>
      </div>
      <div class="mt-2">
        <InputLabel for="unit" value="Unit" :isRequired="true"/>
        <multiselect
            v-model="form.unit"
            :options="units"
            :searchable="true"
            :show-labels="true"
            :allow-empty="false"
            label="label"
            track-by="label"
            placeholder="-- Pilih Unit ... --"
        ></multiselect>

        <InputError
            class="mt-2"
            :message="form.errors.unit"/>
      </div>

      <div class="mt-2">
        <InputLabel for="code" value="Kode Organisasi"/>

        <TextInput
            id="code"
            type="text"
            class="mt-1 block full"
            v-model="form.code"
            autofocus
            autocomplete="Kode Organisasi"
            placeholder="Kode Organisasi ..."
        />

        <InputError class="mt-2" :message="form.errors.code"/>
      </div>
      <div class="mt-2">
        <InputLabel for="bod" value="Bod" :isRequired="true"/>
        <multiselect
            v-model="form.bod"
            :options="bods"
            :searchable="true"
            :show-labels="true"
            :allow-empty="false"
            label="label"
            track-by="label"
            placeholder="-- Pilih Bod ... --"
        ></multiselect>

        <InputError
            class="mt-2"
            :message="form.errors.bod"/>
      </div>
      <div class="mt-2">
        <InputLabel for="parentunit" value="Parent Unit"/>
        <multiselect
            v-model="form.parent"
            :options="parents"
            :searchable="true"
            :show-labels="true"
            :allow-empty="false"
            label="label"
            track-by="label"
            placeholder="-- Pilih Parent Unit ... --"
        ></multiselect>

        <InputError
            class="mt-2"
            :message="form.errors.parent"/>
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