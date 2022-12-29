
import {createWebHistory, createRouter} from "vue-router";

import Home from '../pages/Home';

import Contactdetails from '../pages/Contactdetails';


export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'contactdetails',
        path: '/contactdetails/:name',
        component: Contactdetails
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

export default router;
