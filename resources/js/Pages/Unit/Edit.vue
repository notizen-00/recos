<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {ref, watchEffect} from "vue";
import Multiselect from "vue-multiselect";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import YellowButton from "@/Components/YellowButton.vue";

const isModalEditOpen = ref(false);

const props = defineProps({
  unit: Object,
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
  isModalEditOpen.value = true;
  form.errors = {};
};

const updateUnit = () => {
  form.put(route("unit.update", props.unit?.id), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      form.reset();
    },
  });
};

const closeModal = () => {
  form.reset;
  isModalEditOpen.value = false;
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
watchEffect(() => {
  if (isModalEditOpen.value) {
    form.errors = {};
    form.name = props.unit?.title;
    form.funcdep = funcDeps.find(el => el.id === props.unit?.functiondep_id) || '';
    form.code = props.unit?.kode_organisasi;
    form.unit = units.find(el => el.id === props.unit?.unit_id) || '';
    form.bod = bods.find(el => el.id === props.unit?.bod_id) || '';
    form.parent = parents.find(el => el.id === props.unit?.parent_id) || '';

    console.log(form)
  }
});
</script>

<template>
  <YellowButton
      @click="openModal">
    <font-awesome-icon :icon="['fas', 'pencil']"/>&nbsp;Edit
  </YellowButton>
  <Modal :show="isModalEditOpen" @close="closeModal">
    <div class="mb-5 mx-6">
      <h5 class="dark:text-slate-200">Edit Unit</h5>
    </div>
    <form @submit.prevent="updateUnit" class="m-5">
      <div>
        <InputLabel for="name" value="Name" :isRequired="true"/>

        <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            autofocus
            autocomplete="name"
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
            track-by="id"
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
            :allow-empty="true"
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
          <PrimaryButton class="me-3 mb-4">Update</PrimaryButton>
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