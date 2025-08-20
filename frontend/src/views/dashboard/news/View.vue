<script>
import PrimaryBtn from '@/components/Dashboard/Buttons/PrimaryBtn.vue';
import DetailsModal from '@/components/Dashboard/DetailsModal.vue';

export default {
    components: {
        PrimaryBtn
    },
    props: {
        news: {
            type: Object,
            required: true
        }
    }
}
</script>

<template>
    <DetailsModal>
        <div class="flex justify-between items-start mb-4">
            <h2 class="text-xl font-bold">{{ news.title }}</h2>

            <button @click="$emit('close')" class="text-gray hover:text-gray/70">
                ✕
            </button>
        </div>

        <div class="mb-4">
            <img :src="news.image" :alt="news.title" class="w-full h-64 object-contain">
        </div>
        <div class="mb-4">
            <p class="text-justify">{{ news.content }}</p>
        </div>

        <div class="flex justify-end">
            <PrimaryBtn @click="$emit('close')" name="Close" />
        </div>
    </DetailsModal>
</template>
