<script setup>
import DangerButton from "@/Components/DangerButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUnitDeletion = ref(false);

const props = defineProps({
    units: Object,
});

const form = useForm({});

const confirmUnitDeletion = () => {
    confirmingUnitDeletion.value = true;
};

const deleteUnit = () => {
    form.delete(route("unit.destroy", props.units?.id), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUnitDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <div
            class="text-sm text-red-500 cursor-pointer"
            @click="confirmUnitDeletion"
        >
            Delete
        </div>
        <Modal :show="confirmingUnitDeletion" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-slate-200"
                >
                    Are you sure you want to delete ?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-slate-200">
                    Jika data yang anda hapus adalah parent maka sub parent juga
                    akan ikut terhapus !
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton class="ms-3" @click="deleteUnit">
                        Delete Unit
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
