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

<div id="app">
    <Administration :car="[]" :status="'add'"></Administration>
</div>

@endsection
