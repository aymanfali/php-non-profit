<script setup>
import TheNews from '@/components/TheNews.vue';
import GuestLayout from './GuestLayout.vue';
</script>

<template>
    <GuestLayout>
        <Hero>
            <h1 class="title font-bold mb-5 text-text-sec  z-10">UNESCO News</h1>
        </Hero>
        <TheNews />
    </GuestLayout>
</template>
