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


    <Client ref="Client"></Client>
    <br>
    <Cars ref="Cars"></Cars>
    <input type="submit" class="btn btn-success" value="Добавить" @click="AddClientAndCars()">

</template>

<script>
import Client from './add_client_form/Client.vue';
import Cars from './add_client_form/Cars.vue';
export default {
    name: "AddClientForm",
    components: {
        Client,
        Cars,
    },
    data() {
        return {
            errors:null,
            status:null
        };
    },
    methods: {
        AddClientAndCars($id)
        {
            axios.post('/api/administration/add_client_form/add', {
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
