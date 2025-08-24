<script setup lang="ts">
import Footer from '@/components/Footer.vue';
import Header from '@/components/Header.vue';

</script>

<template>
    <Header />
    <slot class="max-w-7xl" />
    <Footer />
</template>
