<template>
    <div>
        <form @submit.prevent="search">
            <input type="text" v-model="query">
        </form>
    </div>
</template>

<script>
export default {
    props: ['dataQuery'],

    data() {
        return {
            query: this.dataQuery ? this.dataQuery : ''
        };
    },

    methods: {
        search() {
            window.location = `/search/products/${this.query}`;
        }
    }
}
</script>
