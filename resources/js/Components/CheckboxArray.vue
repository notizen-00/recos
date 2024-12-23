<template>
  <input
      type="checkbox"
      :id="id"
      :value="value"
      :checked="Array.isArray(modelValue) ? modelValue.includes(value) : modelValue"
      @change="onChange"
      class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:bg-transparent"
  />
</template>

<script>
export default {
  props: {
    modelValue: {
      type: [Array, Boolean],
      required: true,
    },
    value: {
      required: true,
    },
    id: [String, Number],
  },
  methods: {
    onChange(event) {
      const isChecked = event.target.checked;
      if (Array.isArray(this.modelValue)) {
        let newValue = [...this.modelValue];

        if (isChecked) {
          // Tambahkan nilai jika checkbox dicentang
          newValue.push(this.value);
        } else {
          // Hapus nilai jika checkbox tidak dicentang
          newValue = newValue.filter((val) => val !== this.value);
        }

        this.$emit('update:modelValue', newValue);
      } else {
        // Jika modelValue adalah boolean
        this.$emit('update:modelValue', isChecked);
      }
    },
  },
};
</script>
