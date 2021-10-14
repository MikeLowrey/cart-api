<template>    
    <div class="w-full mx-auto">
        <div class="bg-white shadow-md rounded my-6 w-full">
            <div v-if="cart">
                <table class="text-left w-full border-collapse w-full" >
                    <thead>
                        <tr>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Name</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Amount</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Price</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Item Sum</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Actions</th>
                        </tr>
                    </thead>
                    <tbody>                        
                        <tr class="hover:bg-grey-lighter" v-for="p in getCustomerCart" :key="p.id">
                            <td class="py-4 px-6 border-b border-grey-light">{{ p.name }}</td>
                            <td class="py-4 px-6 border-b border-grey-light">
                                <span @click.prevent="addToCart(p)" class="cy-add">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="plus-circle" 
                                    class="w-6 h-6 inline text-green-600 cursor-pointer" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm144 276c0 6.6-5.4 12-12 12h-92v92c0 6.6-5.4 12-12 12h-56c-6.6 0-12-5.4-12-12v-92h-92c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h92v-92c0-6.6 5.4-12 12-12h56c6.6 0 12 5.4 12 12v92h92c6.6 0 12 5.4 12 12v56z"></path></svg>                                    
                                </span> 
                                <span class="mx-2 cy-amount" >{{ p.amount }} </span>
                                <span @click.prevent="reduceCartItem(p)" data-cy="reduce">
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="minus-circle" 
                                    class="w-6 h-6 inline text-red-300 cursor-pointer" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zM124 296c-6.6 0-12-5.4-12-12v-56c0-6.6 5.4-12 12-12h264c6.6 0 12 5.4 12 12v56c0 6.6-5.4 12-12 12H124z"></path></svg>                                    
                                </span>
                            </td>                            
                            <td class="py-4 px-6 border-b border-grey-light">{{ p.price / 100 }}</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{ p.price_sum / 100 }}</td>
                            <td class="py-4 px-6 border-b border-grey-light">
                                <button @click.prevent="removeFromCart(p)" class="text-green-600 font-bold py-1 px-3 rounded text-xs bg-green hover:bg-green-dark cursor-pointer">Remove</button>
                            </td>
                        </tr>                        
                    </tbody>
                    <tfoot>
                        <tr class="bg-gray-300 font-bold">                            
                            <td></td>
                            <td></td>
                            <td class="py-4 px-6 border-b border-grey-light ">Sum</td>
                            <td class="py-4 px-6 border-b border-grey-light">{{ getCartSum }} EUR</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

                <div class="text-right w-full p-6">                    
                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" @click.prevent="clearCart()">Clear whole Cart</button>
                    <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                        Checkout
                    </button>
                </div>

            </div>
            
            <div class="text-center w-full border-collapse p-6" v-else>
                <span class="text-lg">Your cart is empty!</span>
            </div>
                        
        </div>
    </div>
</template>

<script>

export default {    
    name: 'cartComponent',
    components: {        
    },
    props: ['items'],
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
            axios
                .post('api/v1/cart', {product_id: product.id, action: 1})
                .then(response => {
                    this.cart = response.data                    
                })
        },
        reduceCartItem(product) {
            axios
                .post('api/v1/cart', {product_id: product.id, action: -1})
                .then(response => {
                    this.cart = response.data
                    this.$emit('updateData')
                })
        },
        removeFromCart(product) {
            axios
                .delete('api/v1/cart' + '/' + product.id)
                .then((response) => {                            
                    console.log(response.data)
                    this.getCart()
                    this.$emit('updateData')
                })
        },
        clearCart() {
            axios
                .delete('api/v1/cart')
                .then((response) => {                            
                    console.log(response.data)
                    this.getCart()
                    this.$emit('updateData')
                })                
        }        
    },
    mounted() {
        this.getCart()
    }
}
</script>
