<script>
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import DetailsModal from '@/components/Dashboard/DetailsModal.vue';

export default {
    components: {
        PrimaryBtn
    },
    props: {
        user: {
            type: Object,
            required: true
        }
    }
}
</script>

<template>
    <DetailsModal>
        <h1 class="text-2xl font-bold m-4 text-text-main">User : {{ user.name }}</h1>
        <div class="grid grid-cols-1 md:grid-cols-5 text-text-main items-center">
            <p class="rounded-md p-2 pb-0 m-1 font-bold md:text-end">Username :</p>
            <span class="rounded-md bg-primary/20 p-2 m-1 w-60"> {{ user.name }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 text-text-main items-center">
            <p class="rounded-md p-2 pb-0 m-1 font-bold md:text-end">Email :</p>
            <span class="rounded-md bg-primary/20 p-2 m-1 w-60"> {{ user.email }}</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-5 text-text-main items-center">
            <p class="rounded-md p-2 pb-0 m-1 font-bold md:text-end">Role :</p>
            <span class="rounded-md bg-primary/20 p-2 m-1 w-60"> {{ user.role }}</span>
        </div>
        <div class="flex justify-end">
            <PrimaryBtn @click="$emit('close')" name="Close" />
        </div>
    </DetailsModal>
</template>
