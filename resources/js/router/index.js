import Vue from 'vue';
import VueRouter from "vue-router";
import { depositRoutes } from "../deposit";
import {helper} from "../shared/service";
import NotFound from "../shared/components/NotFound";
Vue.use(VueRouter);

const routes = [
    ...depositRoutes,
    {
        path: '/web-views/vue/not-found',
        component: NotFound,
        name: 'notfound'
    },
    {
        path: '*',
        component: NotFound,
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});
router.beforeEach((to, from, next) => {
    const auth = helper.getTokenString();
    if(to.meta.auth && auth == null) {
        next({ name: 'notfound' });
    } else {
        next();
    }

});

export default router;
