<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import {useForm} from "@inertiajs/vue3";
import {ref} from "vue";
import PurpleButton from "@/Components/PurpleButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const isModalOpen = ref(false);

const props = defineProps({});

const form = useForm({
  name: "",
});

const openModal = () => {
  isModalOpen.value = true;
  form.reset();
};

const createNewUnit = () => {
  form.post(route("type.store"), {
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
</script>

<template>
  <PurpleButton
      @click="openModal">
    <font-awesome-icon :icon="['fas', 'plus']"/>
    Tambah Data
  </PurpleButton>

  <Modal :show="isModalOpen" @close="closeModal">
    <div class="mb-8 mx-6">
      <h5 class="dark:text-slate-200">Tambah Tipe Surat</h5>
    </div>
    <form @submit.prevent="createNewUnit" class="m-5">
      <div>
        <InputLabel for="name" value="Name" :isRequired="true"/>

        <TextInput
            id="name"
            type="text"
            class="mt-1 block w-full"
            v-model="form.name"
            autofocus
            autocomplete="name"
            placeholder="Nama Tipe"
        />

        <InputError class="mt-2" :message="form.errors.name"/>
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
