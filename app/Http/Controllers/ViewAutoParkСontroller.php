<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class ViewAutoParkСontroller extends Controller
{
    public function ViewAutoPark()
    {
        return view('view_autopark',['clients_car'=>$this->GetClientsAndCar()]);
    }
    public function GetClientsAndCar()
    {
        $clients_car = DB::table('clients')
                        ->select('fio','gender','phone','address')
                        ->get();
        
        return $clients_car;
    }

    public function ChangeCarInPlace(Request $req)
    {
        $gos_number =  Crypt::decryptString($req->time);
        DB::table('client_cars')->where('client_cars.gos_number','=',$gos_number)->update(['client_cars.car_in_place'=>($req->car_in_place == 'on') ? 1 : 0]);
        return back()->withInput();
    }
    public function GetDefinedCar(Request $req)
    {
        $id_client_car = DB::table('clients')
                            ->where('clients.phone','=',$req->phone)
                            ->get('id_client_car')[0]->id_client_car;

        $cars = DB::table('client_cars')
                            ->where('client_cars.id_client_car','=',$id_client_car)
                            ->select('client_cars.mark','client_cars.model','client_cars.color','client_cars.gos_number','client_cars.car_in_place')
                            ->get();

        $form_table = [];
        //формирование формы машин клиента
        for($i = 0; $i < count($cars->all()); $i++)
        {   
            $form_table[$i] ='<div id=car' . $i . '>' . "<form action=". route('change_cip') . " method='POST' id=form" . $i . ">" .@csrf_field()  . "</form>" .
            '<table class="table-sm align-middle mb-0 bg-white text-center">
            <thead class="bg-light">
                <tr>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Цвет</th>
                    <th>Госномер</th>
                    <th>Присутствие машины</th>
                </tr>
            </thead>
            <tr>' . 
                '<td>' . $cars[$i]->mark . '</td>'  .
                '<td>' . $cars[$i]->model . '</td>' .
                '<td>' . $cars[$i]->color. '</td>' .
                '<td>' . $cars[$i]->gos_number . '</td>' .
                '<td>' . 
                '<input class="hidden" type="hidden" name="time" value=' . Crypt::encryptString($cars[$i]->gos_number)  . ' form=form' . $i .  '>' .
                '<input type="hidden" name="car_in_place" value="off">' .
                '<input class=form-check-input" name="car_in_place" type="checkbox" id="gridCheck1" value="on" form=form' . $i . ' ' .  (($cars[$i]->car_in_place == 1) ? 'checked' : 'unchecked') . '></td>' .
                '<td><button type="submit" name="btn_del"  class="btn btn-light" value="save" width="35px" height="35px" form=form' .$i . ">" . "Сохранить</button>" . '</td>' .
            '</tr>
            </table>
            </div><br>';

        }
    
        //форма для добавление еще машины.
        $add_form_car = '<div id=car' . $i . '>' . "<form action=". route('add_car') . " method='POST' id=form" . $i . ">" .@csrf_field()  . "</form>" .
        '<table class="table-sm align-middle mb-0 bg-white text-center">
        <thead class="bg-light">
            <tr>
                <th>Марка</th>
                <th>Модель</th>
                <th>Цвет</th>
                <th>Госномер</th>
                <th>Присутствие машины</th>
            </tr>
        </thead>
        <tr>' . 
            '<td>' . '<input type="text" name="mark" class="form-control" id="inputAddress1" placeholder="Audi" form=form' . $i  . '></td>' .
            '<td>' . '<input type="text" name="model" class="form-control" id="inputAddress2" placeholder="S1" form=form' . $i . '></td>' .
            '<td>' . '<input type="text" name="color" class="form-control" id="inputAddress3" placeholder="Черный" form=form' . $i . '></td>' .
            '<td>' . '<input type="text" name="gos_number" class="form-control" id="inputAddress4" placeholder="В732ГГ 34" form=form' . $i . '></td>' .
            '<td>' . '<input type="hidden" name="car_in_place" value="off">' .
            '<input type="checkbox" name="car_in_place" class="form-control" id="inputAddress5" placeholder="Audi" value="on" form=form' . $i .  ' checked></td>' .
            '<td><button type="submit" name="btn_del"  class="btn btn-light border" value="save" width="35px" height="35px" form=form' .$i . ">" . "Добавить</button>" . '</td>' .
            '<input class="hidden" type="hidden" name="time" value=' . Crypt::encryptString($req->phone)  . ' form=form' . $i .  '>' .
        '</tr>
        </table>
        </div><br>';

        $form_table[$i] = $add_form_car;

        return  $form_table;
    }
    public function GetRules()
    {
        return $rules = [
            'mark' => 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u',
            'model' => 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-Я]+$/u',
            'color' => 'required|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u',
            'gos_number' => 'required|max:9|unique:client_cars,gos_number',
        ];
    }
    public function AddCar(Request $req)
    {
        //проверка
        $validator = Validator::make($req->all(), $this->GetRules());
        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        //time = phone
        $id_client_car = DB::table('clients')
                            ->where('clients.phone','=',Crypt::decryptString($req->time))
                            ->get('id_client_car')[0]->id_client_car;

        $data = [
            'id_client_car'=>$id_client_car,
            'mark'=>$req->mark,
            'model'=> $req->model,
            'color'=> $req->color,
            'gos_number'=> $req->gos_number,
            'car_in_place'=> ($req->car_in_place == 'on') ? 1 : 0
        ];

        DB::table('client_cars')->insert($data);

        return back()->with('status','Успешно добавлено!');

    }
}
