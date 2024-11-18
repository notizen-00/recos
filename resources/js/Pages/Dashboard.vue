<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import CardDashboard from "@/containers/Dashboard/CardDashboard.vue";

const page = usePage();

console.log(page.props);
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
                <CardDashboard></CardDashboard>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
