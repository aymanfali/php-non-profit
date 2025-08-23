<script setup>
import { ref, onMounted, watch } from 'vue';
import GuestLayout from './GuestLayout.vue';
import axios from 'axios';

const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

const about = ref(null);

const props = defineProps({
    id: {
        type: String,
        required: true
    }
});

watch(() => props.id, fetchData);

async function fetchData() {
    try {
        const res = await axios.get(`${apiBaseUrl}/about_us`);

        if (res.data) {
            about.value = res.data || 0;
        }

    } catch (err) {
        about.value = null; // Clear any old data
    }
}
onMounted(fetchData);

</script>

<template>
    <GuestLayout>
        <Hero>
            <h1 class="title font-bold mb-5 text-text-sec z-10">About Us</h1>
        </Hero>

        <section v-if="about" class="about-us p-5 text-text-main">
            <div class="our-history">
                <h2 class="title text-center m-8 font-bold text-3xl">Our history</h2>
                <div class="history flex flex-col justify-center items-center my-8 md:flex-row">
                    <img loading="lazy" :src="about.our_history_image" alt="history"
                        class="max-w-[350px] h-auto mx-auto rounded-[15px]">
                    <div class="description m-8 leading-relaxed">
                        <p>{{ about.our_history }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <div class="our-values">
                <h2 class="title text-center m-8 font-bold text-3xl">Our Values</h2>
                <div class="values flex flex-col justify-center items-center my-8 md:flex-row-reverse">
                    <img loading="lazy" :src="about.our_values_image" alt="values"
                        class="max-w-[350px] h-auto mx-auto rounded-[15px]">
                    <div class="description m-8 leading-relaxed">
                        <p>{{ about.our_values }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-8">
        </section>
        <section v-else>
            <p>Loading...</p>
        </section>
    </GuestLayout>
</template>
