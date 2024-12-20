<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {reactive, watch} from "vue";
import {cloneDeep, debounce, pickBy} from "lodash";
import SelectInput from "@/Components/SelectInput.vue";
import DeleteBulk from "@/Pages/OutgoingMail/DeleteBulk.vue";
import SearchBar from "@/Components/SearchBar.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Create from "@/Pages/ExternalMail/Create.vue";
import ViewFile from "@/Pages/ExternalMail/ViewFile.vue";
import BlueButton from "@/Components/BlueButton.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const page = usePage();
const props = defineProps({
  filters: Object,
  perPage: Number,
  externalMail: Object,
  externalTypes: Object,
  userDepartment: Object,
  priority: Object,
  classification: Object,
});
const data = reactive({
  params: {
    search: props.filters.search,
    field: props.filters.field,
    order: props.filters.order,
    perPage: props.perPage,
  },
  externalMail: null,
  externalTypes: null,
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

      router.get(route("external-mail.index"), param, {
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
  <Head title="Surat Masuk Eksternal"/>
  <AuthenticatedLayout>
    <div class="flex flex-wrap -mx-3">
      <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
        <div
            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border">
          <div class="text-xl font-bold px-3 py-4">
            Surat Masuk Eksternal
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

            <div>
              <DeleteBulk
                  v-if="data.selectedId.length != 0 && can(['delete outgoing_mail'])"
                  :selectedId="data.selectedId"
              />
              <Create
                  :priority="props.priority"
                  :classification="props.classification"
                  :externalTypes="props.externalTypes"
                  :userDepartment="props.userDepartment"
              />
            </div>
          </div>
          <div class="flex-auto px-5 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
              <table
                  class="items-center w-full mb-5 align-top border-collapse dark:border-white/40 text-slate-500">
                <thead class="align-bottom">
                <tr>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    <Checkbox
                        class="p-2 dark:border-slate-400"
                        v-model:checked="data.isMultiple"
                        @change="selectAll"
                    />
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
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
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
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
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
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
                  <td class="px-6 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <input
                        class="rounded p-2 dark:bg-slate-900 dark:border-slate-700 text-primary dark:text-primary focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                        type="checkbox"
                        @change="select"
                        :value="externalMail.id"
                        v-model="data.selectedId"
                    />
                  </td>
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
                    <BlueButton>
                      <font-awesome-icon :icon="['fas', 'magnifying-glass']"/>
                      Disposisi
                    </BlueButton>
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