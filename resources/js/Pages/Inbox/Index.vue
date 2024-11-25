<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, usePage } from "@inertiajs/vue3";
import { cloneDeep, debounce, pickBy } from "lodash";
import SelectInput from "@/Components/SelectInput.vue";
import SearchBar from "@/Components/SearchBar.vue";
import {reactive, ref, watch} from "vue";
import {routeName} from "@/Pages/Inbox/utils.js";
import Chip from "@/Components/Chip.vue";
import {replaceChar, simpleDate} from "@/Utils/helpers.js";

const props = defineProps({
    filters: Object,
    perPage: Number,
    mails: Object,
    app: {
        perpage : Array
    }
});

const filters = reactive({
    search: props.filters.search,
    per_page: props.filters.per_page,
})

/*const data = reactive({
    selectedIds: [],
    isSelectAll: false,
});*/

watch(
    () => cloneDeep(filters),
    debounce(() => {
        let param = pickBy(filters);

        router.get(route(routeName("index")), param, {
            replace: true,
            preserveState: true,
            preserveScroll: true,
        });
    }, 150)
);

/*const order = (request) => {
    filters.order_column = request;
    filters.order_direction = filters.order_direction === "asc" ? "desc" : "asc";
};

const selectItem = (all = false) => {
    if (all === true){
        data.selectedIds = data.isSelectAll ? props.mails?.data.map((mail) => mail.id) : [];
    }else{
        data.isSelectAll = props.mails?.data.length === data.selectedIds.length;
    }
};*/

const HeaderColumn = {
    props: ['name', 'className'],
    template : `<th v-bind="$attrs" :class="[' py-3 font-bold text-left uppercase align-middle border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 px-2', className]">
                    {{ name }}
                </th>`
}

const tabs = ['perlu_indakan', 'perbaikan', 'selesai', 'ditolak' ]
const selectedTab = ref(0);
const selectTab = (index) => {
    selectedTab.value = index;
};

const components = { HeaderColumn }

</script>

<template>
    <AuthenticatedLayout title="Inbox">

        <div class="flex flex-wrap -mx-3">
            <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border"
                >
                    <div class="flex border-b border-gray-200 dark:border-gray-700">
                       <div
                            v-for="(tab, index) in tabs"
                            :key="index"
                            :class="['cursor-pointer px-4 py-2 text-sm font-medium focus:outline-none uppercase',
                                      selectedTab === index
                                      ? 'text-blue-600 border-b-2 border-blue-600 dark:text-blue-400 dark:border-blue-400'
                                        : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300',
                                    ]"
                            @click="selectTab(index)"
                        >
                            <span class="me-2">
                                      {{ replaceChar(tab) }}
                            </span>
                            <Chip label="20" />
                        </div>
                    </div>


                    <div
                        class="flex flex-row my-6 justify-between items-center px-6 pb-0 mb-5 rounded-t-2xl"
                    >
                        <div class="flex items-center space-x-2">
                            <SelectInput
                                class="w-15 h-10 text-sm"
                                v-model="filters.perPage"
                                :dataSet="props.app.perpage"
                            />
                            <!-- <h5 class="dark:text-white">User table</h5> -->
                            <SearchBar v-model="filters.search" />
                        </div>
                    </div>
                    <div class="flex-auto px-5 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-5 align-top border-collapse dark:border-white/40 text-slate-500"
                            >
                                <thead class="align-bottom">
                                <tr>
                                    <header-column name="dari" class="sticky left-0 z-10 bg-white dark:bg-slate-850"  />
                                    <header-column name="deskripsi" />
                                    <header-column name="tipe" />
                                    <header-column name="label" class="text-right" />
                                    <header-column name="dikirim pada" class="text-right" />
                                    <header-column name="" class="text-right" />
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    class="border-b dark:border-slate-400 last:border-0 "
                                >

                                    <td
                                        class="text-sm leading-normal dark:text-white py-2 lg:min-w-50 min-w-25 sticky left-0 z-10 bg-white dark:bg-slate-850 px-2 py-3">
                                        <div class="flex flex-col justify-center">
                                            <h6 class="mb-0 leading-normal text-sm dark:text-white ">nama person</h6>
                                            <p class="mb-0 leading-tight text-sm text-slate-400 dark:text-slate-200">nama unit</p>
                                        </div>
                                    </td>
                                    <td
                                        class="text-sm leading-normal text-slate-700 dark:text-slate-200 w-100 px-2 py-3"
                                    >
                                        <div class="overflow-hidden line-clamp-2">
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur in ipsa libero necessitatibus nihil, quas reprehenderit sapiente. Accusamus, accusantium aliquam consequuntur culpa deserunt magni omnis quas quis repellat unde? Suscipit.
                                        </div>
                                    </td>
                                    <td class="text-3 leading-normal dark:text-white min-w-50 px-2 py-3">
                                        Surat Masuk Internal - Surat Dinas Mengatur - Surat Keputusan

                                    </td>

                                    <td
                                        class="text-sm leading-normal dark:text-white min-w-50 px-2 text-right py-3"
                                    >
                                        <Chip type="red" label="Tinggi" class="mb-1" />
                                        <p class="mb-0 leading-tight text-xs text-slate-400 dark:text-slate-200">Organization</p>
                                    </td>
                                    <td class="text-xs leading-normal font-bold dark:text-white align-top whitespace-nowrap px-2 py-3 "
                                    >
                                        {{ simpleDate('2024-10-10 10:10') }}
                                    </td>
                                    <td class="gap-5 p-2 bg-transparent whitespace-nowrap shadow-transparent"
                                    >
                                        <div class="flex justify-end">
                                            <a class="inline-block px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md">Buka</a>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
<!--                            <Pagination
                                :links="props.units"
                                :filters="data.params"
                            />-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
