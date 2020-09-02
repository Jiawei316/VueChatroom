/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import router from './router';
import store from './store';
import Avatar from 'vue-avatar';

require('./bootstrap');
// require('./socket');

window.Vue = require('vue');
window.swal = require('sweetalert2');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('avatar',Avatar);
Vue.component('navbar',require('./components/navbar').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    store,
    mounted() {
        let isLogin = this.$store.getters.userData.length === 0 || Object.keys(this.$store.getters.userData).length === 0;
        if (isLogin && this.$router.history.current.fullPath !== '/login') {
            swal.fire({
                title: 'Message',
                text: '請先登入。',
                timer: 500,
                showConfirmButton: false,
                timerProgressBar: true
            }).then(() => {
                this.$router.push('/login');
            });
        }

        // this.sockets.subscribe('relogin', (data) => {
        //     console.log(data)
        // })
    }
});
