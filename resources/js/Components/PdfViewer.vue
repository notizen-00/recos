<script setup>
import { VPdfViewer } from "@vue-pdf-viewer/viewer";
import { computed } from "vue";
const props = defineProps({
    filename: String,
});

// Membuat URL lengkap untuk file
const fileUrl = computed(() => {
    return `/storage/${props.filename}`;
});
</script>

<template>
    <div class="w-3/4 mx-auto" :style="{ width: '1028px', height: '700px' }">
        <VPdfViewer :src="fileUrl" />
    </div>
</template>
