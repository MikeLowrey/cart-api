<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">Start</div>
                    <router-link :to="{ name: 'pages/user-cart' }">cart</router-link>                    
                    <router-link :to="{ name: 'pages/products' }">products</router-link>
                    <router-view style="margin-top:100px"></router-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {           
            console.log('Start Component mounted.')


            //axios.get('sanctum/csrf-cookie', {
            //    withCredentials: true,
            //    headers: {
            //        'Accept': 'application/json',
            //        'Content-Type': 'application/json',
            //    },
            //}   ).then(res => console.log('res', res));
        }
    }
</script>
