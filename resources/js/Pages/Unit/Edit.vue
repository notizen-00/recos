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
    unit: Object,
    unitParents: Object,
});

const form = useForm({
    name: "",
    level: "",
    parent_id: "",
    code: "",
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

const unitParents = props.unitParents?.map((unit) => ({
    label: unit.name,
    value: unit.id,
}));
watchEffect(() => {
    if (isModalEditOpen.value) {
        form.errors = {};
        form.name = props.unit?.name;
        form.code = props.unit?.code;
        form.level = props.unit?.level;
        form.parent_id = props.unit?.parent_id;
    }
});
</script>

<template>
    <div class="text-slate-400 text-sm cursor-pointer" @click="openModal">
        Edit
    </div>

    <Modal :show="isModalEditOpen" @close="closeModal">
        <div class="mb-5 mx-6">
            <h5 class="dark:text-slate-200">Edit Unit</h5>
        </div>
        <form @submit.prevent="updateUnit" class="m-5">
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

            <div class="mt-4">
                <InputLabel
                    for="code"
                    value="Kode Unit Kerja"
                    :isRequired="true"
                />

                <TextInput
                    id="code"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.code"
                    autocomplete="Kode Unit Kerja"
                />

                <InputError class="mt-2" :message="form.errors.code" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="level"
                    value="Level Unit Kerja"
                    :isRequired="true"
                />

                <TextInput
                    id="level"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.level"
                    autocomplete="Level Unit Kerja"
                />

                <InputError class="mt-2" :message="form.errors.level" />
            </div>

            <div class="mt-4">
                <InputLabel for="parent_id" value="Parent" />
                <SelectInput
                    id="parent_id"
                    class="mt-1 block w-full"
                    v-model="form.parent_id"
                    required
                    :dataSet="unitParents"
                >
                </SelectInput>
                <InputError class="mt-2" :message="form.errors.parent_id" />
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
