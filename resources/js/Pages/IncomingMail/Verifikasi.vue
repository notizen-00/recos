<script setup>
import Confirm from "@/containers/Verifikasi/Confirm.vue";
import Review from "@/containers/Verifikasi/Review.vue";
import { useForm } from "@inertiajs/vue3";
import { ref, watchEffect } from "vue";
import { usePage } from "@inertiajs/vue3";
import { getParentDepartmentHirarki } from "@/services/hirarki";

const isModalEditOpen = ref(false);

const props = defineProps({
    outgoing_mail: Object,
    user_department: Object,
});

const isConfirm = props.outgoing_mail.full_number
    ? true
    : props.outgoing_mail.tracking_outgoing_mails[0].to.id ==
      props.outgoing_mail.sign_user_id;

const isDone = props.outgoing_mail.tracking_outgoing_mails[0].status != 2;
</script>

<template>
    <Confirm
        v-if="isConfirm && isDone"
        :outgoing_mail="props.outgoing_mail"
        :user_department="props.user_department"
    />

    <Review
        v-else-if="isDone"
        :outgoing_mail="props.outgoing_mail"
        :user_department="props.user_department"
    />
</template>
