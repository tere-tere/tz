
@extends('layout')
@section('name_title')Администрирование@endsection


@section('layout_content')
    {{-- hook status  --}}
    @if (session()->has('status'))
        <div class="alert alert-success">
                <ul>
                    <li>{{session('status')}}</li>
                </ul>
        </div>
    @endif

    <!-- init table -->
    <table class="table align-middle mb-0 bg-white text-center">
        <thead class="bg-light">
            <tr>
                <th>ФИО</th>
                <th>Марка/Госномер</th>
                <th>Телефон</th>
                <th>Редактировать</th>
                <th>Удалить</th>
                </tr>
        </thead>
    {{-- парсинг $clients и вставка в таблицу --}}
    @foreach($clients as $client)
        <tr>
        <td>
            <p class="fw-bold mb-1">{{$client->fio}}</p>
        </td>
        <td>
            <p class="fw-normal mb-1">{{$client->mark}}/{{$client->gos_number}}</p>
        </td>
        <td>
            <span class="badge badge-success rounded-pill d-inline">{{$client->phone}}</span>
        </td>
        <td>
            <form action="{{route('edit_client_form',['id'=>$client->id])}}" method="GET">
                @csrf
                <button type="submit" name="btn_edit" value="submit" class='btn'><img src="{{URL('img/edit.png') }}" width="35px" height="35px" ></button>
            </form>
        </td>
        <td>
            <form action="{{route('del_client',['id'=>$client->id])}}" method="GET">
                @csrf
                <button type="submit" name="btn_del"  class='btn'><img src="{{URL('img/del.png') }}" width="35px" height="35px"></button>
                </form>
        </td>
        </tr>
    @endforeach
    </table>

    <div class="row ">
        {{--call pagination --}}
        <div class="col float-left">
            {{$clients->links()}}
        </div>
        {{-- jump on form_client --}}
        <div class="col-2">
            <form action="{{route('add_client_form')}}" method="GET">
                @csrf
                <button type="submit"  class='btn btn-primary float-right text-white border'><b>Добавить клиента</b></button>
            </form>
        </div>
    </div>



    <div>
    </div>
@endsection
