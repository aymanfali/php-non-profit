<script>
import Pagination from './Pagination.vue';

export default {
    components: {
        Pagination
    },
    data() {
        return {
            news: [],
            currentPage: 1,
            itemsPerPage: 6
        }
    },
    created() {
        this.loadNews();
    },
    computed: {
        totalPages() {
            return Math.ceil(this.news.length / this.itemsPerPage);
        },
        paginatedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.news.slice(start, end);
        }
    },
    methods: {
        loadNews() {
            const savedNews = localStorage.getItem('news');
            if (savedNews) {
                this.news = JSON.parse(savedNews);
            }
        },
        goToNewsDetail(newsId) {
            this.$router.push({ name: 'NewsDetails', params: { id: newsId } });
        },
        handlePageChange(page) {
            this.currentPage = page;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
}
</script>

<template>
    <div class="news m-5 md:mx-28 text-text-main">
        <div v-for="(item, index) in paginatedItems" :key="item.id" @click="goToNewsDetail(item.id)"
            class="m-[20px_10px] p-[10px] rounded-[15px] flex flex-col md:flex-row-reverse justify-between items-center shadow-md hover:text-horizontal-line cursor-pointer">
            <img class="rounded-lg h-52 w-full md:w-80 object-cover" :src="item.image" :alt="item.title" />
            <div class="p-[10px] flex flex-col w-full">
                <p>{{ item.title }}</p>
                <span class="p-[10px] text-sm text-color-gray">{{ item.date }}</span>
                <a class="text-end text-md">Read more ...</a>
            </div>
        </div>

        <Pagination v-if="news.length > itemsPerPage" :current-page="currentPage" :total-pages="totalPages"
            @page-changed="handlePageChange" />

    </div>
</template>
