<script setup>
import ContactForm from '@/components/Forms/ContactForm.vue';
import GuestLayout from './GuestLayout.vue';
</script>

<template>
    <GuestLayout>
        <Hero>
            <h1 class="title font-bold mb-5 text-text-sec z-10">Contact Us</h1>
        </Hero>

        <section class="contact m-[0_15%] p-5 flex justify-center flex-col" id="contact-us">
            <ContactForm />
        </section>
    </GuestLayout>
</template>

