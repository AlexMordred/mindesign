require('./bootstrap');

Vue.component('v-search-form', require('./components/SearchForm.vue'));

new Vue({
    el: '#app'
});
