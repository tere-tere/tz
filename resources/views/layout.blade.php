<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('name_title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <nav class="py-2 bg-light border-bottom">
        <div class="container d-flex flex-wrap justify-content-center">
        <nav class="nav ">
            <a href="/administration" class="nav-link link-dark px-2">Администрирование</a>
            <a href="/view_autopark" class="nav-link link-dark px-2">Просмотр Автостоянки</a>
            
            <form class="mt-2" method="POST" action="{{ route('logout') }}">
                @csrf
                <!-- {{ Auth::user()->name }} -->
                <!-- <a href="" class="nav-link link-red">{{ Auth::user()->name }}</a> -->
                <x-dropdown-link :href="route('logout')" class='' onclick="event.preventDefault(); this.closest('form').submit();">
                    {{ Auth::user()->name }}
                </x-dropdown-link>
            </form> 
        </nav>

        <!-- {{ Auth::user()->name }}
        </div>
                          
                        <!-- Authentication -->
                        <!-- <form method="POST" action="{{ route('logout') }}"> -->
                            <!-- @csrf -->
<!--  -->
                                <!-- {{ __('Log Out') }} -->
                        <!-- </form> --> 
            </div>
        </div>
    </nav>

@yield('layout_content')
</body>
</html>