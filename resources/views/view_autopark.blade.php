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
        @foreach($clients_car as $client_car)
            <tr>
                <td>{{$client_car->fio}}</td>
                <td>{{$client_car->gender}}</td>
                <td>{{$client_car->phone}}</td>
                <td>{{$client_car->address}}</td>
            </tr>
        @endforeach
    </tbody>
    </table>


    {{-- show car/s client --}}
    <h3 class="display-4">Автомобили</h3>
    <div id='car_clients'>
       

    </div>
        
    <script>
        // selected row in table
        $('#client_table').on('click', 'tbody tr', function(event) {
            $(this).addClass('table-success').siblings().removeClass('table-success');

            //send gos_number get car client
            let phone = this.getElementsByTagName('td')[2].innerHTML;

            let token = '@csrf';
            token = token.substr(42, 40);
            $.ajax({
                type: "GET",
                url: `{{ route('get_car') }}`,
                data: {'_token':token ,'phone':phone},
                success: function(response)
                {
                    // console.log(response);
                    $('#car_clients').html('');
                    $('#car_clients').append(response);
                }

                });
        });
        
        //add search,scroll, off nav to table clients
        $(document).ready(function () {
        $('#client_table').DataTable({  
            "searching": true,
            "bPaginate": false,
            "pageLength":2,
            "scrollY": '150px',
            "scrollCollapse": true,
             "paging": false,

        });
        });

        
    </script>
@endsection