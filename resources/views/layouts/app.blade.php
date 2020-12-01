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
    <script src="{{ asset('js/axios.js') }}"></script>
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
            <img src="{{ asset('images/gdheader.png') }}" alt="good day logo" style="max-width: 100%;">
            <nav class="navbar navbar-expand-sm navbar-light bg-white shadow-sm sticky-top">
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
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i class = "fas fa-lock"></i> {{ __('Staff Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ route('register') }}"><i class = "fas fa-user-plus"></i> {{ __('Register') }}</a>
                                    </li>
                                @endif -->
                            @else
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle {{ $variable_arr['customers_link_active']?? '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-address-book"></i> Customers <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/customers/create">
                                            <i class="fas fa-user-plus"></i> Create New Account
                                        </a>
                                        <a class="dropdown-item" href="/customers/edit">
                                            <i class="fas fa-user-edit"></i> Update Customer Account
                                        </a>
                                        <a class="dropdown-item" href="/customers/view">
                                            <i class="fas fa-eye"></i> View Customers Accounts
                                        </a>
                                        <a class="dropdown-item" href="/customers/groups">
                                            <i class="fas fa-layer-group"></i> Customers Groups
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle {{ $variable_arr['savings_link_active']?? '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-tree"></i></i> Savings <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/savings/create">
                                            <i class="fas fa-plus"></i></i> Start New Saving
                                        </a>
                                        <a class="dropdown-item" href="/savings/collection">
                                            <i class="fas fa-money-bill-alt"></i></i> Record Saving Collection
                                        </a>
                                        <a class="dropdown-item" href="/savings/disburse">
                                            <i class="fas fa-money-bill"></i></i> Withdraw From Saving
                                        </a>
                                        <a class="dropdown-item" href="/savings/close_saving">
                                            <i class="fas fa-circle-notch"></i></i> Close Saving
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle {{ $variable_arr['loans_link_active']?? '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-money-check"></i> Loans <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/loans/create">
                                            <i class="fas fa-plus"></i> New Loan Application
                                        </a>
                                        <a class="dropdown-item" href="/loans/pending">
                                            <i class="fas fa-circle"></i> Pending Loans
                                        </a>
                                        <a class="dropdown-item" href="/loans/approved">
                                            <i class="fas fa-check"></i> Approved Loans
                                        </a>
                                        <a class="dropdown-item" href="/loans/repayment">
                                            <i class="fas fa-pen"></i> Loan Repayment
                                        </a>
                                        <a class="dropdown-item" href="/loans/due_today">
                                            <i class="fas fa-bullseye"></i> Loans Due Today
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle {{ $variable_arr['transactions_link_active']?? '' }}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-book"></i> Transactions <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/transactions/today">
                                            <i class="fas fa-file"></i> Today's Transactions
                                        </a>
                                        <a class="dropdown-item" href="/transactions/week">
                                            <i class="fas fa-file-alt"></i> This Week's Transactions
                                        </a>
                                        <a class="dropdown-item" href="/transactions/month">
                                            <i class="fas fa-file-archive"></i> This Month's Transactions
                                        </a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('images/staffs/'.Auth::user()->passport ) }}" alt="staff dp" width = "20px"> {{ Auth::user()->first_name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        @if(Auth::user()->rank>1)
                                        <a class="dropdown-item" href="/admin">
                                            {{ __('Manage Staffs') }}
                                        </a>
                                        @endif
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
    @section('general-script')
    <script>
        var app = new Vue({
        el: '#app',
        data: {
            now: new Date()
        },
        methods:{
            sendSMS: function(){
                var today = this.now.getDay();
                let lastSentDay = localStorage.getItem('sentDay');
                if(lastSentDay*1 === today*1){
                    console.log('Already sent SMS for the day: ' + lastSentDay);
                }
                else{
                    //alert('Has not sent SMS for today: ' + today);
                    var _this = this;
                    axios.get('/sms-notification')
                    .then(function (response) {
                        localStorage.setItem('sentDay',today);
                        console.log(today);
                        console.log(lastSentDay);
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            }
        },
        mounted () {
            this.sendSMS();
            setInterval(this.sendSMS,30*60*1000);
        }
        })
    </script>
    @show
</body>
</html>
