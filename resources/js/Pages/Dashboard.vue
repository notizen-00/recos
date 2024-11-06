<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-1">
            <div class="w-10/12 mx-auto">
                <div
                    class="dark:bg-slate-850 bg-white overflow-hidden shadow-sm sm:rounded-lg"
                >
                    <div
                        class="px-6 py-5 dark:text-slate-200 text-gray-900 flex justify-start"
                    >
                        <img
                            width="50"
                            src="assets/img/user-icon.png"
                            class="rounded-xl max-h-14"
                        />
                        <div>
                            <h1 class="text-xl font-semibold mx-4">
                                Hai , {{ $page.props.auth.user.name }}
                            </h1>

                            <p class="mx-4">
                                You are logged in as a
                                <span class="font-semibold">
                                    {{ $page.props.auth.user.role }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="p-6 dark:text-slate-200 text-gray-900">
                        User
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
