import Vue from 'vue'
import Router from 'vue-router'
import UserCart from '../components/CartComponent' //'../pages/user-cart'
import Products from '../pages/products'
import Start from '../pages/start'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    linkActiveClass: "active",
    base: '/',
    routes: [{
            path: '/cart',
            name: 'pages/user-cart',
            component: UserCart
        },
        {
            path: '/products',
            name: 'pages/products',
            component: Products
        },
        {
            path: '/',
            name: 'pages/start',
            component: Start
        }
    ]
});

router.beforeResolve((to, from, next) => {
    // If this isn't an initial page load.
    if (to.name) {
        console.log("routes")
    }
    next()
})

router.afterEach((to, from) => {
    console.log("to", to.name, "from", from.name)
    window.scrollTo({
        top: 0,
        left: 0,
    });
})
export default router