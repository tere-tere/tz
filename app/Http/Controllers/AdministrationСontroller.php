<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
class AdministrationСontroller extends Controller
{
    public function GetRules()
    {
        return $rules = [
            'fio'=>'required|min:3|max:100|regex:/^[а-яА-Я\s]+$/u',
            'gender'=> 'required',
            'phone'=> 'required|min:11|max:15|regex:/^([0-9]*)$/|unique:clients,phone',
            'address'=> 'required|max:100|regex:/^([0-9\А-Яа-я\s\.]*)$/u',
            'mark' => 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u',
            'model' => 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-Я]+$/u',
            'color' => 'required|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u',
            'gos_number' => 'required|max:9|unique:client_cars,gos_number',
            'cars.*.mark'=> 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u',
            'cars.*.model'=> 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-Я]+$/u',
            'cars.*.color'=> 'required|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u',
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

    public function EditClientForm(Request $req)
    {
        $data=(object)$this->GetClientAndCar($req->phone,$req->gos_number);
        return view('edit_client_form',['data'=>$data]);
    }


    public function GetClientAndCar($phone,$gos_number)
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
        //set new rules
        $rules = $this->GetRules();
        $rules['phone']  = 'required|min:11|max:15|regex:/^([0-9]*)$/|';
        $rules['gos_number'] = 'required|max:9';
        $rules['add_cars.*.mark'] = 'required|min:2|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u';
        $rules['add_cars.*.model'] = 'required|max:50|regex:/^[0-9\s\a-zA-Zа-яА-Я]+$/u';
        $rules['add_cars.*.color'] = 'required|max:50|regex:/^[a-zA-Zа-яА-Я]+$/u';
        $rules['add_cars.*.gos_number'] = 'required|max:9|unique:client_cars,gos_number';
        $rules['add_cars.*.car_in_place'] = 'required';

        $validator = Validator::make($req->all(), $rules);
        $old_phone = Crypt::decryptString($req->date);
        $old_gos_number = Crypt::decryptString($req->time);
        
        //check errors
        $errors = $validator->errors();
        if( DB::table('clients')->where('phone','=',$req->phone)->exists()){
            $errors->add('phone','The phone has already been taken');
        }

        if ($validator->fails()) {
            return view('edit_client_form',['data'=>$req,'errors'=>$validator->errors()]);
        }
        

        //change client 
        $data = [
            'fio'=>$req->fio,
            'gender'=> $req->gender,
            'phone'=> $req->phone,
            'address'=> $req->address
        ];
        
        $db_clients = DB::table('clients')->where('phone','=',$old_phone);
        $id_client_car = $db_clients->get()[0]->id_client_car;
        $db_clients->update($data);

        //change first car
        $data = [
            'id_client_car'=>$id_client_car,
            'mark'=>$req->mark,
            'model'=> $req->model,
            'color'=> $req->color,
            'gos_number'=> $req->gos_number,
            'car_in_place'=> ($req->car_in_place == 'on') ? 1 : 0
        ];    

        DB::table('client_cars')->where('gos_number','=',$old_gos_number)->update($data);

        //add new car 
        if($req->has('add_cars'))
        {
            foreach($req->add_cars as $new_car)
            {
                $data = [
                    'id_client_car'=>$id_client_car,
                    'mark'=>$new_car['mark'],
                    'model'=> $new_car['model'],
                    'color'=> $new_car['color'],
                    'gos_number'=> $new_car['gos_number'],
                    'car_in_place'=> ($new_car['car_in_place'] == 'on') ? 1 : 0
                ];  
                DB::table('client_cars')->insert($data);
            }
        }

        return redirect('administration')->with('status','Успешно сохранено!');
    }

    public function AddClient(Request $req)
    {
        // @dd($req->all()); 
        $rules = $this->GetRules();
        $rules['address'] = '';
        $rules['mark'] = '';
        $rules['model'] = '';
        $rules['color'] = '';
        $rules['gos_number'] = '';
        $validator = Validator::make($req->all(), $rules);
        if ($validator->fails()) {
            return view('add_client_form',['data'=>$req->all(),'errors'=>$validator->errors()]);
        }

        $data = [
            'fio'=>$req->fio,
            'gender'=> $req->gender,
            'phone'=> $req->phone,
            'address'=> $req->address
        ];

        $id_client_car = DB::table('clients')->insertGetId($data);

        foreach($req->cars as $car)
        {   
            if(!array_key_exists('car_in_place',$car))
            {
                $car['car_in_place'] = 'off';
            }
            $data = [
                'id_client_car'=>$id_client_car,
                'mark'=>$car['mark'],
                'model'=> $car['model'],
                'color'=> $car['color'],
                'gos_number'=> $car['gos_number'],
                'car_in_place'=> ($car['car_in_place'] == 'on') ? 1 : 0
            ];    

            DB::table('client_cars')->insert($data);
        }
        return redirect('administration')->with('status','Успешно добавлено!');
    }
    public function GetClients()    
    {
        $clients = DB::table('clients')
                        ->join('client_cars','clients.id_client_car','=','client_cars.id_client_car')
                        ->select('clients.fio','clients.phone','client_cars.mark','client_cars.gos_number')
                        ->paginate(3);

        return $clients;
    }

    public function DelClient(Request $req)
    {
        $id_client_car = DB::table('clients')
                    ->where('clients.phone','=',$req->phone) //unique
                    ->get('id_client_car');
        $del_car = DB::table('client_cars')
                    ->where('client_cars.id_client_car','=',$id_client_car[0]->id_client_car) //навсякий
                    ->where('client_cars.gos_number','=',$req->gos_number)
                    ->delete();
        
        return redirect('administration');
    }
}
