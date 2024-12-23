<script setup>
import {ref, watch} from "vue";
import SecondaryDropdown from "./SecondaryDropdown.vue";
import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  iconClass: {
    type: String,
    default: "",
  },
  links: {
    type: Array,
    default: () => [],
  },
  isActive: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:isExpanded"]);

const isExpanded = ref(props.isActive);
const subMenuHeight = ref(0);
const subMenus = ref(null);

const toggleMenu = () => {
  if (!subMenus.value) return;
  isExpanded.value = !isExpanded.value;
  subMenuHeight.value = isExpanded.value ? subMenus.value.scrollHeight : 0;
};
watch(
    () => props.isActive,
    (newValue) => {
      console.log(newValue);
      isExpanded.value = newValue;
    }
);

watch(isExpanded, (newValue) => {
  console.log("update baryu");
  emit("update:isExpanded", newValue);
});
</script>

<template>
  <div>
    <a collapse_trigger="primary" href="javascript:" @click.prevent="toggleMenu"
       :class="['ease-in-out text-sm py-2.7  px-5 mx-2 flex items-center rounded-lg transition-all', isExpanded ? 'text-slate-900 bg-blue-500/50 font-bold' : 'after:text-slate-800/50','dark:text-white dark:opacity-80']">
      <div v-if="iconClass" class="flex h-8 w-8 items-center justify-center rounded-lg text-center">
        <font-awesome-icon
            :icon="['fas', iconClass]"
            class="relative top-0 text-sm leading-normal text-blue-700"
        />
      </div>

      <span class="ml-1 text-slate-700 dark:text-white">
                {{ title }}
            </span>

      <i class="ml-auto fas text-sm transition-transform duration-200 ease-in-out"
         :class="[isExpanded ? 'fa-arrow-up' : 'fa-arrow-down']">
      </i>
    </a>

    <div
        ref="subMenus"
        :style="{ minHeight: isExpanded ? 'auto' : '0px' }"
        class="overflow-hidden transition-all duration-300 ease-in-out"
    >
      <ul class="list-none">
        <li v-for="(link, index) in links" :key="index">
          <SecondaryDropdown
              v-if="link.subLinks"
              :title="link.title"
              :iconClass="link.iconClass"
              :links="link.subLinks"
              :isActive="link.Active"
              :parentIsExpanded="isExpanded"
          />
          <a
              v-else
              :href="link.href"
              :class="[
                            'py-2.7 pl-6 flex mx-2 items-center text-sm text-slate-600 transition-all',
                            link.isActive
                                ? 'text-slate-900 dark:text-white font-semibold'
                                : 'text-slate-700 dark:text-white/50',
                        ]"
          >
            {{ link.title }}
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>
