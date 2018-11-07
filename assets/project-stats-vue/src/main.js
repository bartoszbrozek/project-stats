import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.config.productionTip = false;

Vue.use(VueRouter);

import Dashboard from './components/Dashboard.vue';
import ProjectList from './components/ProjectList.vue';
import Statistics from './components/Statistics.vue';

const routes = [
    {path: '/', component: Dashboard},
    {path: '/project/list', component: ProjectList},
    {path: '/project/:id/statistics', component: Statistics, name: 'statistics', props: true}
];

const router = new VueRouter({
    mode: 'history',
    routes
});

new Vue({
    router,
    render: h => h(Dashboard)
}).$mount('#app');