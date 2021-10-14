<template>
    <div class="container mx-auto flex items-center flex-wrap pt-4 pb-12">
        <!-- product listing block-->
        <div class="w-full sm:w-1/3 md:w-1/3 xl:w-1/4 p-6 flex flex-col" v-for="p in products" :key="p.id">
            <a @click.prevent="addToCart(p)" class="cursor-pointer">
                <cartImage :images="p.images" classes="hover:grow hover:shadow-lg" />
                <div class="pt-3 flex items-center justify-between">
                    <p class="uppercase">{{ p.name }}</p>
                    <div @click.prevent="addToCart(p)">
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus-circle" class="fill-current hover:text-black svg-inline--fa fa-plus-circle fa-w-16" width="24" height="24" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276c0 6.6-5.4 12-12 12h-92v92c0 6.6-5.4 12-12 12h-56c-6.6 0-12-5.4-12-12v-92h-92c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h92v-92c0-6.6 5.4-12 12-12h56c6.6 0 12 5.4 12 12v92h92c6.6 0 12 5.4 12 12v56z"></path></svg>
                    </div>
                </div>
                <p class="pt-1 text-gray-900">{{ p.price / 100}} EUR</p>
            </a>
        </div>
        <!-- product listing block end -->                    
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
            }
        },
        computed: {
            getCustomerCart: function() {
                return this.cart.products 
            },
            getCartCount: function() {                    
                return this.cart ? this.cart.products.length : 0
            }
        },
        methods: {
            updateData() {
                this.getCart()
            },     
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
                bodyFormData.append('action', 1)
                axios.post('api/v1/cart', bodyFormData, {                        
                    headers: {
                        Accept: 'application/json',
                        'Content-Type': 'application/json',
                    },
                }).then(res => { 
                    this.getCart()
                    this.$emit('updateData')
                });

            },                
        },
        mounted() {           
            console.log('default page mounted.')
            this.getProducts()
            this.getCart()
        }
    }
</script>
