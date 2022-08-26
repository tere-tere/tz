<template>
    <h3 class="display-3">Клиенты</h3>
    <clients @ClientSelected="HandlerClientSelectedRow">

    </clients>

    <cars :cars="cars" :time="time">

    </cars>
</template>

<script>
import Clients from './view_autopark_coomponets/Clients.vue';
import Cars from './view_autopark_coomponets/Cars.vue';

export default {
    name: "ViewAutoPark",
    components: {
        Clients,
        Cars
 
    },
    methods:{
        HandlerClientSelectedRow(id){

            axios.get('/api/view_autopark/get_car', {
                params: {
                    time: id
                }
            }).then(response => {
                this.cars = response.data['cars'];
                this.time = response.data['time'];
            });
        }
    },
    data() {
        return {
            cars: [],
            time:null
        };
    }
}

</script>
<style scoped>

</style>
