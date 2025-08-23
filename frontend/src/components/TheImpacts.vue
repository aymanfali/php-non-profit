<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import Pagination from './Pagination.vue';
import axios from 'axios';

const props = defineProps({
    showLatestOnly: {
        type: Boolean,
        default: false
    },
    maxLatestItems: {
        type: Number,
        default: 3
    }
});

const router = useRouter();

const items = ref([]);
const currentPage = ref(1);
const itemsPerPage = 6;
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

async function fetchData() {
    try {
        const res = await axios.get(`${apiBaseUrl}/`);
        
        if (res.data) {
            items.value = res.data || 0;
        }

    } catch (err) {
        items.value = null; // Clear any old data
        toast.error('Failed to fetch dashboard data. Please try again.');
    }
}
onMounted(fetchData);

// Computed properties
const totalPages = computed(() => {
    return Math.ceil(items.value.length / itemsPerPage);
});

const paginatedItems = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage;
    const end = start + itemsPerPage;
    return items.value.slice(start, end);
});

const latestItems = computed(() => {
    return [...items.value].reverse().slice(0, props.maxLatestItems);
});

const displayedItems = computed(() => {
    return props.showLatestOnly ? latestItems.value : paginatedItems.value;
});

const gridColumnsClass = computed(() => {
    return props.showLatestOnly
        ? 'grid-cols-1 md:grid-cols-3'
        : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
});

// Methods
const goToImpactDetail = (impactId) => {
    router.push({ name: 'ImpactDetails', params: { id: impactId } });
};

const handlePageChange = (page) => {
    currentPage.value = page;
    window.scrollTo({ top: 0, behavior: 'smooth' });
};
</script>

<template>
    <div class="impact-activities-container">
        <div class="grid gap-5 m-5" :class="gridColumnsClass">
            <div v-for="item in displayedItems" :key="item.id" @click="goToImpactDetail(item.id)"
                class="rounded-2xl shadow-md hover:cursor-pointer transition-transform duration-300 hover:scale-105">
                <img :src="item.image" :alt="item.title" class="rounded-t-2xl w-full h-[300px] object-cover">
                <div class="p-5 text-text-main">
                    <h3 class="text-lg font-semibold mb-2">{{ item.title }}</h3>
                    <div class="text-right text-horizontal-line hover:underline">Read more...</div>
                </div>
            </div>
        </div>

        <Pagination v-if="!props.showLatestOnly && items.length > itemsPerPage" :current-page="currentPage"
            :total-pages="totalPages" @page-changed="handlePageChange" />
    </div>
</template>

<style scoped>
.impact-activities-container {
    max-width: 1200px;
    margin: 0 auto;
}
</style>
