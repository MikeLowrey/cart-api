<template>
    <div class="inline-block min-w-full overflow-hidden">
        <userCart/>
    </div>    
</template>

<script>
import userCart from '../components/CartComponent.vue'
export default {    
    name: 'user-cart',
    components: {
        userCart
    },
    data () {
        return {
        }
    },
    methods: {        
    },
    mounted() {            
        console.log('Page UserCart mounted.')   
    }
}
</script>