<script setup>
import { ref, onMounted, watch } from 'vue';
import GuestLayout from './GuestLayout.vue';
import axios from 'axios';

const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

const impact = ref(null);

const props = defineProps({
    id: {
        type: String,
        required: true
    }
});

watch(() => props.id, fetchData);

async function fetchData() {
    try {
        const res = await axios.get(`${apiBaseUrl}/impacts/${props.id}`);

        if (res.data) {
            impact.value = res.data || 0;
        }

    } catch (err) {
        impact.value = null; // Clear any old data
    }
}
onMounted(fetchData);

</script>

<template>
    <GuestLayout>
        <Hero>
            <div v-if="impact" class="z-10">
                <h1 class="title font-bold mb-5 text-text-sec ">{{ impact.title }}</h1>
                <p class="date p-[10px] text-sm text-gray">{{ impact.created_at }}</p>
            </div>
            <a @click="$router.push('/impacts')"
                class="back cursor-pointer z-[1] no-underline text-text-sec mt-8">&lArr; Back to impacts
                list</a>
        </Hero>

        <section v-if="impact" class="news-details leading-10 text-justify m-8 text-text-main">
            <img :src="impact.image" :alt="impact.image" class="mx-auto mb-28 w-7xl h-56 object-cover rounded-lg" />
            {{ impact.content }}
        </section>
    </GuestLayout>

</template>
