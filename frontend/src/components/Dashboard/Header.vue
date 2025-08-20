<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';
import ThemeToggle from '../ThemeToggle.vue';
import DetailsModal from './DetailsModal.vue';
import PrimaryBtn from './Buttons/PrimaryBtn.vue';

const router = useRouter();
const user = ref({});
const isAccountListOpen = ref(false);
const isProfileModalOpen = ref(false);
const toast = useToast();
const emit = defineEmits(['toggle-nav', 'close']);
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

function toggleAccountList() {
    isAccountListOpen.value = !isAccountListOpen.value;
}

function toggleProfileModal() {
    isProfileModalOpen.value = !isProfileModalOpen.value;
}

onMounted(async () => {
    try {
        const res = await fetch(`${API_BASE_URL}/auth/check`, {
            method: 'GET',
            credentials: 'include'
        });
        const result = await res.json();
        if (!result.loggedIn) {
            router.push('/login');
            return;
        }
        // Restrict to admin only
        if (result.user && result.user.role !== 'admin') {
            router.push('/');
            return;
        }
        user.value = result.user || {};
    } catch (e) {
        router.push('/login');
    }
});

function closeModal() {
    isProfileModalOpen.value = false;
    emit('close');
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

</script>

<template>
    <div class="main-nav relative flex justify-between items-center z-50 bg-primary text-text-sec shadow-2xl p-6">
        <div class="flex items-center">
            <button @click="$emit('toggle-nav')"
                class="dash-nav-trigger lg:hidden bg-transparent text-2xl mb-2 me-2 text-text-sec cursor-pointer">
                &equiv;
            </button>
            <div class="logo m-2">
                <img class="w-36" loading="lazy" src="/public/images/unesco.svg" alt="unesco_logo">
            </div>
        </div>
        <div class="right flex gap-2.5 items-center">
            <router-link to="/" class="m-2 cursor-pointer flex items-center bg-bg rounded-md p-2 text-horizontal-line"
                title="Visit Website">
                <span class="material-symbols-outlined md:me-2">
                    globe
                </span>
                <span class="hidden md:block">Visit Website</span>
            </router-link>
            <ThemeToggle />
            <div class="avatar flex flex-row-reverse items-center relative">
                <span class="material-symbols-outlined ms-3 cursor-pointer" @click="toggleAccountList">
                    account_circle
                </span>
                <span class="cursor-pointer" @click="toggleAccountList">{{ user.name }}</span>
                <div class="bg-bg p-1 rounded-md absolute top-full right-0 mt-2 shadow-md w-40"
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
