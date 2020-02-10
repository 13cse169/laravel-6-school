<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style type="text/css">
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
            text-overflow: '';
        }
        a:hover{ text-decoration: none; }
        .btn-link:focus{ text-decoration: none; }
        .btn-link:hover{ text-decoration: none; }
        .close:focus{ outline: none; }
        /* toast */
        #toast {
            visibility: hidden;
            max-width: 50px;
            height: 50px;
            /*margin-left: -125px;*/
            margin: auto;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 2px;

            position: fixed;
            z-index: 1;
            left: 0;right:0;
            bottom: 30px;
            font-size: 17px;
            white-space: nowrap;
        }
        #toast #img{
            width: 50px;
            height: 50px;
            
            float: left;
            
            padding-top: 16px;
            padding-bottom: 16px;
            
            box-sizing: border-box;

            
            background-color: #111;
            color: #fff;
        }
        #toast #notifyMsg{

            
            color: #fff;
        
            padding: 16px;
            
            overflow: hidden;
            white-space: nowrap;
        }

        #toast.show {
            visibility: visible;
            -webkit-animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 2s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, expand 0.5s 0.5s,stay 3s 1s, shrink 0.5s 4s, fadeout 0.5s 4.5s;
        }

        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;} 
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes expand {
            from {min-width: 50px} 
            to {min-width: 350px}
        }

        @keyframes expand {
            from {min-width: 50px}
            to {min-width: 350px}
        }
        @-webkit-keyframes stay {
            from {min-width: 350px} 
            to {min-width: 350px}
        }

        @keyframes stay {
            from {min-width: 350px}
            to {min-width: 350px}
        }
        @-webkit-keyframes shrink {
            from {min-width: 350px;} 
            to {min-width: 50px;}
        }

        @keyframes shrink {
            from {min-width: 350px;} 
            to {min-width: 50px;}
        }

        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;} 
            to {bottom: 60px; opacity: 0;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 60px; opacity: 0;}
        }
    </style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }} <!-- SCHOOL -->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('school/*') || request()->is('school') ? 'active' : '' }}" href="{{ url('/school') }}">School</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('teacher/*') || request()->is('teacher') ? 'active' : '' }}" href="{{ url('/teacher') }}">Teacher</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/*') || request()->is('student') ? 'active' : '' }}" href="{{ url('/student') }}">Student</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('send-mail') ? 'active' : '' }}" href="{{ url('/send-mail') }}">Send Mail</a>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
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

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="{{ asset('js/notify.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script src="{{ asset('js/captcha-validation.js') }}"></script>

<script type="text/javascript">
    jQuery(document).ready(function($) {

        

        $('#GetStudent').submit(function (e) { 
            e.preventDefault();

            var School = $('.studSchool').val();
            var Name = $('.studName').val();

            if(School || Name){
                $.ajax({
                    url: "{{ url('get/student') }}",
                    type: 'POST',
                    dataType: 'json',
                    data: {studSchool: School, studName: Name, _token: '{{ csrf_token() }}'},
                })
                .done(function(res) { 
                    //console.log(res); 
                    $('#tBody').html(res.tBody);
                    $('.pagination').html(res.Pagination);
                })
                .fail(function() { 
                    console.log("error"); 
                });
            } else {
                $('#notifyMsg').text('Please enter at least one value...');
                $('#toast').addClass('show');
                setTimeout( () => { $('#toast').removeClass('show') }, 5000);
            }
            
        });


        $('form1111').submit(function (event) {                                 
            $(this).find('input, select, textarea').each(function(index, ele) {
                if($(this).hasClass('required')){
                    
                    if(!$(this).val()){
                        $(this).removeClass('is-valid').addClass('is-invalid');
                        event.preventDefault();
                    } else {
                        if($(this).hasClass('emailTrue')){
                            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                            if(regex.test($(this).val()))
                                $(this).removeClass('is-invalid').addClass('is-valid');
                            else{
                                $(this).removeClass('is-valid').addClass('is-invalid');
                                event.preventDefault();
                            }
                        } else if($(this).hasClass('phoneTrue')){
                            if($(this).val().length == 10)
                                $(this).removeClass('is-invalid').addClass('is-valid');
                            else{
                                $(this).removeClass('is-valid').addClass('is-invalid');
                                event.preventDefault();
                            }
                        } else $(this).removeClass('is-invalid').addClass('is-valid');
                    }

                }
            });
        });
        
    });
</script>


@yield('script')

</html>
