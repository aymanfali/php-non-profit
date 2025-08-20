<script setup>
import { RouterLink } from 'vue-router';
import BackToTopBtn from './BackToTopBtn.vue';

</script>

<template>
    <div class="bg-primary p-5 relative">
        <div class="logo text-center mb-7">
            <img class="m-auto" loading="lazy" src="../../public/images/unesco.svg" alt="unesco_logo">
        </div>
        <div class="follow-us flex items-center justify-center flex-col">
            <h3 class="border-b-2 text-text-sec border-b-text-sec font-bold">Follow Us</h3>
            <div class="follow-links flex">
                <a class="m-1 bg-text-sec p-1 rounded-sm" href="https://www.instagram.com/unesco/?hl=en"><img
                        class="w-6 h-6" loading="lazy" src="../../public/icons/instagram-brands.svg" alt="instagram"></a>
                <a class="m-1 bg-text-sec p-1 rounded-sm" href="https://www.linkedin.com/company/unesco"><img
                        class="w-6 h-6" loading="lazy" src="../../public/icons/linkedin-in-brands.svg" alt="linkedin"></a>
                <a class="m-1 bg-text-sec p-1 rounded-sm" href="https://www.youtube.com/UNESCO"><img class="w-6 h-6"
                        loading="lazy" src="../../public/icons/youtube-brands.svg" alt="youtube"></a>
                <a class="m-1 bg-text-sec p-1 rounded-sm" href="https://x.com/UNESCO"><img class="w-6 h-6"
                        loading="lazy" src="../../public/icons/x-twitter-brands.svg" alt="x_twitter"></a>
                <a class="m-1 bg-text-sec p-1 rounded-sm" href="https://www.tiktok.com/@unesco?lang=en"><img
                        class="w-6 h-6" loading="lazy" src="../../public/icons/tiktok-brands.svg" alt="tiktok"></a>
                <a class="m-1 bg-text-sec p-1 rounded-sm"
                    href="https://whatsapp.com/channel/0029VaHUoHkAO7RCkmguOi1w"><img class="w-6 h-6"
                        src="../../public/icons/whatsapp-brands .svg" alt="whatsapp"></a>
                <a class="m-1 bg-text-sec p-1 rounded-sm" href="https://bsky.app/profile/unesco.org"><img
                        class="w-6 h-6" loading="lazy" src="../../public/icons/bluesky-brands.svg" alt="bluesky"></a>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-5 m-5 text-center text-blue-600">
            <div class="site-map m-3 flex flex-col items-center">
                <h3 class="border-b-2 border-b-white p-3 m-3 text-white">Site Map</h3>
                <nav>
                    <ul>
                        <li class="p-3"><RouterLink class="no-underline text-white" to="/">Home</RouterLink></li>
                        <li class="p-3"><RouterLink class="no-underline text-white" to="/impacts">Impacts</RouterLink> </li>
                        <li class="p-3"><RouterLink class="no-underline text-white" to="/contact-us">Contact Us</RouterLink></li>
                        <li class="p-3 "><RouterLink class="no-underline text-white" to="/about-us">About Us</RouterLink></li>
                    </ul>
                </nav>
            </div>
            <hr>
            <BackToTopBtn/>
            <div class="copy-write text-white">
                UNESCO &copy; 2025
            </div>
        </div>
    </div>
</template>
