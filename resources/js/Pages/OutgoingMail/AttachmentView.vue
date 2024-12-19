<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { reactive, watch } from "vue";
import PdfViewer from "@/Components/PdfViewer.vue";

const props = defineProps({
    filename: String,
});
</script>
<template>
    <Head title="Lihat Attachment" />
    <AuthenticatedLayout>
        <div class="flex flex-wrap -mx-3">
            <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
                <PdfViewer :filename="props.filename" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
