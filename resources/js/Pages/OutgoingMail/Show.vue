<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { reactive, watch } from "vue";
import { cloneDeep, debounce, pickBy } from "lodash";
import Create from "@/Pages/OutgoingMail/Create.vue";
import Tracking from "@/Pages/OutgoingMail/Tracking.vue";
import Detail from "@/Pages/OutgoingMail/Detail.vue";
import DeleteBulk from "@/Pages/OutgoingMail/DeleteBulk.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Pagination from "@/Components/Pagination.vue";
import CreateUmum from "@/Pages/OutgoingMail/CreateUmum.vue";

const page = usePage();
const props = defineProps({
    filters: Object,
    perPage: Number,
    outgoing_mail: Object,
    sub_type: Object,
    detail_department: Object,
    priority: Object,
    sign_mail_list: Object,
    classification: Object,
    orgSubjects: Object,
});

const data = reactive({
    params: {
        search: props.filters.search,
        field: props.filters.field,
        order: props.filters.order,
        perPage: props.perPage,
    },
    outgoing_mail: null,
    sub_type: null,
    dataSet: usePage().props.app.perpage,
    selectedId: [],
    isMultiple: false,
});

const order = (request) => {
    data.params.field = request;
    data.params.order = data.params.order === "asc" ? "desc" : "asc";
};

watch(
    () => cloneDeep(data.params),
    debounce(() => {
        let param = pickBy(data.params);

        router.get(route("outgoing-mail.show", data.sub_type?.id), param, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);

const selectAll = (event) => {
    if (event.target.checked === false) {
        data.selectedId = [];
    } else {
        props.outgoing_mail?.data.forEach((Outgoing_mail) => {
            data.selectedId.push(Outgoing_mail.id);
        });
    }
};

const select = () => {
    if (props.outgoing_mail?.data.length == data.selectedId.length) {
        data.isMultiple = true;
    } else {
        data.isMultiple = false;
    }
};
</script>
<template>
    <Head :title="props.sub_type.name" />

    <AuthenticatedLayout>
        <div class="flex flex-wrap -mx-3">
            <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border"
                >
                    <div class="text-xl font-bold px-3 py-4">
                        {{ props.sub_type.name }}
                    </div>
                    <div
                        class="flex flex-row my-6 justify-between items-center px-6 pb-0 mb-0 rounded-t-2xl"
                    >
                        <div class="flex items-center space-x-2">
                            <SelectInput
                                class="w-15 h-10 text-sm"
                                v-model="data.params.perPage"
                                :dataSet="data.dataSet"
                            />
                            <!-- <h5 class="dark:text-white">User table</h5> -->
                            <SearchBar v-model="data.params.search" />
                        </div>

                        <div>
                            <DeleteBulk
                                v-if="
                                    data.selectedId.length != 0 &&
                                    can(['delete outgoing_mail'])
                                "
                                :selectedId="data.selectedId"
                            />
                            <Create
                                :sub_types="props.sub_type"
                                :detail_department="props.detail_department"
                                :sign_mail_list="props.sign_mail_list"
                                :priority="props.priority"
                                :classification="props.classification"
                                v-if="props.sub_type.form_type == 1"
                            />
                            <CreateUmum
                                :sub_types="props.sub_type"
                                :detail_department="props.detail_department"
                                :priority="props.priority"
                                :sign_mail_list="props.sign_mail_list"
                                :classification="props.classification"
                                :orgSubjects="props.orgSubjects"
                                v-if="props.sub_type.form_type == 2"
                            />
                        </div>
                    </div>

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
                                            <Checkbox
                                                class="p-2 dark:border-slate-400"
                                                v-model:checked="
                                                    data.isMultiple
                                                "
                                                @change="selectAll"
                                            />
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                            @click="order('full_number')"
                                        >
                                            Nomor Surat
                                            <i
                                                v-show="
                                                    data.params.field ===
                                                        'full_number' &&
                                                    data.params.order === 'asc'
                                                "
                                                class="fas fa-angle-up ms-3"
                                            ></i>
                                            <i
                                                v-show="
                                                    data.params.field ===
                                                        'full_number' &&
                                                    data.params.order === 'desc'
                                                "
                                                class="fas fa-angle-down ms-3"
                                            ></i>
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            Tentang
                                        </th>
                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            <div
                                                v-if="
                                                    props.sub_type.form_type ==
                                                    1
                                                "
                                            >
                                                Ditetapkan Di
                                            </div>
                                            <div v-else>Lampiran</div>
                                        </th>

                                        <th
                                            class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        >
                                            Ditetapkan Tanggal
                                        </th>

                                        <!-- <th
class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
@click="order('created_at')"
>
Created AT
<i
    v-show="
        data.params.field ===
            'created_at' &&
        data.params.order === 'asc'
    "
    class="fas fa-angle-up ms-3"
></i>
<i
    v-show="
        data.params.field ===
            'created_at' &&
        data.params.order === 'desc'
    "
    class="fas fa-angle-down ms-3"
></i>
</th> -->

                                        <th
                                            class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"
                                        ></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(Outgoing_mail, index) in props
                                            .outgoing_mail.data"
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
                                                :value="Outgoing_mail.id"
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
                                                        v-if="
                                                            Outgoing_mail.full_number ==
                                                            null
                                                        "
                                                        class="mb-0 text-xs leading-normal border-blue-500 text-blue-500 dark:text-white"
                                                    >
                                                        <span
                                                            v-if="
                                                                Outgoing_mail.full_number
                                                                    ? Outgoing_mail.full_number
                                                                    : Outgoing_mail
                                                                          .tracking_outgoing_mails[0]
                                                                          .status ==
                                                                      1
                                                            "
                                                            class="border-separate border-2 px-2 flex justify-center text-center"
                                                        >
                                                            Review
                                                        </span>

                                                        <span
                                                            v-else-if="
                                                                Outgoing_mail.full_number
                                                                    ? Outgoing_mail.full_number
                                                                    : Outgoing_mail
                                                                          .tracking_outgoing_mails[0]
                                                                          .status ==
                                                                      0
                                                            "
                                                            class="border-separate border-2 border-red-400 rounded-3 px-2 flex justify-center text-center text-red-500"
                                                        >
                                                            Revisi
                                                        </span>

                                                        <span
                                                            v-else
                                                            class="border-separate border-2 px-2 flex justify-center text-center text-black"
                                                        >
                                                            Menunggu Persetujuan
                                                        </span>

                                                        <font-awesome-icon
                                                            :icon="[
                                                                'fas',
                                                                'user-check',
                                                            ]"
                                                            class="fas fa-user"
                                                        ></font-awesome-icon>
                                                        {{
                                                            Outgoing_mail.full_number
                                                                ? Outgoing_mail.full_number
                                                                : Outgoing_mail
                                                                      .tracking_outgoing_mails[0]
                                                                      .to
                                                                      .detail_department
                                                                      .title
                                                        }}
                                                    </h6>
                                                    <div
                                                        class="text-green-500 text-md"
                                                        v-else
                                                    >
                                                        {{
                                                            Outgoing_mail.full_number
                                                        }}
                                                    </div>
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
                                                        {{
                                                            Outgoing_mail.subject
                                                        }}
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
                                                        v-if="
                                                            Outgoing_mail.mail_place !=
                                                            ''
                                                        "
                                                        class="mb-0 text-sm leading-normal dark:text-white"
                                                    >
                                                        {{
                                                            Outgoing_mail.mail_place
                                                        }}
                                                    </h6>
                                                    <div v-else>
                                                        <Link
                                                            class="text-info"
                                                            :href="`/outgoing_mail/attachment/${Outgoing_mail.id}`"
                                                            ><span
                                                                class="text-blue-500 border-collapse border-blue-500 border-2 px-2 rounded-6 text-sm"
                                                                ><font-awesome-icon
                                                                    :icon="[
                                                                        'fas',
                                                                        'file-pdf',
                                                                    ]"
                                                                ></font-awesome-icon>
                                                                Lihat</span
                                                            ></Link
                                                        >
                                                    </div>
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
                                                        {{
                                                            Outgoing_mail.mail_date
                                                        }}
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
                                        >
                                            <Detail
                                                :outgoing_mail="Outgoing_mail"
                                                :sub_types="props.sub_type"
                                                :detail_department="
                                                    props.detail_department
                                                "
                                                :priority="props.priority"
                                                :sign_mail_list="
                                                    props.sign_mail_list
                                                "
                                                :classification="
                                                    props.classification
                                                "
                                                :orgSubjects="props.orgSubjects"
                                            />

                                            <Tracking
                                                :outgoing_mail="Outgoing_mail"
                                            />

                                            <!-- <a
class="text-green-400 text-sm cursor-pointer"
:href="
    route(
        'Outgoing_mail.show',
        Outgoing_mail.id
    )
"
>Lihat</a
>
<Edit
:Outgoing_mail="
    (data.outgoing_mail =
        Outgoing_mail)
"
/>
<Delete
:Outgoing_mail="
    (data.outgoing_mail =
        Outgoing_mail)
"
/> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <Pagination
                                :links="props.outgoing_mail"
                                :filters="data.params"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
