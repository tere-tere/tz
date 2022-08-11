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
        

        //тут шифруем телефоны и там добавляем в таблицу, чтоб нельзя было подменить
        foreach($clients_car as $client)
        {
            $client->time = Crypt::encryptString($client->phone);
        }

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
        //при запросе(с арг телефоном) выдает все машины килента
        $id_client_car = DB::table('clients')
                            ->where('clients.phone','=',  Crypt::decryptString($req->phone))
                            ->get('id_client_car')[0]->id_client_car;

        $cars = DB::table('client_cars')
                            ->where('client_cars.id_client_car','=',$id_client_car)
                            ->select('client_cars.mark','client_cars.model','client_cars.color','client_cars.gos_number','client_cars.car_in_place')
                            ->get();



        // добавляем time а в него шифруем gos_number, нужно нельзя было подделать, т.е. в таблице подменить
        foreach($cars as $car)
        {
            $car->time= Crypt::encryptString($car->gos_number);
        }

        //phone нужен для add form чтоб нельзя было подменить клиента
        return  ['cars'=>$cars,'time'=>$req->phone];
    }
    public function GetRules()
    {

        return $rules = [
            'mark' => 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-ЯёЁ]+$/u',
            'model' => 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-ЯёЁ]+$/u',
            'color' => 'required|max:50|regex:/^[a-zA-Zа-яА-ЯёЁ]+$/u',
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
