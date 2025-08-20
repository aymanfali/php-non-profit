<script setup>
import { ref, onMounted } from 'vue';
import { RouterLink, useRouter } from 'vue-router';
import SearchForm from './Forms/SearchForm.vue';
import ThemeToggle from './ThemeToggle.vue';
import PrimaryBtn from './Dashboard/Buttons/PrimaryBtn.vue';
import DetailsModal from './Dashboard/DetailsModal.vue';
import { useToast } from 'vue-toastification';

const isMobileNavOpen = ref(false);
const isAdmin = ref(false);
const user = ref({});
const isAccountListOpen = ref(false);
const isProfileModalOpen = ref(false);
const isLoggedIn = ref(false);
const toast = useToast();
const router = useRouter();
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

function toggleMobileNav() {
    isMobileNavOpen.value = !isMobileNavOpen.value;
}
function toggleAccountList() {
    isAccountListOpen.value = !isAccountListOpen.value;
}
function toggleProfileModal() {
    isProfileModalOpen.value = !isProfileModalOpen.value;
}
function closeModal() {
    isProfileModalOpen.value = false;
}
const handleLogout = async () => {
    try {
        await fetch(`${API_BASE_URL}/auth/logout`, {
            method: 'GET',
            credentials: 'include'
        });
    } catch (e) { }
    router.push('/login');
    toast.success("Logged out successfully!");
};

onMounted(async () => {
    try {
        const res = await fetch(`${API_BASE_URL}/auth/check`, {
            method: 'GET',
            credentials: 'include'
        });
        const result = await res.json();
        if (result.loggedIn && result.user) {
            user.value = result.user;
            isLoggedIn.value = true;
            isAdmin.value = result.user.role === 'admin';
        } else {
            isLoggedIn.value = false;
            user.value = {};
        }
    } catch (e) {
        isLoggedIn.value = false;
        user.value = {};
    }
});
</script>
<template>
    <div class="main-nav relative flex justify-around items-center bg-primary text-text-sec shadow-2xl p-5">
        <div class="logo">
            <img class="w-36" loading="lazy" src="../../public/images/unesco.svg" alt="unesco_logo">
        </div>
        <nav class="nav md:block" :class="{ 'hidden': !isMobileNavOpen, '': isMobileNavOpen }">
            <ul
                class="absolute md:relative flex flex-col md:flex-row gap-5 bg-primary w-full md:w-auto left-0 md:left-auto top-20 md:top-0 z-20 shadow-2xl md:shadow-none">
                <li class="active flex items-center relative">
                    <RouterLink
                        class="text-text-sec hover:border-b border-text-sec no-underline w-full text-center p-3.5"
                        to="/" :class="{ 'border-b border-text-sec': $route.path === '/' }">
                        Home</RouterLink>
                </li>
                <li class="flex items-center relative">
                    <RouterLink
                        class="text-text-sec hover:border-b border-text-sec transform no-underline w-full text-center p-3.5"
                        to="/impacts" :class="{ 'border-b border-text-sec': $route.path === '/impacts' }">Impacts
                    </RouterLink>
                </li>
                <li class="flex items-center relative">
                    <RouterLink
                        class="text-text-sec hover:border-b border-text-sec transform no-underline w-full text-center p-3.5"
                        to="/news" :class="{ 'border-b border-text-sec': $route.path === '/news' }">News
                    </RouterLink>
                </li>
                <li class="flex items-center relative">
                    <RouterLink
                        class="text-text-sec hover:border-b border-text-sec no-underline w-full text-center p-3.5"
                        to="/contact-us" :class="{ 'border-b border-text-sec': $route.path === '/contact-us' }">
                        Contact
                        Us</RouterLink>
                </li>
                <li class="flex items-center relative">
                    <RouterLink
                        class="text-text-sec hover:border-b border-text-sec transform no-underline w-full text-center p-3.5"
                        to="/about-us" :class="{ 'border-b border-text-sec': $route.path === '/about-us' }">About
                        Us</RouterLink>
                </li>
            </ul>
        </nav>
        <div class="right flex gap-2.5 items-center">
            <router-link to="/dashboard" v-if="isAdmin"
                class="m-2 cursor-pointer bg-bg rounded-md p-2 pb-0 text-horizontal-line">
                <span class="material-symbols-outlined" title="admin dashboard">
                    shield_person
                </span>
            </router-link>
            <ThemeToggle />
            <SearchForm />
            <button @click="toggleMobileNav"
                class="mobile-nav-trigger md:hidden bg-transparent text-2xl mb-2 text-text-sec cursor-pointer">&equiv;</button>
            <div class="avatar flex flex-row-reverse items-center relative" v-if="isLoggedIn">
                <span class="material-symbols-outlined ms-3 cursor-pointer" @click="toggleAccountList">
                    account_circle
                </span>
                <span class="cursor-pointer hidden md:block" @click="toggleAccountList">{{ user.name }}</span>
                <div class="bg-bg p-1 rounded-md absolute top-full right-0 mt-2 shadow-md w-40 z-30"
                    v-if="isAccountListOpen">
                    <button @click="toggleProfileModal"
                        class="flex justify-start items-center w-full text-text-main hover:bg-gray/40 p-2 cursor-pointer rounded-md">
                        <span class="material-symbols-outlined me-3">
                            account_circle
                        </span>
                        <span>Profile</span>
                    </button>
                    <button @click="handleLogout"
                        class="flex justify-start items-center w-full text-danger hover:bg-gray/40 p-2 cursor-pointer rounded-md">
                        <span class="material-symbols-outlined me-3">
                            logout
                        </span>
                        <span>Logout</span>
                    </button>
                </div>
            </div>
            <DetailsModal v-if="isProfileModalOpen" @close="closeModal">
                <h1 class="text-2xl font-bold m-4 text-text-main">Profile</h1>
                <div class="grid grid-cols-1 md:grid-cols-5 text-text-main items-center">
                    <p class="rounded-md p-2 pb-0 m-1 font-bold md:text-end">Username :</p>
                    <span class="rounded-md bg-primary/20 p-2 m-1 w-60"> {{ user.name }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 text-text-main items-center">
                    <p class="rounded-md p-2 pb-0 m-1 font-bold md:text-end">Email :</p>
                    <span class="rounded-md bg-primary/20 p-2 m-1 w-60"> {{ user.email }}</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-5 text-text-main items-center">
                    <p class="rounded-md p-2 pb-0 m-1 font-bold md:text-end">Role :</p>
                    <span class="rounded-md bg-primary/20 p-2 m-1 w-60"> {{ user.role }}</span>
                </div>
                <div class="mt-6 flex justify-end">
                    <PrimaryBtn @click="closeModal" name="Close" />
                </div>
            </DetailsModal>
        </div>
    </div>
</template>
