<script>
export default {
    props: {
        currentPage: {
            type: Number,
            required: true
        },
        totalPages: {
            type: Number,
            required: true
        },
        maxVisiblePages: {
            type: Number,
            default: 5
        }
    },
    computed: {
        pageRange() {
            const range = [];
            let start = Math.max(1, this.currentPage - Math.floor(this.maxVisiblePages / 2));
            const end = Math.min(this.totalPages, start + this.maxVisiblePages - 1);

            if (end - start + 1 < this.maxVisiblePages) {
                start = Math.max(1, end - this.maxVisiblePages + 1);
            }

            for (let i = start; i <= end; i++) {
                range.push(i);
            }

            return range;
        }
    },
    methods: {
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.$emit('page-changed', page);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    }
}
</script>

<template>
    <div class="flex-1 flex items-center justify-center m-4">
        <div>
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 1"
                    class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium"
                    :class="currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'">
                    <span class="sr-only">Previous</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Dynamic page numbers -->
                <button v-for="page in pageRange" :key="`page-${page}`" @click="goToPage(page)"
                    :aria-current="page === currentPage ? 'page' : undefined"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium" :class="page === currentPage
                        ? 'z-10 bg-primary border-primary text-text-sec'
                        : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'">
                    {{ page }}
                </button>

                <button @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages"
                    class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium"
                    :class="currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'">
                    <span class="sr-only">Next</span>
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </nav>
        </div>
    </div>
</template>
