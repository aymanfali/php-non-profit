<script>
import PrimaryBtn from './Buttons/PrimaryBtn.vue';

export default {
    components: {
        PrimaryBtn
    },
    props: {
        headers: {
            type: Array,
            required: true
        },
        items: {
            type: Array,
            required: true
        },
        showActions: {
            type: Boolean,
            default: true
        },
        allowEdit: {
            type: Boolean,
            default: true
        },
        itemsPerPage: {
            type: Number,
            default: 5
        },
        filterableColumns: {
            type: Array,
            default: () => []
        }
    },
    data() {
        return {
            currentPage: 1,
            filters: {}
        }
    },
    created() {
        // Initialize filters based on filterableColumns
        this.filterableColumns.forEach(col => {
            this.filters[col.key] = '';
        });
    },
    computed: {
        filterItems() {
            return this.items.filter(item => {
                return this.filterableColumns.every(filterConfig => {
                    const filterValue = this.filters[filterConfig.key];
                    if (!filterValue) return true; // No filter applied for this column

                    const itemValue = item[filterConfig.key];

                    if (filterConfig.type === 'date') {
                        try {
                            const filteredItem = new Date(itemValue).setHours(0, 0, 0, 0);
                            const dateFilter = new Date(filterValue).setHours(0, 0, 0, 0);
                            return filteredItem === dateFilter;
                        } catch {
                            return false;
                        }
                    } else {
                        return itemValue &&
                            itemValue.toString().toLowerCase()
                                .includes(filterValue.toLowerCase());
                    }
                });
            });
        },
        totalPages() {
            return Math.ceil(this.filterItems.length / this.itemsPerPage);
        },
        paginatedItems() {
            const start = (this.currentPage - 1) * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.filterItems.slice(start, end);
        },
    },
    methods: {
        handleEdit(item) {
            this.$emit('edit', item);
        },
        handleDelete(item) {
            this.$emit('delete', item);
        },
        handleView(item) {
            this.$emit('view', item);
        },
        formatDate(value) {
            if (!value) return '';
            try {
                return new Date(value).toLocaleDateString();
            } catch {
                return value;
            }
        },
        isImage(value) {
            return typeof value === 'string' &&
                (value.startsWith('http') ||
                    value.startsWith('/') ||
                    value.startsWith('data:image'));
        },
        goToPage(page) {
            if (page >= 1 && page <= this.totalPages) {
                this.currentPage = page;
            }
        },
        nextPage() {
            if (this.currentPage < this.totalPages) {
                this.currentPage++;
            }
        },
        prevPage() {
            if (this.currentPage > 1) {
                this.currentPage--;
            }
        },
        handleFilter() {
            this.currentPage = 1;
        },
        clearFilters() {
            Object.keys(this.filters).forEach(key => {
                this.filters[key] = '';
            });
            this.currentPage = 1;
        }
    }
}
</script>


<template>
    <div class="rounded-lg shadow overflow-auto">
        <div class="">
            <form @submit.prevent="handleFilter" class="md:flex md:flex-wrap">
                <div v-for="filterConfig in filterableColumns" :key="filterConfig.key" class="m-3">
                    <label v-if="filterConfig.label" class="block text-sm font-medium text-horizontal-line mb-1">
                        {{ filterConfig.label }}
                    </label>
                    <input v-if="filterConfig.type !== 'date'" type="text" v-model="filters[filterConfig.key]"
                        :placeholder="`Filter by ${filterConfig.label || filterConfig.key}`"
                        class="bg-primary/20 py-2 px-3 shadow-sm rounded outline-horizontal-line w-full">
                    <input v-else type="date" v-model="filters[filterConfig.key]"
                        :placeholder="`Filter by ${filterConfig.label || filterConfig.key}`"
                        class="bg-primary/20 py-2 px-3 shadow-sm rounded outline-horizontal-line w-full">
                </div>
                <div class="m-1 flex items-end">
                    <PrimaryBtn type="button" name="Clear" @click="clearFilters" class="ml-2" />
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-primary/20">
                <thead class="">
                    <tr>
                        <th v-for="(header, index) in headers" :key="`header-${index}`"
                            class="px-6 py-3 text-center text-md font-bold uppercase tracking-wider">
                            {{ header }}
                        </th>
                        <th v-if="showActions" class="px-6 py-3 text-center text-md font-bold uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-primary/20">
                    <tr v-for="(item, itemIndex) in paginatedItems" :key="`row-${itemIndex}`">
                        <template v-for="(header, headerIndex) in headers" :key="`cell-${itemIndex}-${headerIndex}`">
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <template v-if="isImage(item[header.toLowerCase()])">
                                    <img :src="item[header.toLowerCase()]"
                                        class="h-10 w-10 rounded-full object-cover mx-auto" :alt="`${header} image`">
                                </template>
                                <template v-else-if="header.toLowerCase().includes('date')">
                                    <div class="text-center">{{ formatDate(item[header.toLowerCase()]) }}</div>
                                </template>
                                <template v-else>
                                    {{ item[header.toLowerCase()] }}
                                </template>
                            </td>
                        </template>

                        <td v-if="showActions" class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <button @click="handleView(item)" class="mr-3 cursor-pointer" title="View details">
                                <span class="material-symbols-rounded">
                                    visibility
                                </span>
                            </button>
                            <button v-if="allowEdit" @click="handleEdit(item)" class="mr-3 cursor-pointer" title="Edit">
                                <span class="material-symbols-rounded">
                                    edit
                                </span>
                            </button>
                            <button @click="handleDelete(item)" class="cursor-pointer text-red-600 hover:text-red-900" title="Delete">
                                <span class="material-symbols-rounded">
                                    delete
                                </span>
                            </button>
                        </td>
                    </tr>
                    <tr v-if="filterItems.length === 0">
                        <td :colspan="headers.length + (showActions ? 1 : 0)" class="px-6 py-4 text-center">
                            No items found
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="bg-bg px-4 py-3 flex items-center justify-between border-t border-primary/20 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <button @click="prevPage" :disabled="currentPage === 1"
                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md"
                    :class="currentPage === 1 ? 'bg-gray-100 text-gray-400' : 'bg-white text-horizontal-line hover:bg-gray-50'">
                    Previous
                </button>
                <button @click="nextPage" :disabled="currentPage === totalPages"
                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md"
                    :class="currentPage === totalPages ? 'bg-gray-100 text-gray-400' : 'bg-white text-horizontal-line hover:bg-gray-50'">
                    Next
                </button>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-horizontal-line">
                        Showing <span class="font-medium">{{ (currentPage - 1) * itemsPerPage + 1 }}</span>
                        to <span class="font-medium">{{ Math.min(currentPage * itemsPerPage, filterItems.length)
                            }}</span>
                        of <span class="font-medium">{{ filterItems.length }}</span> results
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <button @click="prevPage" :disabled="currentPage === 1"
                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium"
                            :class="currentPage === 1 ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Page numbers -->
                        <template v-for="page in totalPages" :key="`page-${page}`">
                            <button @click="goToPage(page)" :aria-current="page === currentPage ? 'page' : undefined"
                                class="relative inline-flex items-center px-4 py-2 border text-sm font-medium" :class="page === currentPage
                                    ? 'z-10 bg-primary border-primary text-text-sec'
                                    : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50'">
                                {{ page }}
                            </button>
                        </template>

                        <button @click="nextPage" :disabled="currentPage === totalPages"
                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium"
                            :class="currentPage === totalPages ? 'text-gray-300 cursor-not-allowed' : 'text-gray-500 hover:bg-gray-50'">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
