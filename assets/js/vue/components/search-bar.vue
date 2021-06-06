<template>
    <b-field>
        <b-input
            v-model="searchTerm"
            placeholder="Search..."
            type="search"
            icon="magnify"
            icon-right="close-circle"
            icon-right-clickable
            @icon-right-click="eraseSearchTerm"
            @input="onInput"
        />
    </b-field>
</template>

<script>
export default {
    name: 'SearchBar',
    data() {
        return {
            searchTerm: '',
            searchTimeout: null,
        };
    },
    methods: {
        onInput() {
            if (this.searchTimeout) {
                clearTimeout(this.searchTimeout);
            }
            this.searchTimeout = setTimeout(() => {
                // dispatching the event
                this.$emit('search-albums', { term: this.searchTerm });
                this.searchTimeout = null;
            }, 200);
        },
        eraseSearchTerm() {
            this.searchTerm = '';
            this.$emit('search-albums', { term: this.searchTerm });
        },
    },
};
</script>
