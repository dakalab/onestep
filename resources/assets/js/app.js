
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.bootbox = require('bootbox')

window.echarts = require('echarts')

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('ajax-link', require('./components/AjaxLink.vue'));
Vue.component('ajax-upload', require('./components/AjaxUpload.vue'));
Vue.component('rating', require('./components/Rating.vue'));
Vue.component('logout', require('./components/auth/Logout.vue'));

const app = new Vue({
    el: '#app'
});
