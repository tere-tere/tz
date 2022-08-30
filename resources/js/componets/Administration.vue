<template>

    <EditClientForm  v-if="status == 'edit'" :car="car"></EditClientForm>
    <AddClientForm v-if="status == 'add'"></AddClientForm>

</template>

<script>
import EditClientForm from "./administration_componets/EditClientForm.vue";
import AddClientForm from "./administration_componets/AddClientForm.vue";
export default {
    name: "Administration",
    props:{
        car:{},
        status:null,
    },
    components:{
        AddClientForm,
      EditClientForm
    },
    data() {
        return {
            time:null,
            cars:[]
        };
    },

}
</script>

<style scoped>

</style>
