<script setup>
import Create from "@/Pages/SubType/Create.vue";
import Edit from "@/Pages/SubType/Edit.vue";
import Delete from "@/Pages/SubType/Delete.vue";
import {reactive, ref, watch, watchEffect} from "vue";
import {cloneDeep, debounce, pickBy} from "lodash";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import SelectInput from "@/Components/SelectInput.vue";
import SearchBar from "@/Components/SearchBar.vue";
import DeleteBulk from "@/Pages/OutgoingMail/DeleteBulk.vue";
import Pagination from "@/Components/Pagination.vue";
import Checkbox from "@/Components/Checkbox.vue";

const isModalEditOpen = ref(false);

const page = usePage();
const props = defineProps({
  id: String,
  subTypes: Object,
  type: Object,
  filters: Object,
  perPage: Number,
  bod: Object,
});

const data = reactive({
  params: {
    search: props.filters.search,
    field: props.filters.field,
    order: props.filters.order,
    perPage: props.perPage,
  },
  subTypes: null,
  type: null,
  bod: null,
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

      router.get(route("type.show", [props.id]), param, {
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
const findBodById = (id) => {
  const result = props.bod.find((item) => String(item.id) === id);
  return result ? result.title : null;
};
</script>

<template>
  <Head :title="props.type.name"/>

  <AuthenticatedLayout>
    <div class="flex flex-wrap -mx-3">
      <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
        <div
            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border">
          <div class="text-xl font-bold px-3 py-4">
            <font-awesome-icon
                :icon="['fas', 'list']"
                class="mr-2"
            />
            {{ props.type.name }}
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
                  v-if="data.selectedId.length != 0 && can(['delete type'])"
                  :selectedId="data.selectedId"
              />
              <Create :type="props.type" :listBod="bod" v-else/>
            </div>
          </div>
          <div class="flex-auto px-5 pt-0 pb-2">
            <div class="p-0 overflow-x-auto">
              <table class="items-center w-full mb-5 align-top border-collapse dark:border-white/40 text-slate-500">
                <thead class="align-bottom">
                <tr>
                  <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    <Checkbox
                        class="p-2 dark:border-slate-400"
                        v-model:checked="data.isMultiple"
                        @change="selectAll"
                    />
                  </th>
                  <th class="py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('name')">
                    Name Sub Type
                  </th>
                  <th class="py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('letter_format')">
                    Format Nomor Surat
                  </th>
                  <th class="py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('form_type')">
                    Tipe Form
                  </th>
                  <th class="py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                    Sign Rule BOD
                  </th>
                  <th class="py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70 text-center">
                    Aksi
                  </th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="props.type.sub_types.length === 0">
                  <td
                      colspan="5"
                      rowspan="6"
                      class="text-center py-4 my-4 text-gray-500">
                    Data Sub Types Kosong
                  </td>
                </tr>
                <tr
                    v-else
                    v-for="(type, index) in props.type.sub_types"
                    :key="index"
                    class="border-b dark:border-slate-400 last:border-0">
                  <td class="px-6 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <input
                        class="rounded p-2 dark:bg-slate-900 dark:border-slate-700 text-primary dark:text-primary focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                        type="checkbox"
                        @change="select"
                        :value="type.id"
                        v-model="data.selectedId"
                    />
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <h6 class="mb-0 text-sm leading-normal dark:text-white">
                      {{ type.name }}
                    </h6>
                  </td>

                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <h6 class="mb-0 text-sm leading-normal dark:text-white">
                      {{ type.letter_format }}
                    </h6>
                  </td>

                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <h6 class="mb-0 text-sm leading-normal dark:text-white">
                      {{ type.form_type == 1 ? "Tipe Form 1 (tanpa content)" : "Tipe Form 2 (dengan content)" }}
                    </h6>
                  </td>

                  <td class="py-2 p r-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <h6
                        v-for="(id, index) in type.bod.split(',')"
                        :key="index"
                        class="mb-0 text-sm leading-normal dark:text-white">
                      {{ findBodById(id) || `Unknown ID: ${id}` }}
                    </h6>
                  </td>
                  <td class="flex gap-5 justify-center items-center p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    <Edit :type="type" :listBod="bod"/>
                    <Delete :type="type"/>
                  </td>
                </tr>
                </tbody>
              </table>
              <Pagination :links="props.subTypes" :filters="data.params"/>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
