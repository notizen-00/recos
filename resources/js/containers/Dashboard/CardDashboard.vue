<script setup></script>

<template>
  <div
    class="dark:bg-slate-850 bg-white overflow-hidden shadow-sm sm:rounded-lg"
  >
    <div class="px-6 py-5 dark:text-slate-200 text-gray-900 flex justify-start">
      <img
        width="50"
        src="assets/img/user-icon.png"
        class="rounded-xl max-h-14"
      />
      <div>
        <h1 class="text-xl font-semibold mx-4 dark:text-slate-200">
          Hai , {{ $page.props.auth.user.name }} --
          <i class="fas fa-building text-xs ml-1 text-blue-300"></i>
          <span
            class="font-semibold border-2 px-2 text-blue-600 dark:text-slate-200 dark:border-slate-400 text-sm rounded-xl border-blue-500"
          >
            {{ $page.props.auth.user.roles[0].name }}
          </span>
        </h1>

        <p class="mx-4 text-xs text-slate-400">
          Login as
          <span class="text-blue-400 ml-1 text-sm">{{
            $page.props.auth.detail_department.title
          }}</span>
        </p>
      </div>
    </div>
    <div class="flex justify-between w-full">
      <p class="p-4">
        Unit : {{ $page.props.auth.detail_department.unit.title }} <br />
        BOD :
        {{ $page.props.auth.detail_department.bod.title }}
      </p>
      <p class="p-4"></p>
    </div>
    <div class="p-6 dark:text-slate-200 text-gray-900"></div>
  </div>
</template>
