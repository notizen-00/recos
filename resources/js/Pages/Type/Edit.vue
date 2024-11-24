<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watchEffect } from "vue";

const isModalEditOpen = ref(false);

const props = defineProps({
  type: Object,
});

const form = useForm({
  name: "",
});

const openModal = () => {
  isModalEditOpen.value = true;
  form.errors = {};
};

const updateType = () => {
  form.put(route("type.update", props.type?.id), {
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

watchEffect(() => {
  if (isModalEditOpen.value) {
    form.errors = {};
    form.name = props.type?.name;
  }
});
</script>

<template>
  <div class="text-slate-400 text-sm cursor-pointer" @click="openModal">
    Edit
  </div>

  <Modal :show="isModalEditOpen" @close="closeModal">
    <div class="mb-5 mx-6">
      <h5 class="dark:text-slate-200">Edit Tipe Surat</h5>
    </div>
    <form @submit.prevent="updateType" class="m-5">
      <div>
        <InputLabel for="name" value="Name" :isRequired="true" />

        <TextInput
          id="name"
          type="text"
          class="mt-1 block w-full"
          v-model="form.name"
          autofocus
          autocomplete="name"
        />

        <InputError class="mt-2" :message="form.errors.name" />
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
