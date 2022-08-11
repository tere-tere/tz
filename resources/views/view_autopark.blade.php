@extends('layout')

@section('name_title')Просмотр Автостоянки@endsection


@section('layout_content')

    {{-- hook error --}}
    @if($errors->any())
        <div>
            <ul>
                @foreach($errors->all() as $erorr)
                <li>
                    {{$erorr}}
                </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- hook status  --}}
    @if (session()->has('status'))
        <div class="alert alert-success">
                <ul>
                    <li>{{session('status')}}</li>
                </ul>
        </div>
    @endif


    <style type="text/css">
        .table-wrapper {
            max-height: 220px;
            overflow: auto;
            width: auto;
            display:inline-block;
        }
    </style>

    <h2 class="display-3">Клиенты</h2>
    {{-- show table clients --}}
    <table id="client_table" class="table table-striped table-bordered" cellspacing="0" >
    <thead>
        <tr>
            <th class="th-sm">ФИО</th>
            <th class="th-sm">Пол</th>
            <th class="th-sm">Телефон</th>
            <th class="th-sm">Адрес</th>
        </tr>
    </thead>
    <tbody>
        {{-- time=phone нужен  чтобы не подменили --}}
        @foreach($clients_car as $client_car)
            <tr>
                <td>{{$client_car->fio}}</td>
                <td>{{$client_car->gender}}</td>
                <td>{{$client_car->phone}}</td>
                <td>{{$client_car->address}}
                    <input class="hidden" type="hidden" name="time" value={{$client_car->time}}>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>


    {{-- show car/s client --}}
    <h3 class="display-4">Автомобили</h3>
    <div id='car_clients'>
       

    </div>

    <script>
        var last_index= 0;

        function CreateTablesCars(cars)
        {
            $('#car_clients').html('');

            cars.forEach(function(car,index){
                let table ='<div id=car' + index + '>' + "<form action={{route('change_cip')}} method='POST' id=form" + index +  ">" + '@csrf' + "</form>";
                table+= '<table class="table align-middle mb-0 bg-white text-center">';
                table+='<thead class="bg-light"> <tr> <th>Марка</th> <th>Модель</th> <th>Цвет</th> <th>Госномер</th> <th>Присутствие машины</th> </tr> </thead>'
                table+='<tr>';

                    table +='<td>' + car['mark'] + '</td>';
                    table +='<td>' + car['model'] + '</td>';
                    table +='<td>' + car['color'] + '</td>';
                    table +='<td>' + car['gos_number'] + '</td>';
                    table +='<td>' + '<input class="hidden" type="hidden" name="time" value=' + car['time']  + ' form=form' + index +  '>';
                    table +='<input type="hidden" name="car_in_place" value="off">';
                    table +='<input class=form-check-input" name="car_in_place" type="checkbox" id="gridCheck1" value="on" form=form' + index  + ' ' + ((car['car_in_place'] == 1) ? 'checked' : 'unchecked') +  '></td>';
                    table +='<td>' + '<button type="submit" name="btn_del"  class="btn btn-light" value="save" width="35px" height="35px" form=form' + index + ">" + "Сохранить</button>" + '</td>';

                table+='</tr>';
                table+='</table>';
                table+='</div><br>';
                $('#car_clients').append(table);
                last_index = index;
            });
        };
        
        function CreateAddCarTable(time)
        {
            last_index+=1;
            let table ='<br><div id=car' + last_index + '>' + "<form action={{route('add_car')}} method='POST' id=form" + last_index +  ">" + '@csrf' + "</form>";
                table+= '<table class="table align-middle mb-0 bg-white text-center">';
                table+='<thead class="bg-light"> <tr> <th>Марка</th> <th>Модель</th> <th>Цвет</th> <th>Госномер</th> <th>Присутствие машины</th> </tr> </thead>'
                table+='<tr>';

                    table+= '<td>' + '<input type="text" name="mark" class="form-control" id="inputAddress1" placeholder="Audi" form=form' + last_index  + '></td>';
                    table+= '<td>' + '<input type="text" name="model" class="form-control" id="inputAddress2" placeholder="S1" form=form' + last_index + '></td>';
                    table+= '<td>' + '<input type="text" name="color" class="form-control" id="inputAddress3" placeholder="Черный" form=form' + last_index + '></td>';
                    table+= '<td>' + '<input type="text" name="gos_number" class="form-control" id="inputAddress4" placeholder="В732ГГ 34" form=form' + last_index + '></td>';
                    table +='<td>' + '<input class="hidden" type="hidden" name="time" value=' + time + ' form=form' + last_index +  '>';
                    table +='<input type="hidden" name="car_in_place" value="off">';
                    table +='<input class=form-check-input" name="car_in_place" type="checkbox" id="gridCheck1" value="on" form=form' + last_index + 'checked></td>';
                    table +='<td>' + '<button type="submit" name="btn_del"  class="btn btn-light" value="save" width="35px" height="35px" form=form' + last_index + ">" + "Добавить</button>" + '</td>';

                table+='</tr>';
                table+='</table>';
                table+='</div>';
            $('#car_clients').append(table);
        }
        // selected row in table
        $('#client_table').on('click', 'tbody tr', function(event) {
            $(this).addClass('table-success').siblings().removeClass('table-success');

            //send time get car client
            let time = this.getElementsByTagName('td')[3].getElementsByTagName('input')[0].value;
            let token = '@csrf';
            token = token.substr(42, 40);
            $.ajax({
                type: "GET",
                url: `{{ route('get_car') }}`,
                data: {'_token':token ,'phone':time},
                success: function(response)
                {
                    // console.log(response);
                    CreateTablesCars(response['cars']);
                    CreateAddCarTable(response['time']);
                }
            });
        });
        
        //add search,scroll, off nav to table clients
        $(document).ready(function () {
        $('#client_table').DataTable({  
            "searching": true,
            "bPaginate": false,
            "pageLength":2,
            "scrollY": '250px',
            "scrollCollapse": true,
             "paging": false,

        });
        });

        
    </script>
@endsection