<template>
    <ul class="pagination">
        <li class="pagination-item">
            <button
                type="button"
                :disabled="isInFirstPage"
                @click="onClickFirstPage"
            >
                First
            </button>
        </li>
        <li class="pagination-item">
            <button
                type="button"
                :disabled="isInFirstPage"
                @click="onClickPreviousPage"
            >
                Previous
            </button>
        </li>
        <li
            v-for="page in pages"
            :key="page.name"
            class="pagination-item"
        >
            <button
                type="button"
                :disabled="page.isDisabled"
                :class="{ active: isPageActive(page.name) }"
                @click="onClickPage(page.name)"
            >
                {{ page.name }}
            </button>
        </li>
        <li class="pagination-item">
            <button
                type="button"
                :disabled="isInLastPage"
                @click="onClickNextPage"
            >
                Next
            </button>
        </li>
        <li class="pagination-item">
            <button
                type="button"
                :disabled="isInLastPage"
                @click="onClickLastPage"
            >
                Last
            </button>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        maxVisibleButtons: {
            type: Number,
            required: false,
            default: 3,
        },
        totalPages: {
            type: Number,
            required: true,
        },
        total: {
            type: Number,
            required: true,
        },
        currentPage: {
            type: Number,
            required: true,
        },
    },
    computed: {
        startPage() {
            // When on the first page
            if (this.currentPage === 1) {
                return 1;
            }

            // When on the last page
            if (this.currentPage === this.totalPages) {
                return this.totalPages - this.maxVisibleButtons + 1;
            }

            // When in between
            return this.currentPage - 1;
        },
        pages() {
            const range = [];
            for (let i = this.startPage;
                i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);
                i += 1) {
                range.push({
                    name: i,
                    isDisabled: i === this.currentPage,
                });
            }
            return range;
        },
        isInFirstPage() {
            return this.currentPage === 1;
        },
        isInLastPage() {
            return this.currentPage === this.totalPages;
        },
    },
    mounted() {
    },
    methods: {
        onClickFirstPage() {
            this.$emit('pagechanged', 1);
        },
        onClickPreviousPage() {
            this.$emit('pagechanged', this.currentPage - 1);
        },
        onClickPage(page) {
            this.$emit('pagechanged', page);
        },
        onClickNextPage() {
            this.$emit('pagechanged', this.currentPage + 1);
        },
        onClickLastPage() {
            this.$emit('pagechanged', this.totalPages);
        },
        isPageActive(page) {
            return this.currentPage === page;
        },
    },
};
</script>

<style scoped>
.pagination {
    list-style-type: none;
}

.pagination-item {
    display: inline-block;
}

.active {
    background-color: #4aae98;
    color: #ffffff;
}
</style>
