<script>
import GuestLayout from './GuestLayout.vue';

export default {
    components: {
        GuestLayout
    },
    data() {
        return {
            about: {
                history: '',
                values: '',
            },
            defaultContent: {
                history: 'UNESCO was created to decide what kind of society we wanted to build together after the destruction of two World Wars. As early as 1942, global leaders began imagining an organization that would use education, culture, science and information to build lasting peace. Over the years, UNESCO has implemented initiatives that have radically improved lives around the world, and shaped global action in its field of competence.',
                values: 'Our #SharingHumanity campaign reminds us of our global values, culture, and knowledge. By strengthening these ties, we build the foundations of peace between people and nations.'
            }
        }
    },
    created() {
        this.loadAbout();
    },
    methods: {
        loadAbout() {
            const savedAbout = localStorage.getItem('aboutFormData');
            if (savedAbout) {
                try {
                    const parsed = JSON.parse(savedAbout);
                    // Only use saved data if fields aren't empty strings
                    if (parsed.history?.trim() || parsed.values?.trim()) {
                        this.about = parsed;
                    }
                } catch (e) {
                    console.error('Failed to parse about data', e);
                }
            }
        },
    },
}
</script>

<template>
    <GuestLayout>
        <Hero>
            <h1 class="title font-bold mb-5 text-text-sec z-10">About Us</h1>
        </Hero>

        <section class="about-us p-5 text-text-main">
            <div class="our-history">
                <h2 class="title text-center m-8 font-bold text-3xl">Our history</h2>
                <div class="history flex flex-col justify-center items-center my-8 md:flex-row">
                    <img loading="lazy" src="/public/images/history.webp" alt="history"
                        class="max-w-[350px] h-auto mx-auto rounded-[15px]">
                    <div class="description m-8 leading-relaxed">
                        <p v-if="about.history">{{ about.history }}</p>
                        <p v-else>{{ defaultContent.history }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-8">

            <div class="our-values">
                <h2 class="title text-center m-8 font-bold text-3xl">Our Values</h2>
                <div class="values flex flex-col justify-center items-center my-8 md:flex-row-reverse">
                    <img loading="lazy" src="/public/images/values.webp" alt="values"
                        class="max-w-[350px] h-auto mx-auto rounded-[15px]">
                    <div class="description m-8 leading-relaxed">
                        <p v-if="about.values">{{ about.values }}</p>
                        <p v-else>{{ defaultContent.values }}</p>
                    </div>
                </div>
            </div>

            <hr class="my-8">
        </section>
    </GuestLayout>
</template>
