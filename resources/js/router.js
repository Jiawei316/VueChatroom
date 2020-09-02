import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

let routes = [
    {
        path:'/',
        component: require('./components/home').default
    },
    {
        path:'/login',
        component: require('./components/login').default,
    },
    {
        path:'/logout',
        component: require('./components/logout').default
    },
    {
        path:'/profile',
        component: require('./components/profile').default,
        meta:{
            displayNavBar:true
        }
    },
    {
        path:'/chat',
        component: require('./components/chat').default,
        meta:{
            displayNavBar:true
        }
    },
    {
        path:'/friends',
        component: require('./components/friends').default,
        meta:{
            displayNavBar:true
        }
    },
    {
        path:'*',
        redirect:'/'
    }
];

export default new VueRouter({
    mode:'history',
    routes
});
