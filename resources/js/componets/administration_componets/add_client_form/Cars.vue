<template>
    <h2 class="bg-primary text-white p-3 mb-2 text-white">Машина клиента</h2>
    <div id="car_clients" v-for="(car,index) in cars">
        <div :id="'car_client'+index" >
            <div class="bg-primary  p-3 mb-2 form-row" v-if="index > 0">
                <div class='col-6'>
                    <h2 class='bg-primary text-white'>Еще машина клиента</h2>
                </div>
                <div class='col-6'>
                    <button type="button" name="btn_remove" :key="index" class='btn float-right btn_remove' @click="DelInputNewCar(car)">
                        <img :src="'/img/del.png'" width="35" height="35">
                    </button>
                </div>
            </div>

            <div class="form-row">
                <div class='col-6'>
                    <label for="inputAddress2">Марка</label>
                    <input type="text" name='mark' class="form-control" id="inputAddress2" placeholder="Audi" v-model="cars[index].mark">
                </div>
                <div class='col-6'>
                    <label for="inputAddress">Модель</label>
                    <input type="text" name='model' class="form-control" id="inputAddress" placeholder="S1" v-model="cars[index].model">
                </div>
            </div>

            <div class="form-row">
                <div class='col-6'>
                    <label for="inputAddress2">Цвет</label>
                    <input type="text" name='color' class="form-control" id="inputAddress2" placeholder="Черный"  v-model="cars[index].color">
                </div>
                <div class='col-6'>
                    <label for="inputAddress">Госномер</label>
                    <input type="text" name='gos_number' class="form-control" id="inputAddress" placeholder="В732ГГ 34" v-model="cars[index].gos_number">
                </div>
            </div>

            <br>
            <div class="form-row">
                <div class="col-sm-2">Статус автомобиля</div>
                <div class="form-check">
                    <input type="hidden" name="car_in_place" value="off">
                    <input class="form-check-input" name='car_in_place' type="checkbox" id="gridCheck1" value="on"  v-model="cars[index].car_in_place">
                </div>
            </div>
        </div>
    </div>
    <br>

    <button type="button" name="add" id="add" class="btn btn-primary" @click="AddInputNewCar()">Добавить еще машину</button>

</template>

<script>
export default {
    name: "Cars",
    data() {
        return {
            cars: []
        }
    },
    created() {
        this.cars.push(
            {
                mark:'',
                model:'',
                color:'',
                gos_number:'',
                car_in_place:0
            }
        );
    },
    methods: {

        AddInputNewCar()
        {
            this.cars.push(
                {
                    mark:'',
                    model:'',
                    color:'',
                    gos_number:'',
                    car_in_place:0
                }
            );
            this.$forceUpdate();
        },
        DelInputNewCar(car)
        {
            this.cars.pop(car);
            this.$forceUpdate();
        },
    }
}
</script>

<style scoped>

</style>
