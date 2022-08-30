@extends('layout')

@section('name_title')Редактирование клиента@endsection

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

<div id="app">
    <Administration :status="'edit'" :car="{{app('request')->id}}" ></Administration>
<div>

@endsection
