import Vue from 'vue';
import VueRouter from "vue-router";
import { depositRoutes } from "../deposit";
Vue.use(VueRouter);

const routes = [
    ...depositRoutes
];

const router = new VueRouter({
    mode: 'history',
    routes
});

export default router;
