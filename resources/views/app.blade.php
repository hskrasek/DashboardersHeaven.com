<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboarder's Heaven | @yield('title')</title>

    <link rel="stylesheet" href="{{ elixir("css/all.css") }}">
    <link href="//vjs.zencdn.net/5.4.6/video-js.min.css" rel="stylesheet">
    @yield('head')
</head>

<body>

@include('partials.nav')

@yield('header')

@yield('content')

@include('partials.footer')

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

<script src="{{ elixir("js/all.js") }}"></script>

<script src="//vjs.zencdn.net/5.4.6/video.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.3/moment-timezone-with-data.js"></script>

<script type="application/javascript">
    $('time').each(function (i, e) {
        var time = moment.tz($(e).attr('datetime'), 'UTC');
        var timeZone = moment.tz.guess();
        $(e).html(time.tz(timeZone).fromNow());
    });
</script>

@yield('scripts')
</body>
</html>
