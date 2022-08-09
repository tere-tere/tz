@extends('layout')

@section('name_title')Форма клиента@endsection


@section('layout_content')
<form action="@yield('form_client_route')" m ethod="POST">
    @csrf
    <!-- это нужно, чтоб нельзя было подделать и сделать проверку -->
    <input type="hidden" id="old_fio name="old_fio" value="{{$data->fio}}">
    <input type="hidden" id="old_gender" name="old_gender" value="{{$data->gender}}">
    <input type="hidden" id="old_phone" name="old_phone" value="{{$data->phone}}">
    <input type="hidden" id="old_address" name="old_address" value="{{$data->address}}">
    <input type="hidden" id="old_mark" name="old_mark" value="{{$data->mark}}">
    <input type="hidden" id="old_model" name="old_model" value="{{$data->model}}">
    <input type="hidden" id="old_color" name="old_color" value="{{$data->color}}">
    <input type="hidden" id="old_number" name="old_number" value="{{$data->gos_number}}">
    <input type="hidden" id="old_car_in_place" name="old_car_in_place" value="{{$data->car_in_place}}">

    <!-- форма  -->
    <h1 class="bg-primary text-white p-3 mb-2">Клиент</h1>
    <div class="form-row">
        <div class="form-group col-md-6">
        <label for="inputEmail4">ФИО</label>
            <input type="text" name='fio' class="form-control" id="inputEmail4" placeholder="ФИО" value="{{$data->fio}}">
        </div>
    </div>

    <fieldset class="form-group">
    <div class="row">
      <legend class="col-form-label col-sm-1 pt-0">Пол</legend>
      <div class="col-sm-10">
        @if($data->gender == "m")
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
            <input type="text" name='phone' class="form-control" id="inputAddress2" placeholder="79322113212" value="{{$data->phone}}">
        </div>
        <div class='col-6'>
        <label for="inputAddress">Адрес</label>
        <input type="text" name="address" class="form-control" id="inputAddress" placeholder="ул. Пушкина" value="{{$data->address}}">
        </div>
    </div>

    <br>
    <h2 class="bg-primary text-white p-3 mb-2">Машина клиента</h2>

    
    <div class="form-row">
        <div class='col-6'>
            <label for="inputAddress2">Марка</label>
            <input type="text" name='mark' class="form-control" id="inputAddress2" placeholder="Audi" value="{{$data->mark}}">
        </div>
        <div class='col-6'>
            <label for="inputAddress">Модель</label>
            <input type="text" name='model' class="form-control" id="inputAddress" placeholder="S1" value="{{$data->model}}">
        </div>
    </div>

    <div class="form-row">
        <div class='col-6'>
            <label for="inputAddress2">Цвет</label>
            <input type="text" name='color' class="form-control" id="inputAddress2" placeholder="Черный" value="{{$data->color}}">
        </div>
        <div class='col-6'>
            <label for="inputAddress">Госномер</label>
            <input type="text" name='gos_number' class="form-control" id="inputAddress" placeholder="В732ГГ 34" value="{{$data->gos_number}}">
        </div>
    </div>

    <br>
    <div class="form-group row">
        <div class="col-sm-2">Статус автомобиля</div>   
        <div class="form-check">
            <input class="form-check-input" name='car_in_place' type="checkbox" id="gridCheck1" checked="{{$data->car_in_place}}">
        </div>
    </div>

    <input type="submit" class="btn btn-success" value="@yield('form_client_btn_val')">
    </form>
    @yield('form_client_content')
@endsection


