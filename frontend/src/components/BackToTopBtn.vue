<script>
export default {
    data() {
        return {
            isButtonVisible: false
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll)
    },
    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll)
    },
    methods: {
        handleScroll() {
            this.isButtonVisible = window.scrollY > 300
        },
        scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            })
        }
    }
}
</script>

<template>
    <a @click="scrollToTop" :class="{ 'hidden': !isButtonVisible }" href="#" id="back-to-top"
        class=" fixed bottom-0 right-0 bg-blue-600 dark:bg-gray-900 text-white p-4 pb-3 m-8 rounded-full border border-blue-600 shadow-2xl z-[1000]">
        <span class="material-symbols-outlined">
            arrow_circle_up </span>
    </a>
</template>
