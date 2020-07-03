<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/vue.js') }}"></script>
    <script src="{{ asset('js/all.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="shortcut icon"      type="image/png"       href="{{asset('/images/favicon.png')}}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <header >
            <nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/gdaylogo.png') }}" alt="good day logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto" style="text-align:center">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i class = "fas fa-lock"></i> {{ __('Staff Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('register') }}"><i class = "fas fa-user-plus"></i> {{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item {{ $variable_arr['navbar_link_active']? 'active':'' }}">
                                    <a href="/customers" class="nav-link"><i class="fas fa-address-book"></i> Customers</a>
                                </li>
                                <li class="nav-item {{ $variable_arr['navbar_link_active']? 'active':'' }}">
                                    <a href="/savings" class="nav-link"><i class="fas fa-tree"></i> Savings</a>
                                </li>
                                <li class="nav-item {{ $variable_arr['navbar_link_active']? 'active':'' }}">
                                    <a href="/loans" class="nav-link"><i class="fas fa-money-check"></i> Loan</a>
                                </li>
                                <li class="nav-item {{ $variable_arr['navbar_link_active']? 'active':'' }}">
                                    <a href="/transactions" class="nav-link"><i class="fas fa-book"></i> Transactions</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('images/staffs/'.Auth::user()->passport ) }}" alt="good day logo" width = "20px"> {{ Auth::user()->first_name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                               <!--  <li class="nav-item"><span class="navbar-text">
                                    <img src="{{ asset('images/staffs/'.Auth::user()->passport ) }}" alt="good day logo" width = "20px">
                                    </span>
                                </li> -->
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="py-4">
            @yield('content')
        </main>
        <footer>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-4 text-center">
                        <p>
                            <a href='/'>
                                <img src="{{asset('/images/gdaylogo-wtbg.png')}}" width = '90px' alt="">
                            </a>
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <p>Tel: 09062707500, 08165336990</p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <p>Enugu, Enugu State Nigeria</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    @yield('footerLinks')
</body>
</html>
