<script setup>

const props = defineProps({
  modelValue: {
    type: [File, null],
    required: true,
  },
  id: {
    type: String,
    required: true
  },
  accept: {
    type: String,
    default: ''
  }
})

const emit = defineEmits(['update:modelValue']);

const handleChange = (event) => {
  const file = event.target.files[0] || null; // Jika tidak ada file, kirim null
  emit('update:modelValue', file); // Kirim objek File atau null
  console.log(file)
};
</script>

<template>
  <div class="relative inline-block">
    <input
        class="file:absolute file:right-0 file:bg-gradient-to-tl file:from-blue-500 file:to-violet-500 file:text-white file:border-0 file:py-1 file:px-3 file:rounded-3 file:shadow-xl text-gray-600 file:cursor-pointer"
        type="file"
        :id="id"
        :accept="accept"
        @change="handleChange"
    />
  </div>
</template>