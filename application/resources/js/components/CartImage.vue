<template>
    <div>
        <img :src="getTeaser" :class="classes">
    </div>
</template>

<script>    
    export default {
        props: ['images', 'classes'],
        data () {
            return {                
                teaser: ''
            }
        },
        computed: {
            getTeaser: function() {                
                return this.images.length === 0 ? 'https://via.placeholder.com/500/000000/FFFFFF/?text=Placeholder Image' : this.images[0].product_image_path
            }
        },
        methods: {        
            xgetTeaser() {
                axios
                    .get('api/v1/cart')
                    .then(response => (this.cart = response.data))                
            },            
        },
        mounted() {           
            console.log('cart image mounted.')            
        }
    }
</script>