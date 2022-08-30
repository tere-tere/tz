<template>
    <div id="errors-alert-container" v-if="errors != null">
        <div  class="alert novin-alert  alert-danger" >
            <b class="display-5">Errors: </b><br>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul v-for="error in errors">
                <li>
                    {{error.toString()}}
                </li>
            </ul>
        </div>
    </div>

    <div id="errors-alert-container" v-if="status != null">
        <div  class="alert novin-alert  alert-success" >
            <b class="display-5">Status: </b><br>
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <ul >
                <li>
                    {{status.toString()}}
                </li>
            </ul>
        </div>
    </div>

    <client :id="car.client_id" ref="Client">
    </client>
    <br>
    <cars :cars="[car]" ref="Cars">

    </cars>

    <input type="submit" class="btn btn-success" value="Отправить" @click="EditClientAndCars()">

</template>

<script>
import Client from "./edit_client_form/Client.vue";
import Cars from "./edit_client_form/Cars.vue";

export default {
    name: "EditClientForm",
    props:{
        car:{},
    },
    data() {
        return {
            time:null,
            errors:null,
            status:null,
            cars:[]
        };
    },
    components:{
        Client,
        Cars
    },
    methods: {
        EditClientAndCars($id)
        {
            axios.put('/api/administration/edit_client_form/edit', {
                id: this.car.id,
                fio: this.$refs.Client.client.fio,
                gender: this.$refs.Client.client.gender,
                phone: this.$refs.Client.client.phone,
                address: this.$refs.Client.client.address,
                cars: this.$refs.Cars.cars
            }).then((response) => {
                this.errors = response.data.errors;
                this.status = response.data.status;

            });
        }
    }

}
</script>

<style scoped>

</style>
