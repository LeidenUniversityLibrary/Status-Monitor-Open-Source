<!doctype html>
<html lang="en">

<head prefix="og: //ogp.me/ns#">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        @if(View::hasSection('title'))@yield('title')@else{{config('app.name', 'Status Monitor - Open Source')}}@endif
    </title>
    <link rel="canonical" href={{URL::current()}}>
    <meta name="application-name"
        content="@if(View::hasSection('title'))@yield('title')@else{{config('app.name', 'Status Monitor - Open Source')}}@endif" />
    <link rel="apple-touch-icon" sizes="57x57" href="{{{ asset('img/apple-icon-57x57.png') }}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{{ asset('img/apple-icon-60x60.png') }}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{{ asset('img/apple-icon-72x72.png') }}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{{ asset('img/apple-icon-76x76.png') }}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{{ asset('img/apple-icon-114x114.png') }}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{{ asset('img/apple-icon-120x120.png') }}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{{ asset('img/apple-icon-144x144.png') }}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{{ asset('img/apple-icon-152x152.png') }}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{{ asset('img/apple-icon-180x180.png') }}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{{ asset('img/android-icon-192x192.png') }}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{{ asset('img/favicon-32x32.png') }}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{{ asset('img/favicon-96x96.png') }}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{{ asset('img/favicon-16x16.png') }}}">
    <link rel="manifest" href="{{{ asset('img/manifest.json') }}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{{ asset('img/ms-icon-144x144.png') }}}">
    <meta name="theme-color" content="#ffffff">

    <!-- Boostrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css"
        integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    @yield('css')
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    
    @empty(env('GOOGLE_ANALYTICS_TRACKING_ID'))
    @else
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ env('GOOGLE_ANALYTICS_TRACKING_ID', 'undefined') }}"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '{{ env('GOOGLE_ANALYTICS_TRACKING_ID', 'undefined') }}');
    </script>
    @endempty
</head>

<body>
    <!--SECTION Page Content  -->
    <div id="content">
        
        <!-- SECTION Header container -->
        <div class="header-container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light wrapper">
                <div class="container-fluid">
                    <a class="navbar-brand" href="https://www.example.com">
                        <img src="{{{ asset('img/logo.png') }}}" height="45" alt="Your Logo"
                            id="logo_header">
                    </a>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('homepage') }}">Home</a>
                            </li>
                            @auth
                            <li class="nav-item" id="manageMonitorsBtn">
                                <a class="nav-link" href="{{ route('admin_monitors') }}" rel="noopener">Manage monitors</a>
                            </li>
                            <li class="nav-item" id="manageAlertsBtn">
                                <a class="nav-link" href="{{ route('admin_alerts') }}" rel="noopener">Manage custom alerts</a>
                            </li>
                            <li class="nav-item" id="logoutBtn">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            </li>
                            @endauth
                    </div>
                </div>
            </nav>
            <div class="border-bottom border-purple"></div>
        </div>

        <!-- SECTION Main container -->
        <div class="main-container">
            <div class="container shadow-sm p-3 mt-3 rounded">
                <h1 class="text-center mt-4">
                    {{ config('app.name', 'Status Monitor - Open Source') }}
                </h1>
                <p class="text-muted text-center">Up-to-date information about your systems.</p>
                @auth
                <div class="alert alert-primary" role="alert" id="admin-logged-in">You are logged in. Displaying additional websites and
                    application visibility.</div>
                @endauth
                <!-- SECTION Yield Content -->
                <div class="container">
                @yield('content')
                </div>
                <!-- SECTION End Yield Content -->
            </div>
        </div>

        <!-- SECTION Footer container -->
        <div class="footer-container">
            <div class="container-lg">
                <footer class="mt-5 pt-md-5 border-top col-12">
                    <div class="row">
                        <div class="col-12 col-lg-4 mb-5">
                            <a href="https://www.example.com/" class="text-gray-dark">
                                <img src="{{{ asset('img/logo.png') }}}" alt="Logo" id="logo_footer"
                                    style="max-width:3em; display: block; margin:0 auto;"></a>
                        </div>
                        <div class="col-6 col-md">
                            <h5>Your company</h5>
                            <ul class="list-unstyled text-small">
                                <li><a href="https://www.example.com/" target="_blank" rel="noopener">Example website</a></li>
                                <li><a href="https://www.example.com/" target="_blank"
                                        rel="noopener">Example website</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md">
                            <h5>Social</h5>
                            <ul class="list-unstyled text-small">
                                <li><a href="https://www.example.com/" target="_blank" rel="noopener">Example website</a></li>
                                <li><a href="https://www.example.com/" target="_blank" rel="noopener">Example website</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md">
                            <h5>About</h5>
                            <ul class="list-unstyled text-small">
                                <li>
                                    <p class="text-muted">Designed and developed by <a
                                            href="https://github.com/LeidenUniversityLibrary" target="_blank"
                                            rel="noopener">Leiden University Libraries</a>.
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <!-- SECTION addtional JS Jquery, popper, bootstrap, sidebar's sidebar -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script type="text/javascript" async defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js"
        integrity="sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7" crossorigin="anonymous">
    </script>
    @yield('javascript')
</body>

</html>