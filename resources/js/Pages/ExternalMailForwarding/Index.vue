<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {reactive, watch} from "vue";
import {cloneDeep, debounce, pickBy} from "lodash";
import SelectInput from "@/Components/SelectInput.vue";
import SearchBar from "@/Components/SearchBar.vue";
import ViewFile from "@/Pages/ExternalMail/ViewFile.vue";
import Disposisi from "@/Pages/ExternalMailForwarding/Disposisi.vue";

const page = usePage();
const props = defineProps({
  filters: Object,
  perPage: Number,
  externalMail: Object,
  followUpTypes: Object,
  userDepartment: Object
});
const data = reactive({
  params: {
    search: props.filters.search,
    field: props.filters.field,
    order: props.filters.order,
    perPage: props.perPage,
  },
  externalMail: null,
  followUpTypes: null,
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

      router.get(route("external-mail-forwarding.index"), param, {
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
  <Head title="Lembar Penerus Surat Masuk Eksternal"/>
  <AuthenticatedLayout>
    <div class="flex flex-wrap -mx-3">
      <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
        <div
            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border">
          <div class="text-xl font-bold px-3 py-4">
            Lembar Penerus Surat Masuk Eksternal
          </div>
          <div class="flex flex-row my-6 justify-between items-center px-6 pb-0 mb-0 rounded-t-2xl">
            <div class="flex items-center space-x-2">
              <SelectInput
                  class="w-15 h-10 text-sm"
                  v-model="data.params.perPage"
                  :dataSet="data.dataSet"
              />
              <!-- <h5 class="dark:text-white">User table</h5> -->
              <SearchBar v-model="data.params.search"/>
            </div>
          </div>
          <div class="flex-auto px-5 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
              <table
                  class="items-center w-full mb-5 align-top border-collapse dark:border-white/40 text-slate-500">
                <thead class="align-bottom">
                <tr>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 cursor-pointer"
                      @click="order('agenda_number')">
                    Nomor Agenda
                    <i v-show="data.params.field ==='agenda_number' && data.params.order === 'asc'"
                       class="fas fa-angle-up ms-3"
                    ></i>
                    <i v-show="data.params.field === 'agenda_number' && data.params.order === 'desc'"
                       class="fas fa-angle-down ms-3"
                    ></i>
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 cursor-pointer"
                      @click="order('letter_number')">
                    Nomor Surat
                    <i v-show="data.params.field ==='letter_number' && data.params.order === 'asc'"
                       class="fas fa-angle-up ms-3"
                    ></i>
                    <i v-show="data.params.field === 'letter_number' && data.params.order === 'desc'"
                       class="fas fa-angle-down ms-3"
                    ></i>
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 cursor-pointer"
                      @click="order('letter_date')">
                    Tanggal Surat
                    <i v-show="data.params.field ==='letter_date' && data.params.order === 'asc'"
                       class="fas fa-angle-up ms-3"
                    ></i>
                    <i v-show="data.params.field === 'letter_date' && data.params.order === 'desc'"
                       class="fas fa-angle-down ms-3"
                    ></i>
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    Perihal
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    Dari Internal
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    Dari Eksternal
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    File PDF
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    Aksi
                  </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(externalMail, index) in props.externalMail.data" :key="index"
                    class="border-b dark:border-slate-400 last:border-0">
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent text-center">
                    <span class="text-sm">{{ externalMail.agenda_number }}</span>
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <span class="text-sm">{{ externalMail.letter_number }}</span>
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <span class="text-sm">{{ externalMail.letter_date }}</span>
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <span class="text-sm">{{ externalMail.subject }}</span>
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <span class="text-sm">{{ externalMail.from_user }}</span>
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent text-center">
                    <span class="text-sm">{{ externalMail.from_ext }}</span>
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <ViewFile :file_pdf="externalMail.file_pdf"/>
                  </td>
                  <td>
                    <template v-if="externalMail.status == '0'">
                      <Disposisi :externalMail="externalMail" :followUpTypes="followUpTypes"
                                 :userDepartment="userDepartment"/>
                    </template>
                    <template v-else>
                      <a target="_blank"
                         :href="route('export.externalMailDisposition', [externalMail.id])"
                         class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-cyan-500 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md">
                        <font-awesome-icon :icon="['fas', 'magnifying-glass']"/>
                        Lihat Disposisi
                      </a>
                    </template>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>