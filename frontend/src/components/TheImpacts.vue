<script>
import Pagination from './Pagination.vue';

export default {
    props: {
        showLatestOnly: {
            type: Boolean,
            default: false
        },
        maxLatestItems: {
            type: Number,
            default: 3
        }
    },
    components: {
        Pagination
    },
    data() {
        return {
            items: [],
            currentPage: 1,
            itemsPerPage: 6
        }
    },
    created() {
        this.loadImpacts();
    },
    computed: {
        totalPages() {
            return Math.ceil(this.items.length / this.itemsPerPage);
        },
        paginatedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.items.slice(start, end);
        },
        latestItems() {
            // Return the newest items (assuming your items have a date or are added chronologically)
            return [...this.items].reverse().slice(0, this.maxLatestItems);
        },
        displayedItems() {
            return this.showLatestOnly ? this.latestItems : this.paginatedItems;
        },
        gridColumnsClass() {
            return this.showLatestOnly
                ? 'grid-cols-1 md:grid-cols-3'
                : 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3';
        }
    },
    methods: {
        loadImpacts() {
            const savedImpacts = localStorage.getItem('impacts');
            if (savedImpacts) {
                this.items = JSON.parse(savedImpacts);
            }
        },
        goToImpactDetail(impactId) {
            this.$router.push({ name: 'ImpactDetails', params: { id: impactId } });
        },
        handlePageChange(page) {
            this.currentPage = page;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}
</script>

<template>
    <div class="impact-activities-container">
        <div class="grid gap-5 m-5" :class="gridColumnsClass">
            <div v-for="(item, index) in displayedItems" :key="index" @click="goToImpactDetail(item.id)"
                class="rounded-2xl shadow-md hover:cursor-pointer transition-transform duration-300 hover:scale-105">
                <img :src="item.image" :alt="item.title" class="rounded-t-2xl w-full h-[300px] object-cover">
                <div class="p-5 text-text-main">
                    <h3 class="text-lg font-semibold mb-2">{{ item.title }}</h3>
                    <div class="text-right text-horizontal-line hover:underline">Read more...</div>
                </div>
            </div>
        </div>

        <Pagination v-if="!showLatestOnly && items.length > itemsPerPage" :current-page="currentPage"
            :total-pages="totalPages" @page-changed="handlePageChange" />
    </div>
</template>

<style scoped>
.impact-activities-container {
    max-width: 1200px;
    margin: 0 auto;
}
</style>
