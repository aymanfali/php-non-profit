<script>
export default {
    data() {
        return {
            isSearchFormOpen: false,
            isResultListOpen: false,
            searchQuery: '',
            searchResults: [],
            impactsData: [],
            newsData: [],
            isLoading: false
        }
    },
    mounted() {
        this.loadLocalData();
        document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    methods: {
        showSearchForm() {
            this.isSearchFormOpen = !this.isSearchFormOpen;
            if (this.isSearchFormOpen) {
                this.$nextTick(() => {
                    this.$refs.searchInput.focus();
                });
            } else {
                this.closeSearch();
            }
        },
        loadLocalData() {
            // Load impacts data
            const impactsStored = localStorage.getItem('impacts');
            this.impactsData = impactsStored ? JSON.parse(impactsStored) : [];

            // Load news data
            const newsStored = localStorage.getItem('news');
            this.newsData = newsStored ? JSON.parse(newsStored) : [];
        },
        handleSearch() {
            if (this.searchQuery.trim() === '') {
                this.searchResults = [];
                this.isResultListOpen = false;
                return;
            }

            if (this.searchTimer) {
                clearTimeout(this.searchTimer);
            }

            this.isLoading = true;
            this.searchTimer = setTimeout(() => {
                // Search in impacts data
                const impactsResults = this.impactsData.filter(item =>
                    JSON.stringify(item).toLowerCase().includes(this.searchQuery.toLowerCase())
                ).map(item => ({ ...item, type: 'impacts' }));

                // Search in news data
                const newsResults = this.newsData.filter(item =>
                    JSON.stringify(item).toLowerCase().includes(this.searchQuery.toLowerCase())
                ).map(item => ({ ...item, type: 'news' }));

                // Combine results
                this.searchResults = [...impactsResults, ...newsResults];
                this.isResultListOpen = true;
                this.isLoading = false;
            }, 300);
        },
        closeSearch() {
            this.isSearchFormOpen = false;
            this.isResultListOpen = false;
            this.searchQuery = '';
            this.searchResults = [];
        },
        handleClickOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.closeSearch();
            }
        },
        navigateToResult(result) {
            this.closeSearch();
            this.$router.push(`/${result.type}/${result.id}`);
        }
    }
}
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
                    <div class="result-type text-xs font-semibold mb-1 bg-primary/20 border border-horizontal-line/30 text-horizontal-line p-1 rounded-lg w-fit">
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
