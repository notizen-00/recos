<script setup>
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Modal from "@/Components/Modal.vue";
import TextInput from "@/Components/TextInput.vue";
import Create from "@/Pages/SubType/Create.vue";
import { ref, watchEffect, reactive } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage, useForm } from "@inertiajs/vue3";

const isModalEditOpen = ref(false);

const props = defineProps({
    type: Object,
});

const data = reactive({
    type: null,
    dataSet: usePage().props.app.perpage,
    selectedId: [],
    isMultiple: false,
});

const selectAll = (event) => {
    if (event.target.checked === false) {
        data.selectedId = [];
    } else {
        props.type?.data.forEach((Type) => {
            data.selectedId.push(Type.id);
        });
    }
};

const select = () => {
    if (props.type?.data.length == data.selectedId.length) {
        data.isMultiple = true;
    } else {
        data.isMultiple = false;
    }
};

watchEffect(() => {
    if (isModalEditOpen.value) {
        form.errors = {};
        form.name = props.type?.name;
    }
});
</script>

<template>
    <Head :title="props.type.name" />

    <AuthenticatedLayout>
        <div class="flex flex-wrap -mx-3">
            <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border"
                >
                    <h3 class="text-slate-400 px-4 py-5">
                        <font-awesome-icon
                            :icon="['fas', 'list']"
                            class="mr-2"
                        />
                        {{ props.type.name }}
                    </h3>
                </div>
            </div>
            <div class="flex-auto px-5 pt-0 pb-2">
                <div class="p-0 overflow-x-auto">
                    <div
                        class="flex flex-row my-6 justify-between items-center px-6 pb-0 mb-0 rounded-t-2xl"
                    >
                        <div class="flex items-center space-x-2 text-white">
                            FORM SUB TYPE
                        </div>

                        <div>
                            <DeleteBulk
                                v-if="
                                    data.selectedId.length != 0 &&
                                    can(['delete type'])
                                "
                                :selectedId="data.selectedId"
                            />
                            <Create :type="props.type" v-else />
                        </div>
                    </div>
                    <table
                        class="items-center w-full mb-5 align-top border-collapse dark:border-white/40 text-slate-500"
                    >
                        <thead class="align-bottom">
                            <tr>
                                <th
                                    class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                >
                                    <Checkbox
                                        class="p-2 dark:border-slate-400"
                                        v-model:checked="data.isMultiple"
                                        @change="selectAll"
                                    />
                                </th>
                                <th
                                    class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                    @click="order('name')"
                                >
                                    Name Sub Type
                                </th>
                                <th
                                    class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                    @click="order('name')"
                                >
                                    Format Nomor Surat
                                </th>

                                <th
                                    class="px-6 py-3 font-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                    @click="order('created_at')"
                                >
                                    Created AT
                                </th>

                                <th
                                    class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                ></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="props.type.sub_types.length === 0">
                                <td
                                    colspan="5"
                                    rowspan="6"
                                    class="text-center py-4 my-4 text-gray-500"
                                >
                                    Data Sub Types Kosong
                                </td>
                            </tr>
                            <tr
                                v-else
                                v-for="(type, index) in props.type.sub_types"
                                :key="index"
                                class="border-b dark:border-slate-400 last:border-0"
                            >
                                <td
                                    class="px-6 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                                >
                                    <input
                                        class="rounded p-2 dark:bg-slate-900 dark:border-slate-700 text-primary dark:text-primary focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                                        type="checkbox"
                                        @change="select"
                                        :value="type.id"
                                        v-model="data.selectedId"
                                    />
                                </td>

                                <td
                                    class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                                >
                                    <div class="flex px-2 py-1">
                                        <div
                                            class="flex flex-col justify-center"
                                        >
                                            <h6
                                                class="mb-0 text-sm leading-normal dark:text-white"
                                            >
                                                {{ type.name }}
                                            </h6>
                                        </div>
                                    </div>
                                </td>

                                <td
                                    class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                                >
                                    <div class="flex px-2 py-1">
                                        <div
                                            class="flex flex-col justify-center"
                                        >
                                            <h6
                                                class="mb-0 text-sm leading-normal dark:text-white"
                                            >
                                                {{ type.letter_format }}
                                            </h6>
                                        </div>
                                    </div>
                                </td>

                                <td
                                    class="p-2 text-xs leading-normal text-center align-middle bg-transparent whitespace-nowrap shadow-transparent"
                                >
                                    {{ type.created_at }}
                                </td>
                                <td
                                    class="flex gap-5 justify-center items-center p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent"
                                >
                                    <Edit :type="(data.type = type)" />
                                    <Delete :type="(data.type = type)" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination :links="props.type" :filters="data.params" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
