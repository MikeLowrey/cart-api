<template>
    <div>
        Your User Cart
        x{ { cart } }y
        <div v-if="cart">Your Cart {{ getCustomerCart.length }}
            <div v-for="item in getCustomerCart" :key="item.id">
                { { setImage(item.images) } }
                {{item.name}} - {{ item.price / 100 }} x {{ item.amount }} = {{ item.price_sum / 100}} EUR
            </div>
            <p>Summ: {{ getCartSum }} EUR</p>
        </div>
        <div v-else> loading ...</div>
        <cartOverview />
    </div>
    
</template>

<script>
import cartOverview from '../components/CartComponent.vue'
export default {    
    name: 'user-cart',
    components: {
        cartOverview
    },
    data () {
        return {            
            cart: null,
        }
    },
    computed: {
        getCustomerCart: function() {
            return this.cart.products 
        },
        getCartSum: function() {
            const sumArr = this.cart.products.map((item) => {
                return parseInt(item.price_sum)
            })
            console.log(sumArr)
            return sumArr.reduce((a, b) => a + b, 0) / 100;
        }
    },
    methods: {
        getCart() {
            axios
                .get('api/v1/cart')
                .then(response => {                    
                    this.cart = response.data                    
                })
        },
        getProduct() {
            axios
                .get('api/v1/products')
                .then(response => (this.products = response.data))
        },
        addToCart(product) {
            console.log(product)
                axios
                    .post('api/v1/cart', {product_id: product.id})
                    .then(response => (this.cart = response.data))
        },
        removeFromCart(product) {
                axios
                    .delete('api/v1/cart' + '/' + product.id)
                    .then((response) => {                            
                        console.log(response.data)
                        this.getCart()
                    })
        }
    },
    mounted() {            
        console.log('Component mounted.')
        //this.getProduct()
        this.getCart()            
        //axios.get('api/v1/test', {
        //    //withCredentials: true,
        //    headers: {
        //        'Accept': 'application/json',
        //        'Content-Type': 'application/json',
        //    },
        //}   ).then(res => console.log('res', res));        
    }
}
</script>