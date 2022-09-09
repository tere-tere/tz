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
                <div class="col-6">
                    <label for="inputAddress2">Марка</label>
                    <select class="form-control" v-model="cars[index].mark" @input="onChangeMark($event,cars[index])">
                        <option v-for="mark in marks">
                            {{ mark.name }}
                        </option>
                    </select>
                </div>
                <div class="col-6">
                    <label for="inputAddress2">Модель</label>
                    <select class="form-control" v-model="cars[index].model">
                        <option v-for="model in models"  :key="model.name">
                            {{ model.name }}
                        </option>
                    </select>
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
            cars: [],
            marks: [],
            models: [],
            selected_mark: ''
        }
    },
    mounted() {
        axios.get('/api/handbookcar/get_marks').then(response => {
            this.marks = response.data;
        });

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
        GetAndSetModelsInSelect(name,car)
        {
            axios.get('/api/handbookcar/get_models',{
                params: {
                    name: name
                }
            }).then(response => {
                if(car != null) {
                    car.model = response.data[0].name;
                }
                this.models = response.data;
            });
        },
        onChangeMark(selected,car)
        {
            this.GetAndSetModelsInSelect(selected.target.value,car);
        },
        AddInputNewCar()
        {
            this.cars.push(
                {
                    mark: '',
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
