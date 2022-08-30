<template>
    <h1 class="bg-primary text-white p-3 mb-2">Клиент</h1>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">ФИО</label>
            <input type="text" name='fio' class="form-control" id="inputEmail4" placeholder="ФИО" v-model="client.fio" >
        </div>
    </div>

    <fieldset class="form-group">
        <div class="row">
            <legend class="col-form-label col-sm-1 pt-0">Пол</legend>
            <div class="col-sm-10">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="m" :checked="client.gender == 'm'" v-model="client.gender">
                    <label class="form-check-label" for="gridRadios1">Мужчина</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="f"  :checked="client.gender == 'f'" v-model="client.gender">
                    <label class="form-check-label" for="gridRadios2">Женщина</label>
                </div>
            </div>
        </div>
    </fieldset>

    <div class="form-row">
        <div class='col-6'>
            <label for="inputAddress2">Телефон</label>
            <input type="text" name='phone' class="form-control" id="inputAddress2" placeholder="79322113212" v-model="client.phone">
        </div>
        <div class='col-6'>
            <label for="inputAddress">Адрес</label>
            <input type="text" name="address" class="form-control" id="inputAddress" placeholder="ул. Пушкина" v-model="client.address">
        </div>
    </div>
</template>

<script>
export default {
    name: "Client",
    props: {
        id:null
    },
    data(){
      return {
          client: {}
      }
    },
    created() {

    }
}
</script>

<style scoped>

</style>
