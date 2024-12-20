<script setup>
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import GreenButton from "@/Components/GreenButton.vue";

const isModalOpen = ref(false);

const props = defineProps({
  file_pdf: String,
});

const openModal = () => {
  isModalOpen.value = true;
};

const closeModal = () => {
  isModalOpen.value = false;
};
</script>
<template>
  <GreenButton
      @click="openModal">
    Download
  </GreenButton>
  <Modal :show="isModalOpen" @close="closeModal" maxWidth="4xl">
    <div class="mb-8 mx-3">
      <h5 class="dark:text-slate-200">
        <font-awesome-icon :icon="['fas', 'file-pdf']"/>
        File PDF
      </h5>
    </div>
    <embed :src="`/storage/${props.file_pdf}`" width="100%" height="600px"/>
    <div class="mt-6 flex justify-start">
      <div>
        <SecondaryButton class="py-4 px-6" @click="closeModal">
          Close
        </SecondaryButton>
      </div>
    </div>
  </Modal>
</template>
