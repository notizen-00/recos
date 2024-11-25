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
    outgoing_mail: Object,
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
    <div
        class="text-blue-400 hover:text-white hover:bg-blue-400 text-sm cursor-pointer border-2 border-blue-300 rounded-2 px-2"
        @click="openModal"
    >
        <font-awesome-icon :icon="['fas', 'eye']" /> Tracking
    </div>

    <Modal :show="isModalEditOpen" @close="closeModal" maxWidth="4xl">
        <div class="mb-5 mx-6">
            <h5 class="dark:text-slate-200">Lembar Penerus</h5>
            <hr class="bg-black h-1" />
            <p class="text-sm text-slate-700">
                Proses Surat / Dokumen dari konseptor dan pejabat terkait
            </p>

            <div class="w-full flex justify-start text-sm">
                <div class="w-1/6">Nomor Dokumen</div>
                <div class="w-3/4 text-start">
                    <b>{{ props.outgoing_mail.full_number }}</b>
                </div>
            </div>
            <div class="w-full flex justify-start text-sm">
                <div class="w-1/6">Perihal</div>
                <div class="w-3/4">
                    <b>{{ props.outgoing_mail.subject }}</b>
                </div>
            </div>
            <p class="text-sm mt-2">
                Dokumen / surat terlampir telah diperiksa dan diteliti secara
                hierarki serta diparaf oleh para pejabat terkait yang
                bertanggung jawab, untuk selanjutnya diteruskan kepada Direktur
                untuk ditandatangani.
            </p>
        </div>

        <!-- {{ props.outgoing_mail.tracking_outgoing_mails[0].to }} -->
        <div class="flex-auto px-5 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
                <table
                    class="items-center w-full mb-5 align-top border-collapse dark:border-white/40 text-slate-500"
                >
                    <thead class="align-bottom">
                        <tr>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            >
                                Nama Pengirim
                            </th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            >
                                Diteruskan kepada
                            </th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            >
                                Status
                            </th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            >
                                Catatan
                            </th>
                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            >
                                Diterima Tanggal
                            </th>

                            <th
                                class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            >
                                Diteruskan Tanggal
                            </th>

                            <th
                                class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"
                            ></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(tracking, index) in props.outgoing_mail
                                .tracking_outgoing_mails"
                            :key="index"
                            class="border-b dark:border-slate-400 last:border-0"
                        >
                            <td
                                class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                            >
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6
                                            class="mb-0 text-xs leading-normal dark:text-white"
                                        >
                                            {{ tracking.sender.name }}
                                            <!-- {{ tracking.sender.unit.name }} -->
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                            >
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6
                                            class="mb-0 text-xs leading-normal dark:text-white"
                                        >
                                            {{ tracking.to.unit.name }}
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                            >
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6
                                            class="mb-0 text-xs leading-normal dark:text-white"
                                            :class="
                                                tracking.status == 1
                                                    ? 'text-green-400'
                                                    : 'text-red-400'
                                            "
                                        >
                                            {{
                                                tracking.status == 1
                                                    ? "Diteruskan"
                                                    : "Revisi"
                                            }}
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                            >
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6
                                            class="mb-0 text-xs leading-normal dark:text-white"
                                        >
                                            {{
                                                tracking.note
                                                    ? tracking.note
                                                    : "-"
                                            }}
                                        </h6>
                                    </div>
                                </div>
                            </td>

                            <td
                                class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                            >
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6
                                            class="mb-0 text-xs leading-normal dark:text-white"
                                        >
                                            {{
                                                tracking.read_at
                                                    ? tracking.read_at
                                                    : "Belum Di Baca"
                                            }}
                                        </h6>
                                    </div>
                                </div>
                            </td>
                            <td
                                class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent"
                            >
                                <div class="flex px-2 py-1">
                                    <div class="flex flex-col justify-center">
                                        <h6
                                            class="mb-0 text-xs leading-normal dark:text-white"
                                        >
                                            {{ tracking.forward_date }}
                                        </h6>
                                    </div>
                                </div>
                            </td>

                            <!-- <td
                                            class="p-2 text-xs leading-normal text-center align-middle bg-transparent whitespace-nowrap shadow-transparent"
                                        >
                                            {{ Outgoing_mail.created_at }}
                                        </td> -->
                            <td
                                class="flex gap-5 justify-center items-center p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent"
                            ></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <div>
                <SecondaryButton class="py-4 px-6" @click="closeModal">
                    Keluar
                </SecondaryButton>
            </div>
            <div>
                <PrimaryButton class="me-3 mx-3 mb-4"
                    >Cetak Lembar Penerus</PrimaryButton
                >
            </div>
        </div>
    </Modal>
</template>
