<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
<button @click.prevent="clearCart()">Clear whole Cart</button>
                    <div class="card-header">Products</div>
                    <router-link :to="{ name: 'pages/user-cart' }">cart</router-link>
                    <router-link :to="{ name: 'pages/products' }">products</router-link>
                    <router-view style="margin-top:100px"></router-view>                    
                    <div v-if="cart">
                        Cart: {{ getCustomerCart.length }} | 
                        <button @click.prevent="clearCart()">Clear whole Cart</button>
                    </div>
                    <div v-else> loading ...</div>
                        <div>
                            <ul v-for="p in products" :key="p.id">
                                <li>
                                    <button @click="get(p)">{{ p.name }}</button>
                                    <button @click="destroy(p)">DELETE</button>
                                    <button @click="addToCart(p)">Add2Cart</button>
                                    <button @click="removeFromCart(p)">RemoveFromCart</button>
                                </li>
                            </ul>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                products: null,
                cart: null,
            }
        },
        computed: {
            getCustomerCart: function() {
                return this.cart.products 
            }
        },
        methods: {
            getCart() {
                axios
                    .get('api/v1/cart')
                    .then(response => (this.cart = response.data))                
            },
            getProducts() {
                axios
                    .get('api/v1/products')
                    .then(response => (this.products = response.data))
            },
            addToCart(product) {
                const bodyFormData = new FormData()
                bodyFormData.append('product_id', product.id)                
                console.log('bodyFormData', bodyFormData) 
                axios.post('api/v1/cart', bodyFormData, {                        
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                }).then(res => this.getCart());

            },
            removeFromCart(product) {
                axios
                    .delete('api/v1/cart' + '/' + product.id)
                    .then((response) => {                            
                        console.log(response.data)
                        this.getCart()
                    })
            },
            clearCart() {
                axios
                    .delete('api/v1/cart')
                    .then((response) => {                            
                        console.log(response.data)
                        this.getCart()
                    })                
            }
        },
        mounted() {

            this.getProducts()
            this.getCart()            
        }
    }
</script>
