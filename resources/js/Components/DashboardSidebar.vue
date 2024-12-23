<script setup>
import {Link, usePage} from "@inertiajs/vue3";
import {computed, ref} from "vue";
import NavLink from "./NavLink.vue";
// import SidebarNav from "@/Components/SidebarNavigation/SidebarNav.vue";
import PrimaryDropdown from "@/Components/SidebarNavigation/PrimaryDropdown.vue";

loadJS(to_build + "assets/pro/js/sidenav.js", true);
const isExpanded = ref(false);

// Handle the event emitted by the PrimaryDropdown
const handleIsExpandedChange = (newValue) => {
  isExpanded.value = newValue;
};
const typesData = usePage().props.links;

const links_outgoing = typesData.map((type) => {
  const result = {
    title: type.name,
    href: "#",
    isActive: false,
  };
  if (type.sub_types.length > 0) {
    result.subLinks = type.sub_types.map((subType) => ({
      title: subType.name,
      href: `/outgoing-mail/${subType.id}`,
      isActive: false,
      id: subType.id,
    }));
  }

  return result;
});

const links_ingoing = typesData.map((type) => {
  const result = {
    title: type.name,
    href: "#",
    isActive: false,
  };
  if (type.sub_types.length > 0) {
    result.subLinks = type.sub_types.map((subType) => ({
      title: subType.name,
      href: `/incoming-mail/${subType.id}`,
      isActive: false,
    }));
  }

  return result;
});

const isMobileSidebar = defineModel("isMobileSidebar", {
  type: Boolean,
  default: false,
});

const handleSidebarClose = () => {
  isMobileSidebar.value = !isMobileSidebar.value;
};

const classes = computed(() =>
    isMobileSidebar.value
        ? "xl:ml-6 ps translate-x-0 ml-6"
        : "shadow-xl xl:ml-6"
);
</script>

<template>
  <!-- sidenav  -->
  <aside mini="false"
         class="fixed inset-y-0 left-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto transition-all duration-200 ease-in-out -translate-x-full bg-white border-0 shadow-none xl:ml-6 dark:bg-slate-850 z-990 max-w-64 rounded-2xl xl:translate-x-0"
         id="sidenav-main">
    <div class="h-auto">
      <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden"
         @click="handleSidebarClose"></i>
      <NavLink
          :href="route('dashboard')"
          target="_blank"
          class="flex flex-col items-center justify-center mb-10 mt-3">
        <img src="/assets/img/logo-recos.png"
             class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-14"
             alt="main_logo"/>

        <img src="/assets/img/logo-recos.png"
             class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-14"
             alt="main_logo"/>
        <div class="ml-1 mt-5 font-semibold text-center text-xs transition-all duration-200 ease-nav-brand">
          RECOS (Rolas E-Correspondence System)
        </div>
      </NavLink>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent"/>

    <div class="items-center block w-full h-auto grow basis-full" id="sidenav-collapse-main">
      <ul class="flex flex-col pl-0 mb-0 list-none">
        <li class="mt-0.5 w-full">
          <NavLink :active="$page.url.startsWith('/dashboard') || $page.url === '/'" :href="route('dashboard')">
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <font-awesome-icon :icon="['fas', 'home']" class="relative top-0 text-sm leading-normal text-blue-700"/>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
          </NavLink>
        </li>
        <li class="w-full mt-4">
          <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">
            Master Data
          </h6>
        </li>

        <li class="mt-0.5 w-full">
          <NavLink :active="$page.url.startsWith('/unit')" :href="route('unit.index')" v-show="can(['delete unit'])">
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <font-awesome-icon :icon="['fas', 'building']"
                                 class="relative top-0 text-sm leading-normal text-blue-700"/>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Unit</span>
          </NavLink>

          <NavLink :active="$page.url.startsWith('/type')" :href="route('type.index')" v-show="can(['delete type'])">
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <font-awesome-icon :icon="['fas', 'list']" class="relative top-0 text-sm leading-normal text-blue-700"/>
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Tipe Surat</span>
          </NavLink>
        </li>

        <!-- <li class="mt-2 w-full"> -->

        <li class="w-full mt-4">
          <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">
            Manajemen Persuratan
          </h6>
        </li>

        <li class="mt-0.5 w-full">

          <PrimaryDropdown
              title="Surat Masuk"
              iconClass="envelope"
              :links="links_ingoing"
              :isActive="$page.url.startsWith('/incoming-mail')"
          />

          <PrimaryDropdown
              title="Surat Keluar"
              class="mt-2"
              iconClass="paper-plane"
              :links="links_outgoing"
              :isActive="$page.url.startsWith('/outgoing-mail')"
              @update:isExpanded="handleIsExpandedChange"
          />

          <NavLink
              :active="$page.url == '/external-mail'"
              :href="route('external-mail.index')">
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <font-awesome-icon
                  :icon="['fas', 'truck-fast']"
                  class="relative top-0 text-sm leading-normal text-blue-700"
              />
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Surat Masuk Eksternal</span>
          </NavLink>
          <NavLink
              :active="$page.url.startsWith('/external-mail-forwarding')"
              :href="route('external-mail-forwarding.index')">
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
              <font-awesome-icon
                  :icon="['fas', 'fa-share-from-square']"
                  class="relative top-0 text-sm leading-normal text-blue-700"
              />
            </div>
            <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Lembar Penerus Eksternal</span>
          </NavLink>
        </li>

        <!-- </li> -->

        <li class="w-full mt-4">
          <h6
              class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60"
          >
            Manajemen User
          </h6>
        </li>

        <li class="mt-0.5 w-full">
          <NavLink
              :active="$page.url.startsWith('/user')"
              :href="route('user.index')"
              v-show="can(['delete user'])"
          >
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"
            >
              <font-awesome-icon
                  :icon="['fas', 'users']"
                  class="relative top-0 text-sm leading-normal text-blue-700"
              />
            </div>
            <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease"
            >Users</span
            >
          </NavLink>
        </li>
        <li class="mt-0.5 w-full">
          <NavLink
              :active="$page.url.startsWith('/profile')"
              :href="route('profile.edit')"
          >
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"
            >
              <font-awesome-icon
                  :icon="['fas', 'user']"
                  class="relative top-0 text-sm leading-normal text-blue-700"
              />
            </div>
            <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease"
            >Profile</span
            >
          </NavLink>
        </li>

        <li class="mt-0.5 w-full">
          <Link
              method="POST"
              as="button"
              class="dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors"
              :href="route('logout')"
          >
            <div
                class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5"
            >
              <font-awesome-icon
                  :icon="['fas', 'right-from-bracket']"
                  class="relative top-0 text-sm leading-normal text-red-700"
              />
            </div>
            <span
                class="ml-1 duration-300 opacity-100 pointer-events-none ease text-red-500"
            >Sign Out</span
            >
          </Link>
        </li>
      </ul>
    </div>
  </aside>

  <!-- end sidenav -->
</template>
