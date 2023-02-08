import Vue from 'vue'
import VueRouter from 'vue-router'

import ProductIndex from './product/Index.vue';
import ProductAdd from './product/Add.vue';
import ProductEdit from './product/Edit.vue';

import OrderIndex from './order/Index.vue';
import TodayOrder from './order/todayOrder.vue';
import OrderAdd from './order/Add.vue';
import OrderView from './order/View.vue';

import Dashboard from './layout/Dashboard'
Vue.use(VueRouter);


const routes = [
    {
        path: '/',
        component: Dashboard,
        name: 'Dashboard'
    },
    {
        path: '/productIndex',
        component: ProductIndex,
        name: 'productIndex'
    },
    {
        path: '/productAdd',
        component: ProductAdd,
        name: 'productAdd'
    },
    {
        path: '/productEdit/:id',
        component: ProductEdit,
        name: 'productEdit'
    },
    {
        path: '/orderIndex',
        component: OrderIndex,
        name: 'orderIndex'
    },
    {
        path: '/orderAdd',
        component: OrderAdd,
        name: 'orderAdd'
    },
    {
        path: '/orderView/:id',
        component: OrderView,
        name: 'orderView'
    },
    {
        path: '/todayOrder',
        component: TodayOrder,
        name: 'todayOrder'
    },
];

let router = new VueRouter({
    mode: 'history',
    linkExactActiveClass: 'active',
    routes,
});
 export default router;
