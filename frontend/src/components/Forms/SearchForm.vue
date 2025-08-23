<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const isSearchFormOpen = ref(false);
const isResultListOpen = ref(false);
const searchQuery = ref('');
const searchResults = ref([]);
const isLoading = ref(false);
const searchInput = ref(null);
let searchTimer = null;

const router = useRouter();
const apiBaseUrl = import.meta.env.VITE_API_BASE_URL;

const API_ENDPOINTS = {
    impacts: `${apiBaseUrl}/impacts`,
    news: `${apiBaseUrl}/news`
};

const showSearchForm = () => {
    isSearchFormOpen.value = !isSearchFormOpen.value;
    if (isSearchFormOpen.value) {
        nextTick(() => {
            searchInput.value.focus();
        });
    } else {
        closeSearch();
    }
};

const handleSearch = () => {
    if (searchQuery.value.trim() === '') {
        searchResults.value = [];
        isResultListOpen.value = false;
        return;
    }

    if (searchTimer) {
        clearTimeout(searchTimer);
    }

    isLoading.value = true;
    searchTimer = setTimeout(async () => {
        try {
            const [impactsResponse, newsResponse] = await Promise.all([
                axios.get(API_ENDPOINTS.impacts, { params: { q: searchQuery.value } }),
                axios.get(API_ENDPOINTS.news, { params: { q: searchQuery.value } })
            ]);

            const impactsResults = impactsResponse.data.filter(item =>
                JSON.stringify(item).toLowerCase().includes(searchQuery.value.toLowerCase())
            ).map(item => ({ ...item, type: 'impacts' }));
            const newsResults = newsResponse.data.filter(item =>
                JSON.stringify(item).toLowerCase().includes(searchQuery.value.toLowerCase())
            ).map(item => ({ ...item, type: 'news' }));

            searchResults.value = [...impactsResults, ...newsResults];
            isResultListOpen.value = true;
        } catch (error) {
            console.error('Error fetching search results:', error);
            searchResults.value = [];
            isResultListOpen.value = false;
        } finally {
            isLoading.value = false;
        }
    }, 300);
};

const closeSearch = () => {
    isSearchFormOpen.value = false;
    isResultListOpen.value = false;
    searchQuery.value = '';
    searchResults.value = [];
};

const handleClickOutside = (event) => {
    const componentRoot = document.querySelector('.your-component-root');
    if (componentRoot && !componentRoot.contains(event.target)) {
        closeSearch();
    }
};

const navigateToResult = (result) => {
    closeSearch();
    router.push(`/${result.type}/${result.id}`);
};

onMounted(() => {
    // The initial data fetch is no longer needed here since
    // the search is now handled directly by the API.
    document.addEventListener('click', handleClickOutside);
});

onBeforeUnmount(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="search">
        <button @click="showSearchForm"
            class="search-button px-1 pt-1 pb-0 rounded-full bg-transparent border-0 cursor-pointer">
            <img loading="lazy" src="../../../public/icons/magnifying-glass-solid.svg" alt="search_icon" class="w-4 h-4"
                style="filter: brightness(0) saturate(100%) invert(100%) sepia(97%) saturate(13%) hue-rotate(237deg) brightness(104%) contrast(104%);">
        </button>
        <form @submit.prevent="handleSearch"
            class="absolute flex justify-center left-0 w-full top-24 z-50 p-5 my-3 mx-0 bg-primary shadow-2xl" action=""
            method="post" :class="{ 'hidden': !isSearchFormOpen }">
            <input ref="searchInput" v-model="searchQuery" @input="handleSearch" type="text"
                class="search-input w-full p-3 m-2 border-0 rounded-md outline-0 bg-white text-black"
                placeholder="What are you looking for?">
        </form>
        <div v-if="isResultListOpen"
            class="absolute justify-center left-0 w-full h-96 overflow-y-scroll top-52 z-50 p-5 my-3 mx-0 bg-bg text-text-main shadow-2xl cursor-pointer">
            <div v-if="isLoading" class="p-3 text-center text-gray-500">
                Searching...
            </div>
            <div v-else-if="searchResults.length > 0" class="search-results">
                <div v-for="(result, index) in searchResults" :key="index"
                    class="result-item p-3 border-b border-gray/30 hover:bg-gray/10" @click="navigateToResult(result)">
                    <div
                        class="result-type text-xs font-semibold mb-1 bg-primary/20 border border-horizontal-line/30 text-horizontal-line p-1 rounded-lg w-fit">
                        {{ result.type.toUpperCase() }}
                    </div>
                    <div class="result-content">
                        {{ result.title }}
                    </div>
                    <div class="result-content">
                        {{ result.content ? result.content.substring(0, 10) + (result.content.length > 10 ? '...' : '')
                            : 'No content' }}
                    </div>
                </div>
            </div>
            <div v-else class="no-results p-3 text-center text-gray-500">
                No results found
            </div>
        </div>
    </div>
</template>

<style scoped>
.result-item {
    transition: background-color 0.2s;
}
</style>
