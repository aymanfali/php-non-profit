<script setup>
import { ref, onMounted, watch } from 'vue';
import GuestLayout from './GuestLayout.vue';
import axios from 'axios';

const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

const news = ref(null);

const props = defineProps({
    id: {
        type: String,
        required: true
    }
});

watch(() => props.id, fetchData);

async function fetchData() {
    try {
        const res = await axios.get(`${apiBaseUrl}/news/${props.id}`);

        if (res.data) {
            news.value = res.data || 0;
        }

    } catch (err) {
        news.value = null; // Clear any old data
    }
}
onMounted(fetchData);

</script>


<template>
    <GuestLayout>
        <Hero>
            <div v-if="news" class="z-10">
                <h1 class="title font-bold mb-5 text-text-sec ">{{ news.title }}</h1>
                <p class="date p-[10px] text-sm text-gray">{{ news.created_at }}</p>
            </div>
            <a @click="$router.push('/news')"
                class="back cursor-pointer z-[1] no-underline text-text-sec mt-8">&lArr; Back to news
                list</a>
        </Hero>

        <section v-if="news" class="news-details leading-10 text-justify m-8 text-text-main">
            <img :src="news.image" :alt="news.image" class="mx-auto mb-28 w-7xl h-56 object-cover rounded-lg" />
            {{ news.content }}
        </section>
    </GuestLayout>
</template>
