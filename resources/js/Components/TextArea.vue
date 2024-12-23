<script setup>
import {onMounted, ref} from 'vue';

const model = defineModel({
  type: String,
  required: true,
});

const props = defineProps({
  placeholder: {
    type: String,
    default: '',
  },
  rows: {
    type: Number,
    default: 4,
  },
  disabled: {
    type: Boolean,
    default: false,
  }
})

const textarea = ref(null);

onMounted(() => {
  if (textarea.value.hasAttribute('autofocus')) {
    textarea.value.focus();
  }
});

defineExpose({focus: () => textarea.value.focus()});
</script>

<template>
  <textarea :rows="rows" :placeholder="placeholder" :disabled="disabled" v-model="model" ref="textarea"
            class="focus:shadow-primary-outline min-h-unset text-sm leading-5.6 ease block h-auto w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"
            style="resize: none;"></textarea>
</template>