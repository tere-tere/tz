<template>
    <div name="cars_client" v-if="cars.length">
        <h3 class="display-4">Автомобили</h3>
        <table id="car_table" class="table  center-row table-striped table-bordered table-hover ">
            <thead>
            <tr class="">
                <th class="th-sm">Марка</th>
                <th class="th-sm">Модель</th>
                <th class="th-sm">Цвет</th>
                <th class="th-sm">Госномер</th>
                <th class="th-sm ">Присутствие машины</th>

            </tr>
            </thead>

            <tbody slot="body" class="" >
            <tr class="" v-for="car in cars" :key="time">
                <td>{{ car.mark }}</td>
                <td>{{ car.model }}</td>
                <td>{{ car.color }}</td>
                <td>{{ car.gos_number }}</td>
                <td>
                    <input class="form-check-input" type="checkbox" id="gridCheck1" v-model="car_in_place" :checked="car.car_in_place" >
                    <input class="hidden" type="hidden" name="time" value={{time}}>
                    <input type="hidden" name="car_in_place" value="off">
                </td>
                <td>
                    <button type="submit" name="btn_del"  class="btn btn-light" value="save" width="35px" height="35px" @click="ChangeCarInPlace(car_in_place,time)" >Сохранить </button>
                </td>

            </tr>
            </tbody>
        </table>
    </div>


    <br>
    <br>
    <div class="add_new_car">
        <h3 class="display-4" v-if="cars.length">Добавить еще машину</h3>

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

        <table class="table center-row align-middle mb-0 text-center" v-if="cars.length">
            <thead class="bg-blend-lighten">
                <tr>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Цвет</th>
                    <th>Госномер</th>
                    <th>Присутствие машины</th>
                    <th></th>
                </tr>
            </thead>
            <tr >
                <td>
                    <input type="text" name="mark" class="form-control" id="inputAddress1" placeholder="Audi" ref="mark" >
                </td>
                <td>
                    <input type="text" name="model" class="form-control" id="inputAddress2" placeholder="S1" ref="model">
                </td>
                <td>
                    <input type="text" name="color" class="form-control" id="inputAddress3" placeholder="Черный" ref="color">
                </td>
                <td>
                    <input type="text" name="gos_number" class="form-control" id="inputAddress4" placeholder="В732ГГ 34" ref="gos_number">
                </td>
                <td>
                    <input class="hidden" type="hidden" name="time" value={{time}} ref="time">
                    <input type="hidden" name="car_in_place" value="off">
                    <input class="form-check-input" name="car_in_place" type="checkbox" id="gridCheck1" ref="car_in_place">
                </td>
                <td>
                    <button type="submit" name="btn_del"  class="btn btn-light" value="save" width="35px" height="35px" @click="AddNewCar(this.$refs)"> Добавить </button>
                </td>
            </tr>
        </table>
    </div>
</template>

<script>
export default {
    name: "Cars",
    data() {
        return {
            errors: null,
        }
    },
    props:{
        id_client: null,
        cars: [],
        time: null

    },
    methods:
    {
        ChangeCarInPlace(car_in_place,time)
        {
            axios.post('/api/view_autopark/change_cip', {
                    car_in_place: car_in_place,
                    time: time
            });
        },
        AddNewCar(new_car)
        {
            // console.log(new_car);
            axios.post('/api/view_autopark/add_car', {
                mark: new_car["mark"].value,
                model: new_car["model"].value,
                color: new_car["color"].value,
                gos_number: new_car["gos_number"].value,
                car_in_place: new_car["car_in_place"].checked,
                time: this.time
            }).then(response => {
               this.cars.push({
                   mark: new_car["mark"].value,
                   model: new_car["model"].value,
                   color: new_car["color"].value,
                   gos_number: new_car["gos_number"].value,
                   car_in_place: new_car["car_in_place"].checked
               });
3

                this.$refs.mark.value = null;
                this.$refs.model.value = null;
                this.$refs.color.value = null;
                this.$refs.gos_number.value = null;
                this.$refs.car_in_place.value = null;
                alert("Машина была добавлена!");
            }).catch(errors =>{
                  console.log(errors);
                  this.errors = errors.response.data;
            });

        }

    }


}
</script>

<style scoped>

</style>
