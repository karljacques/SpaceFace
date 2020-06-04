import Vue from 'vue';
import VueRouter, {RouteConfig} from 'vue-router';
import PrimaryLayout from '../views/PrimaryLayout.vue';

Vue.use(VueRouter);

const routes: RouteConfig[] = [
  {
    path: '/',
    name: 'Home',
    component: PrimaryLayout,
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

export default router;
