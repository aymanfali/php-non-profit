<script>
import GuestLayout from './GuestLayout.vue';

export default {
    props: ['id'],
    components: {
        GuestLayout,
    },
    data() {
        return {
            news: [],
            currentNews: {
                id: '',
                title: '',
                image: '',
                content: '',
                date: '',
            },
        }
    },
    created() {
        this.loadNewsData();
    },
    methods: {
        loadNewsData() {
            const savedNews = localStorage.getItem('news');
            if (savedNews) {
                this.news = JSON.parse(savedNews);
                this.currentNews = this.news.find(item => item.id === this.$route.params.id) || this.currentNews
            }
        },
    },
    computed: {
        item() {
            return this.currentNews.id ? this.currentNews : (this.news.find(item => item.id === this.$route.params.id) || {})
        }
    },
}
</script>

<template>
    <GuestLayout>
        <Hero>
            <h1 class="title font-bold mb-5 text-text-sec  z-10">{{ item.title }}</h1>
            <p class="date p-[10px] text-sm text-gray z-[1]">{{ item.date }}</p>
            <a @click="$router.push('/news')" class="back cursor-pointer z-[1] no-underline text-text-sec mt-8">&lArr; Back to news list</a>
        </Hero>

        <section class="news-details leading-10 text-justify m-8 text-text-main">
            {{ item.content }}
        </section>
    </GuestLayout>

</template>
