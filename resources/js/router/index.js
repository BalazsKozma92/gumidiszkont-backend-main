import { createRouter, createWebHistory } from "vue-router";
import AdminLayout from '../components/layouts/AdminLayout.vue';
import Login from '../views/auth/Login.vue';
import Dashboard from '../views/admin/Dashboard.vue';
import News from '../views/admin/news/News.vue';
import NewsPage from '../views/admin/news/NewsPage.vue';
import Coupons from '../views/admin/coupons/Coupons.vue';
import CarouselImages from '../views/admin/carousel/CarouselImages.vue';
import NotFoundAdmin from '../views/NotFoundAdmin.vue';
import { authGuard } from './authGuard';

const routes = [
    {
        path: '/',
        name: 'admin',
        component: AdminLayout,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: 'dashboard',
                name: 'admin.dashboard',
                component: Dashboard,
            },
            {
                path: 'news',
                name: 'admin.news',
                component: News,
            },
            {
                path: 'news/:id',
                name: 'admin.newsDetail',
                component: NewsPage,
            },
            {
                path: 'carousel-images',
                name: 'admin.carouselImages',
                component: CarouselImages,
            },
            {
                path: 'coupons',
                name: 'admin.coupons',
                component: Coupons,
            },
        ],
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
    },
    {
        path: '/:pathMatch(.*)',
        name: 'notfoundadmin',
        component: NotFoundAdmin,
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach(authGuard);

export default router;