<script setup>
import {computed, ref} from 'vue';
import {usePage} from '@inertiajs/vue3';
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
  title: {
    type: String,
    required: true
  },
  icon: {
    type: String,
    required: true
  },
  items: {
    type: Array,
    default: () => []
  }
});

const page = usePage();

// Check if a route is currently active
const isRouteActive = (routeName) => {
  // Handle patterns like 'dashboard.*'
  if (routeName.endsWith('.*')) {
    const baseRoute = routeName.slice(0, -2);
    return route().current().startsWith(baseRoute);
  }
  // Exact route match
  return route().current(routeName);
};

// Check if an item is active
const isItemActive = (item) => {
  if (item.type === 'link') {
    return isRouteActive(item.route);
  }
  if (item.type === 'submenu' && item.items) {
    return item.items.some(subItem => isRouteActive(subItem.route));
  }
  return false;
};

// Determine if the parent has any active child
const hasActiveChild = computed(() => {
  return props.items.some(item => isItemActive(item));
});

// Determine if the parent itself is active (via child or other logic)
const isParentActive = computed(() => {
  return props.items.some(item => {
    if (item.type === 'submenu' && item.items) {
      return item.items.some(subItem => isRouteActive(subItem.route));
    }
    return false;
  });
});

// Overall active status
const isActive = computed(() => {
  return hasActiveChild.value || isParentActive.value;
});

// Expand state
const isExpanded = ref(isActive.value);
const isParentExpanded = ref(isParentActive.value);

// Toggle expand state
const toggleExpand = () => {
  isExpanded.value = !isExpanded.value;
};

// Classes for parent item
const baseClasses = [
  'after:ease-in-out',
  'after:font-awesome-5-free',
  'ease-in-out',
  'text-sm',
  'leading-default',
  'py-2.7',
  'my-0',
  'mx-2',
  'flex',
  'items-center',
  'whitespace-nowrap',
  'rounded-lg',
  'px-4',
  'font-semibold',
  'transition-all',
  'after:ml-auto',
  'after:inline-block',
  'after:font-bold',
  'after:transition-all',
  'after:duration-200',
  'after:content-["\\f107"]'
];

const activeClasses = computed(() => [
  ...baseClasses,
  isActive.value ? 'bg-blue-500/30 text-slate-700 dark:text-white' : 'text-slate-700/50 dark:text-white/50'
]);

const submenuClasses = computed(() => [
  'ease-in-out',
  'py-2.7',
  'ml-5.4',
  'pl-4',
  'leading-default',
  'text-sm',
  'relative',
  'my-0',
  'mr-2',
  'flex',
  'items-center',
  'whitespace-nowrap',
  'bg-transparent',
  'pr-4',
  'font-medium',
  'after:ml-auto',
  'after:inline-block',
  'after:font-bold',
  'after:transition-all',
  'after:duration-200',
  'after:content-["\\f107"]'
]);
</script>

<template>
  <li class="mt-0.5 w-full">
    <!-- Primary Menu Item -->
    <a collapse_trigger="primary"
       href="javascript:"
       @click="toggleExpand"
       :class="activeClasses"
       :aria-expanded="!isExpanded"
    >
      <!-- Icon Container -->
      <div
          class="stroke-none flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current p-2.5 text-center text-black">
        <i :class="['text-sm leading-normal text-blue-500', icon]"></i>
      </div>

      <!-- Title -->
      <span class="ml-1 duration-300 opacity-100 pointer-events-none ease text-slate-700 dark:text-white">
        {{ title }}
      </span>
    </a>

    <!-- Dropdown Content -->
    <div
        class="h-auto overflow-hidden transition-all duration-200 ease-in-out"
        :class="{ 'max-h-0': !isExpanded }"
    >
      <ul class="flex flex-wrap mb-0 ml-6 list-none transition-all duration-200 ease-in-out">
        <li v-for="item in items" :key="item.name" class="w-full">
          <template v-if="item.type === 'link'">
            <NavLink
                :href="route(item.route)"
                :active="isRouteActive(item.route)"
                :name="item.name"
            />
          </template>

          <template v-else-if="item.type === 'submenu'">
            <!-- Nested Submenu -->
            <a collapse_trigger="secondary"
               href="javascript:"
               :class="[
                ...submenuClasses,
                isItemActive(item) ? 'text-slate-800 dark:text-white' : 'text-slate-800/50 dark:text-white/60'
              ]"
               :aria-expanded="isParentExpanded"
            >
              <span class="w-0 text-center transition-all duration-200 ease-in-out opacity-0 pointer-events-none">
                {{ item.name.charAt(0) }}
              </span>
              <span class="transition-all duration-100 pointer-events-none ease">
                {{ item.name }}
              </span>
            </a>

            <!-- Nested Items -->
            <div v-if="item.items" class="h-auto overflow-hidden transition-all duration-200 ease-in-out max-h-0">
              <ul class="flex flex-col flex-wrap pl-0 mb-0 list-none transition-all duration-200 ease-in-out">
                <li v-for="subItem in item.items" :key="subItem.name" class="w-full">
                  <NavLink
                      :href="route(subItem.route)"
                      :active="isRouteActive(subItem.route)"
                      :name="subItem.name"
                  />
                </li>
              </ul>
            </div>
          </template>
        </li>
      </ul>
    </div>
  </li>
</template>