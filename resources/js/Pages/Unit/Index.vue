<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Head, router, usePage} from "@inertiajs/vue3";
import {reactive, watch} from "vue";
import {cloneDeep, debounce, pickBy} from "lodash";
import Create from "@/Pages/Unit/Create.vue";
import Edit from "@/Pages/Unit/Edit.vue";
import Delete from "@/Pages/Unit/Delete.vue";
import DeleteBulk from "@/Pages/Unit/DeleteBulk.vue";
import SearchBar from "@/Components/SearchBar.vue";
import SelectInput from "@/Components/SelectInput.vue";
import Checkbox from "@/Components/Checkbox.vue";
import Pagination from "@/Components/Pagination.vue";

const page = usePage();
const props = defineProps({
  filters: Object,
  perPage: Number,
  units: Object,
  unitParents: Object,
  listFuncDep: Object,
  listBod: Object,
  listUnit: Object,
  listParent: Object,
});

const data = reactive({
  params: {
    search: props.filters.search,
    field: props.filters.field,
    order: props.filters.order,
    perPage: props.perPage,
  },
  unit: null,
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

      router.get(route("unit.index"), param, {
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
    props.units?.data.forEach((unit) => {
      data.selectedId.push(unit.id);
    });
  }
};

const select = () => {
  if (props.units?.data.length == data.selectedId.length) {
    data.isMultiple = true;
  } else {
    data.isMultiple = false;
  }
};
</script>
<template>
  <Head title="Unit List"/>

  <AuthenticatedLayout>
    <div class="flex flex-wrap -mx-3">
      <div class="mx-auto w-full sm:px-6 lg:px-8 space-y-6 py-12">
        <div
            class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-lg bg-clip-border">
          <div
              class="flex flex-row my-6 justify-between items-center px-6 pb-0 mb-0 rounded-t-2xl">
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
                  v-if="data.selectedId.length != 0 && can(['delete unit'])"
                  :selectedId="data.selectedId"
              />
              <Create v-else :listParent="props.listParent" :listBod="props.listBod" :listFuncDep="props.listFuncDep"
                      :listUnit="props.listUnit"/>
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
                  <th
                      class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('title')">
                    Name
                    <i
                        v-show="data.params.field ==='title' && data.params.order === 'asc'"
                        class="fas fa-angle-up ms-3"
                    ></i>
                    <i v-show="data.params.field === 'title' && data.params.order === 'desc'"
                       class="fas fa-angle-down ms-3"
                    ></i>
                  </th>
                  <th
                      class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('functiondep_id')">
                    Function Department
                  </th>
                  <th
                      class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('unit_id')">
                    Unit
                  </th>
                  <th
                      class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('kode_organisasi')">
                    Kode Organisasi
                  </th>
                  <th
                      class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('level')">
                    Bod
                    <i v-show="data.params.field === 'level' && data.params.order === 'asc'"
                       class="fas fa-angle-up ms-3"
                    ></i>
                    <i v-show="data.params.field === 'level' && data.params.order === 'desc'"
                       class="fas fa-angle-down ms-3"
                    ></i>
                  </th>

                  <th class="px-6 py-3 pl-2 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('parent_id')">
                    Parent Unit
                  </th>
                  <th
                      class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70"
                      @click="order('created_at')">
                    Created AT
                    <i
                        v-show="data.params.field === 'created_at' && data.params.order === 'asc'"
                        class="fas fa-angle-up ms-3"
                    ></i>
                    <i
                        v-show="data.params.field === 'created_at' && data.params.order === 'desc'"
                        class="fas fa-angle-down ms-3"
                    ></i>
                  </th>

                  <th
                      class="px-6 py-3 font-semibold capitalize align-middle bg-transparent border-b border-collapse border-solid shadow-none dark:border-white/40 dark:text-white tracking-none whitespace-nowrap text-slate-400 opacity-70"
                  ></th>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="(unit, index) in props.units
                                            .data"
                    :key="index"
                    class="border-b dark:border-slate-400 last:border-0">
                  <td
                      class="px-6 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <input
                        class="rounded p-2 dark:bg-slate-900 dark:border-slate-700 text-primary dark:text-primary focus:ring-primary/80 dark:focus:ring-primary dark:focus:ring-offset-slate-800 dark:checked:bg-primary dark:checked:border-primary"
                        type="checkbox"
                        @change="select"
                        :value="unit.id"
                        v-model="data.selectedId"
                    />
                  </td>
                  <td class="py-2 pr-12 align-middle bg-transparent dark:border-0 whitespace-nowrap shadow-transparent">
                    <div class="flex px-2 py-1">
                      <div class="flex flex-col justify-center">
                        <h6
                            class="mb-0 text-sm leading-normal dark:text-white">
                          {{ unit.title }}
                        </h6>
                      </div>
                    </div>
                  </td>
                  <td
                      class="p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    <p
                        class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                      {{ unit.functiondep.title }}
                    </p>
                  </td>
                  <td
                      class="p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    <p
                        class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                      {{ unit.unit.title }}
                    </p>
                  </td>
                  <td class="p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                      {{ unit.kode_organisasi }}
                    </p>
                  </td>

                  <td class="p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                      {{ unit.bod.title }}
                    </p>
                  </td>
                  <td class="p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent text-sm">
                    <p
                        class="mb-0 text-xs py-1.5 px-2 text-slate-600 text-center font-semibold leading-tight dark:text-white dark:opacity-80 rounded-lg"
                        :class="unit.parentdep ? 'border-collapse border-green-400 border text-green-400' : 'border-collapse border-red-500 border text-red-400'">
                      <i
                          :class="unit.parentdep ? 'fa fa-building' : '-'"
                      ></i>
                      {{ unit.parentdep ? unit.parentdep.title : '-' }}
                    </p>
                  </td>
                  <td class="p-2 text-xs leading-normal text-center align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    {{ unit.created_at }}
                  </td>
                  <td class="flex justify-center items-center p-2 align-middle bg-transparent whitespace-nowrap shadow-transparent">
                    <Edit
                        :unit="unit"
                        :listParent="props.listParent"
                        :listBod="props.listBod"
                        :listFuncDep="props.listFuncDep"
                        :listUnit="props.listUnit"
                    />
                    <Delete
                        :unit="unit"
                    />
                  </td>
                </tr>
                </tbody>
              </table>
              <Pagination
                  :links="props.units"
                  :filters="data.params"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
