<template>
    <div class="container mx-auto pt-4 pb-12 px-10">
        <div class="pb-12">
            <br/>
            <h2>Products: {{ getProductsCount }}</h2>
            <h2>
                Current Session Carts: {{ getSessionCartsCount }} 
                <button @click.prevent="isHiddenSessionCarts = !isHiddenSessionCarts" 
                    class="bg-black text-xs text-white px-2 py-1 rounded-md hover:bg-gray-800 transition-all duration-300">
                    <span v-text="isHiddenSessionCarts ? 'Hide' : 'Show'"></span> all User Carts
                </button>
            </h2>            
            <pre 
                class="bg-gray-100 m-10 p-2 rounded-md " 
                v-show="isHiddenSessionCarts">{{ sessionCarts }}                
            </pre>

            <button @click.prevent="destroyAllSessions" 
                class="bg-red-500 text-xs text-white px-2 py-1 rounded-md hover:bg-gray-800 transition-all duration-300">
                Destroy all Sessions
            </button>
            
        </div>
        
    </div>
</template>

<script>
    import cartImage from '../components/CartImage.vue'
    export default {
        components: {
            cartImage
        },
        data () {
            return {
                products: null,
                cart: null,
                sessionCarts: null,
                isHiddenSessionCarts: false,
            }
        },
        computed: {
            getSessionCartsCount: function() {                    
                return this.sessionCarts ? this.sessionCarts.count : 0
            },
            getProductsCount: function() {
                return this.products ? this.products.length : 0
            }
        },
        methods: {
            updateData() {
                this.getCart()
            },     
            getSessionCarts() {
                axios
                    .get('api/admin/get-all-current-carts')
                    .then(response => (this.sessionCarts = response.data))                
            },
            getProducts() {
                axios
                    .get('api/v1/products')
                    .then(response => (this.products = response.data))
            },
            destroyAllSessions() {
                axios
                    .delete('api/admin/destroy-all-sessions')
                    .then(() => {
                        this.$emit('updateData')
                        this.getSessionCarts()
                    })
            }
        },
        mounted() {           
            console.log('start page mounted.')
            this.getProducts()
            this.getSessionCarts()
        }
    }
</script>
