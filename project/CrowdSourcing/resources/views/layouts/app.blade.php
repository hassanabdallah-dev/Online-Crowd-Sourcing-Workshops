<!doctype html>
<html style='zoom:150%;' lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('clipboard/dist/clipboard.min.js') }}"></script>
<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/myCss.css') }}" rel="stylesheet">
</head>
<body class="banner-area" style='z-index:0; background-image:url({{ asset("images/bg1.jpg") }}); '>
    <div id="app">
    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
            <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                    <span class="logo">WE<span>LCOME</span></span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon bg-primary" style="width:25px; height:25px;"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><span class="logo" style="font-size:25px;"><i class="fa fa-sign-in"></i> {{ __('Login') }}</span></a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}"><span class="logo" style="font-size:25px;"><i class="fa fa-user"></i> {{ __('Register') }}</span></a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><span class="logo" style="font-size:25px;">
                                    {{ Auth::user()->name }} <i class="fas fa fa-angle-down" style="font-weight:bold;"></i></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right drop-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    @can('manage-users')
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                        {{ __('Users Management') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.preferences.index') }}">
                                        {{ __('Preferences') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.history.index') }}">
                                        {{ __('History') }}
                                    </a>
                                    @endcan
                                    @can('manage-workshop')
                                    @cannot('manage-users')
                                    <a class="dropdown-item" href="{{ route('monitor.history.index') }}">
                                        {{ __('History') }}
                                    </a>
                                    @endcannot
                                    @if(!session('workshop_id'))
                                    <a class="dropdown-item" href="{{ route('monitor.create') }}">
                                        {{ __('Create Workshop') }}
                                    </a>
                                    @else
                                    <a class="dropdown-item" href="{{ route('monitor.workshops') }}">
                                        {{ __('Workshop Dashboard') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('monitor.result') }}">
                                        {{ __('Workshop Voting') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('monitor.end') }}">
                                        {{ __('End Workshop') }}
                                    </a>
                                    @endif
                                    @if(session('exit'))
                                    <a class="dropdown-item" href="{{ route('monitor.exit') }}">
                                        {{ __('Exit Workshop') }}
                                    </a>
                                    @endif
                                    @endcan
                                    @can('participate-workshop')
                                    <a class="dropdown-item" href="{{ route('participant.usermakekey') }}">
                                        {{ __('Participate in Workshop') }}
                                    </a>
                                    @if(session('workshop_id'))
                                    <a class="dropdown-item" href="{{ route('participant.exit') }}">
                                        {{ __('Exit Workshop') }}
                                    </a>
                                    @endif
                                    @if(session('workshop_id'))
                                    <a class="dropdown-item" href="{{ route('participant.continue') }}">
                                        {{ __('Continue Workshop') }}
                                    </a>
                                    @endif
                                    @cannot('manage-users')
                                    @cannot('manage-workshop')
                                    <a class="dropdown-item" href="{{ route('participant.history.index') }}">
                                        {{ __('History') }}
                                    </a>
                                    @endcannot
                                    @endcannot
                                    @endcan
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
