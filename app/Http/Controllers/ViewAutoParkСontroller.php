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
//        return view('view_autopark',['clients_car'=>$this->GetClientsAndCar()]);
        return view('view_autopark');
    }
    public function GetClients()
    {
        $clients = DB::table('clients')
                        ->get();


        //тут шифруем телефоны и там добавляем в таблицу, чтоб нельзя было подменить
        foreach($clients as $client)
        {
            $client->time = Crypt::encryptString($client->phone);
        }

        return $clients;
    }

    public function ChangeCarInPlace(Request $req)
    {

        DB::table('client_cars')->where('client_cars.gos_number','=',$req->gos_number)->update(['client_cars.car_in_place'=>($req->car_in_place) ? 1 : 0]);
        return response()->json(['status'=>'Машина добавлена!']);
    }
    public function GetDefinedCar(Request $req)
    {
        //при запросе(с арг телефоном) выдает все машины килента
        //phone = time
        $client_id = DB::table('clients')
                            ->where('clients.id','=',  $req->id)
                            ->get('id')[0]->id;

        $cars = DB::table('client_cars')
                            ->where('client_cars.client_id','=',$client_id)
                            ->select('client_cars.mark','client_cars.model','client_cars.color','client_cars.gos_number','client_cars.car_in_place')
                            ->get();



        // добавляем time а в него шифруем gos_number, нужно нельзя было подделать, т.е. в таблице подменить
        foreach($cars as $car)
        {
            $car->time= Crypt::encryptString($car->gos_number);
        }

        //phone нужен для add form чтоб нельзя было подменить клиента
        return  ['cars'=>$cars,'id'=>$client_id];
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
            return response($validator->errors())->setStatusCode(500);//back()->withErrors($validator->errors())->withInput();
        }
        $client_id = DB::table('clients')
                            ->where('clients.id','=',$req->id)
                            ->get('id')[0]->id;

        $data = [
            'client_id'=>$client_id,
            'mark'=>$req->mark,
            'model'=> $req->model,
            'color'=> $req->color,
            'gos_number'=> $req->gos_number,
            'car_in_place'=> $req->car_in_place ? 1 : 0
        ];

        DB::table('client_cars')->insert($data);

        return back()->with('status','Успешно добавлено!');

    }
}
