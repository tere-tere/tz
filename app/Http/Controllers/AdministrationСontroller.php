<?php

namespace App\Http\Controllers;
use App\Models\ClientCars;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class AdministrationСontroller extends Controller
{
    public function GetRules()
    {
        return $rules = [
            'fio'=>'required|min:3|max:100|regex:/^[а-яА-ЯА-ЯёЁ\s]+$/u',
            'gender'=> 'required',
            'phone'=> 'required|min:11|max:15|regex:/^([0-9]*)$/|unique:clients,phone',
            'address'=> 'required|max:100|regex:/^([0-9\А-Яа-яА-ЯёЁ\s\.\,\-]*)$/u',
            'mark' => 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-ЯА-ЯёЁ\(\)\s]+$/u',
            'model' => 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-ЯА-ЯёЁ]+$/u',
            'color' => 'required|max:50|regex:/^[a-zA-Zа-яА-ЯА-ЯёЁ]+$/u',
            'gos_number' => 'required|max:9|unique:client_cars,gos_number',
            'cars.*.mark'=> 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-ЯА-ЯёЁ\(\)\s]+$/u',
            'cars.*.model'=> 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-ЯА-ЯёЁ]+$/u',
            'cars.*.color'=> 'required|max:50|regex:/^[a-zA-Zа-яА-ЯА-ЯёЁ]+$/u',
            'cars.*.gos_number'=> 'required|max:9|unique:client_cars,gos_number',
        ];
    }

    public function GetPanelAdministration()
    {
        return view('administration',['clients'=>$this->GetClients()]);
    }

    public function AddClientForm()
    {
        $data = [
            'fio'=>'',
            'gender'=> '',
            'phone'=> '',
            'address'=> '',
            'id_client_car'=>'',
            'cars'=>[['mark'=>'',
                    'model'=> '',
                    'color'=> '',
                    'gos_number'=> '',
                    'car_in_place'=> '']]

        ];

        return view('add_client_form',['data'=>$data]);
    }

    public function EditClientForm(ClientCars $id)
    {
        return view('edit_client_form');
//        $data=(object)$this->GetClientAndCar($id);
//        return view('edit_client_form',[
//            'data'=>$data
//            'car' => $car,
//        ]);
    }
    public function GetClient(Request $req)
    {
        $client = DB::table('clients')->where('id','=',$req->id)->get();
        return response()->json($client);
    }

    public function GetClientAndCar($car_id)
    {
        $id_client_car = DB::table('clients')
                            ->where('clients.phone','=',$phone)
                            ->get('id_client_car');
        //find a certain car and user and join one table
        $db =DB::table('clients')
                ->join('client_cars','clients.id_client_car','=','client_cars.id_client_car')
                ->where('clients.id_client_car','=',$id_client_car[0]->id_client_car)
                ->where('client_cars.gos_number','=',$gos_number)
                ->get()[0];

        $data = [
            'fio'=>$db->fio,
            'gender'=> $db->gender,
            'phone'=> $db->phone,
            'address'=> $db->address,
            'id_client_car'=>$db->id_client_car,
            'mark'=>$db->mark,
            'model'=> $db->model,
            'color'=> $db->color,
            'gos_number'=> $db->gos_number,
            'car_in_place'=> $db->car_in_place,
            'add_cars' => [[]]
        ];

        return $data;
    }

    public function EditClient(Request $req)
    {
        //parse main car and new cars for add
        $rules = $this->GetRules();
        $rules['mark'] = '';
        $rules['model'] = '';
        $rules['color'] = '';
        $rules['gos_number'] = '';

        $validator = Validator::make($req->all(), $rules);
        //check errors

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $cars = $req->cars;
        $main_car = $cars[0];
        unset($cars[0]);

        //change client
        $data = [
            'fio'=>$req->fio,
            'gender'=> $req->gender,
            'phone'=> $req->phone,
            'address'=> $req->address
        ];

        $db_clients = DB::table('clients')->where('id','=',$req->id);
        $db_clients->update($data);

        //change first car
        $data = [
            'mark'=>$main_car['mark'],
            'model'=> $main_car['model'],
            'color'=> $main_car['color'],
            'gos_number'=> $main_car['gos_number'],
            'car_in_place'=> ($main_car['car_in_place']) ? 1 : 0
        ];
        $db_car = DB::table('client_cars')->where('id','=',$main_car['id']);
        $db_car->update($data);

        //add new car
        if(count($cars) != 0)
        {
            foreach($cars as $car)
            {
                $car = json_decode($car);
                $data = [
                    'mark'=>$car->mark,
                    'model'=> $car->model,
                    'color'=> $car->color,
                    'gos_number'=> $car->gos_number,
                    'car_in_place'=> ($car->car_in_place) ? 1 : 0
                ];
                DB::table('client_cars')->insert($data);
            }
        }

        return response()->json(['status'=>'Успешно сохранено!']);
    }

    public function AddClient(Request $req)
    {
        $rules = $this->GetRules();
        $rules['mark'] = '';
        $rules['model'] = '';
        $rules['color'] = '';
        $rules['gos_number'] = '';
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }

        $data = [
            'fio'=>$req->fio,
            'gender'=> $req->gender,
            'phone'=> $req->phone,
            'address'=> $req->address
        ];

        $client_id = DB::table('clients')->insertGetId($data);
        foreach($req->cars as $car)
        {
            $data = [
                'client_id'=>$client_id,
                'mark'=>$car['mark'],
                'model'=> $car['model'],
                'color'=> $car['color'],
                'gos_number'=> $car['gos_number'],
                'car_in_place'=> ($car['car_in_place']) ? 1 : 0
            ];

            DB::table('client_cars')->insert($data);
        }
        return response()->json(['status'=>'Успешно сохранено!']);
    }
    public function GetClients()
    {
        //paginate(?) сколько выводить клиентов
        $clients = DB::table('clients')
                        ->join('client_cars','clients.id','=','client_cars.client_id')
                        ->select('client_cars.id','clients.fio','clients.phone','client_cars.mark','client_cars.gos_number')
                        ->paginate(5);

        return $clients;
    }

    public function DelCarClient(ClientCars $id)
    {
        $id->delete();
        return redirect('administration');
    }
}
