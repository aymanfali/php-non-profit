<script setup>
import TheImpacts from '@/components/TheImpacts.vue';
import GuestLayout from './GuestLayout.vue';
import TheNews from '@/components/TheNews.vue';
</script>

<template>
    <GuestLayout>
        <Hero>
            <h1 class="title font-bold mb-5 text-text-sec  z-10">Welcom to UNESCO's official website</h1>

            <p class="description text-text-sec z-10">New World Heritage sites nominated; others removed from the
                in-danger
                list
            </p>
            <RouterLink to="/about-us"
                class="call-to-action border-0 outline-0 shadow-2xl py-3 px-4 m-5 bg-primary text-text-sec z-[1] rounded-[15px] cursor-pointer hover:bg-text-sec hover:text-primary hover:outline-2">
                Get
                to Know us</RouterLink>
        </Hero>

        <section class="intro p-3 relative">
            <h1 class="text-2xl font-bold mb-5 z-[1] text-center m-12 relative text-text-main">
                UNESCO Introduction
            </h1>
            <div class="description text-text-main leading-[1.5]">
                <p>
                    UNESCO is the United Nations organization that promotes cooperation in education, science, culture
                    and communication to
                    foster peace worldwide.
                </p>

                <p>
                    The Organization provides key services for its Member States,setting global norms and standards,
                    developing tools for international cooperation, producing knowledge for public policies and building
                    global networks of sites and institutions inscribed on its lists.
                </p>
            </div>
        </section>

        <div class="mx-auto my-5 w-52 border border-b-horizontal-line"></div>

        <section class="impact p-3 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <h1 class="text-2xl font-bold text-center relative text-text-main">
                    UNESCO Impacts
                </h1>
                <RouterLink to="/impacts"
                    class="border-0 outline-0 shadow-2xl py-3 px-4 m-9 text-center bg-primary text-text-sec z-[1] rounded-[15px] cursor-pointer hover:bg-text-sec hover:text-primary hover:outline-2">
                    Show more ...</RouterLink>
            </div>
            <TheImpacts showLatestOnly />
        </section>

        <div class="mx-auto my-5 w-52 border border-b-horizontal-line"></div>

        <section class="p-3 text-center">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <h1 class="text-2xl font-bold text-center relative text-text-main">
                    UNESCO News
                </h1>
                <RouterLink to="/news"
                    class="border-0 outline-0 shadow-2xl py-3 px-4 m-9 text-center bg-primary text-text-sec z-[1] rounded-[15px] cursor-pointer hover:bg-text-sec hover:text-primary hover:outline-2">
                    Show more ...</RouterLink>
            </div>
            <TheNews showLatestOnly />
        </section>
    </GuestLayout>
</template>
