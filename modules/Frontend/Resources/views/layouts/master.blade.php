<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
</head>
<body>
<?php
$guard = 'user';
?>
<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }} (user)
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                @if (Auth::guard($guard)->check())

                    @if (Auth::guard($guard)->user()->is_company)
                        <li><a href="{{ route('frontend.user_management.index') }}">Users and permissions</a></li>
                    @endif
                @else

                @endif
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guard($guard)->guest())
                    <li><a href="{{ route('frontend.login_form') }}">Login</a></li>
                    <li><a href="{{ route('frontend.register') }}">Register</a></li>
                @else
                    <?php
                        $notifications = \NotificationCache::get();
                        $notificationCount = count($notifications);
                    ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            Notifications @if ($notificationCount > 0) <span class="label label-danger">{!! $notificationCount !!}</span> @endif<span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            @include('frontend::layouts.blocks.database_notifications', [
                                'notifications' => $notifications,
                                'count' => $notificationCount,
                            ])
                        </ul>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ Auth::guard($guard)->user()->email }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{!! route('frontend.profile.edit') !!}">
                                    Edit profile
                                </a>
                                <a href="{!! route('frontend.account.accountEdit') !!}">
                                    Edit account
                                </a>
                                <a href="{{ route('frontend.logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="container">
    @include('frontend::layouts.blocks.notification')
    @include('frontend::layouts.blocks.breadcrumb')
    @yield('content')
</div>
<!-- Scripts -->
{{--<script src="http://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>--}}
<script src="/js/app.js"></script>
</body>
</html>
