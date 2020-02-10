
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>My Laravel</title>
        <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/my-style.css') }}">
        <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    </head>
    <body>
        <div id="toast"><div id="img"><i class="fas fa-bell"></i></div><div id="notifyMsg"></div></div>
        <div class="container-scroller">

            @include('layouts.nav-bar')
            <div class="container-fluid page-body-wrapper">

                @include('layouts.side-bar')
                <div class="main-panel">

                    <div class="content-wrapper">
                        @yield('content')
                    </div>

                    <footer class="footer">
                        <div class="d-sm-flex justify-content-center justify-content-sm-between">
                            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © {{ date('Y') }} <a href="#" target="_blank">Bootstrap Dashboard</a>. All rights reserved.</span>
                        </div>
                    </footer>

                </div>

            </div>

        </div>
    </body>

    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('form').submit(function (event) {
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

    @if (session('notifyMsg'))
        <script>
            $(document).ready(function () {
                $('#notifyMsg').text("{{ Session::get('notifyMsg') }}");
                $('#toast').addClass('show');
                setTimeout( () => { $('#toast').removeClass('show') }, 5000);
            });
        </script>
    @endif

    @yield('script')
</html>
