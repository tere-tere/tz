@extends('layout')

@section('name_title')Добавление клиента@endsection

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

{{-- mb Crypt::encrypt(url and parms) --}}
<form action="{{route('add_client')}}" method="GET">
    @csrf
    <!-- форма  -->
    <h1 class="bg-primary text-white p-3 mb-2">Клиент</h1>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail4">ФИО</label>
            <input type="text" name='fio' class="form-control" id="inputEmail4" placeholder="ФИО" value="{{$data['fio']}}">
        </div>
    </div>

    <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-1 pt-0">Пол</legend>
      <div class="col-sm-10">
        @if($data['gender'] == "m")
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="m" checked>
                <label class="form-check-label" for="gridRadios1">Мужчина</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="f">
                <label class="form-check-label" for="gridRadios2">Женщина</label>
            </div>
        @else
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gridRadios1" value="m">
                <label class="form-check-label" for="gridRadios1">Мужчина</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="gender" id="gridRadios2" value="f" checked>
                <label class="form-check-label" for="gridRadios2">Женщина</label>
            </div>
        @endif
      </div>
    </div>
    </fieldset>

    <div class="form-row">
        <div class='col-6'>
            <label for="inputAddress2">Телефон</label>
            <input type="text" name='phone' class="form-control" id="inputAddress2" placeholder="79322113212" value="{{$data['phone']}}">
        </div>
        <div class='col-6'>
        <label for="inputAddress">Адрес</label>
        <input type="text" name="address" class="form-control" id="inputAddress" placeholder="ул. Пушкина" value="{{$data['address']}}">
        </div>
    </div>

    <br>
    {{--car--}}
    <div id='car_clients'>
        @for($i = 0; $i <= count($data['cars'])-1; $i++)
            <div id='car_client{{$i}}'>
                @if($i == 0)
                    <h2 class="bg-primary text-white p-3 mb-2 text-white">Машина клиента</h2>
                @else
                    <div id='car_client{{$i}}'>
                        <div class="bg-primary  p-3 mb-2 form-row">
                                <div class='col-6'>
                                        <h2 class='bg-primary text-white' name='{{$i}}'>Еще машина клиента</h2>
                                </div>
                                <div class='col-6'>
                                    <button type="button" name="btn_remove" id='{{$i}}' class='btn float-right btn_remove'>
                                        <img src="{{URL('img/del.png') }}" width="35px" height="35px">
                                    </button>
                                </div>
                        </div>
                    </div>
                @endif
                <div class="form-row">
                    <div class='col-6'>
                        <label for="inputAddress2">Марка</label>
                        <input type="text" name='cars[{{$i}}][mark]' class="form-control" id="inputAddress2" placeholder="Audi" value="{{$data['cars'][$i]['mark']}}">
                    </div>
                    <div class='col-6'>
                        <label for="inputAddress">Модель</label>
                        <input type="text" name='cars[{{$i}}][model]' class="form-control" id="inputAddress" placeholder="S1" value="{{$data['cars'][$i]['model']}}">
                    </div>
                </div>

                <div class="form-row">
                    <div class='col-6'>
                        <label for="inputAddress2">Цвет</label>
                        <input type="text" name='cars[{{$i}}][color]' class="form-control" id="inputAddress2" placeholder="Черный" value="{{$data['cars'][$i]['color']}}">
                    </div>
                    <div class='col-6'>
                        <label for="inputAddress">Госномер</label>
                        <input type="text" name='cars[{{$i}}][gos_number]' class="form-control" id="inputAddress" placeholder="В732ГГ 34" value="{{$data['cars'][$i]['gos_number']}}">
                    </div>
                </div>

                <br>
                <div class="form-group row">
                    <div class="col-sm-2">Статус автомобиля</div>   
                    <div class="form-check">
                        <input type="hidden" name="cars[{{$i}}][car_in_place]" value="off">
                        <input class="form-check-input" name='cars[{{$i}}][car_in_place]' type="checkbox" id="gridCheck1" value='on' {{($data['cars'][$i]['car_in_place'] == 'on') ? 'checked' : 'unchecked'}}>
                    </div>
                </div>
            </div>
        @endfor
    </div>
    <button type="button" name="add" id="add" class="btn btn-primary">Добавить еще машину</button>  
    <input type="submit" class="btn btn-success" value="Отправить">


    <script>
        $(document).ready(function(){  
            var i=1;  
            $('#add').click(function(){  
                $('#car_clients').append(`<div id='car_client${[i]}'><div class="bg-primary  p-3 mb-2 form-row"><div class='col-6'><h2 class='bg-primary text-white' name='${[i]}'>Еще машина клиента</h2></div><div class='col-6'><button type="button" name="btn_remove" id='${[i]}' class='btn float-right btn_remove'><img src="{{URL('img/del.png') }}" width="35px" height="35px"></button></div></div></div>`);
                $(`#car_client${[i]}`).append(`<div class='form-row'><div class='col-6'> <label for='inputAddress2'>Марка</label> <input type='text' name='cars[${[i]}][mark]' class='form-control' id='inputAddress2' placeholder='Audi'> </div> <div class='col-6'> <label for='inputAddress'>Модель</label> <input type='text' name='cars[${[i]}][model]' class='form-control' id='inputAddress' placeholder='S1'> </div> </div> <div class='form-row'> <div class='col-6'> <label for='inputAddress2'>Цвет</label> <input type='text' name='cars[${[i]}][color]' class='form-control' id='inputAddress2' placeholder='Черный'> </div> <div class='col-6'> <label for='inputAddress'>Госномер</label> <input type='text' name='cars[${[i]}][gos_number]' class='form-control' id='inputAddress' placeholder='В732ГГ 34'> </div> </div> <br> <div class='form-group row'> <div class='col-sm-2'>Статус автомобиля</div> <div class='form-check'> <input type="hidden" name='cars[${[i]}][car_in_place]' value="off"> <input class='form-check-input' name='cars[${[i]}][car_in_place]' type='checkbox' id='gridCheck1' value="on" checked> </div></div`);
                i++;
             });  

            $(document).on('click', '.btn_remove', function(){  
                var button_id = $(this).attr("id");  
                $(`#car_client${[button_id]}`).remove();  
                i--;
            });  
    
        });  
    </script>

</form>
@endsection
