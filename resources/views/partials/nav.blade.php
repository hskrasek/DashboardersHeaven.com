<!-- Fixed navbar -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">Dashboarder's Heaven</a>
        </div>
        <div class="navbar-collapse collapse navbar-right">
            <ul class="nav navbar-nav">
                <li class="{{ set_active_link('/', 'active') }}"><a href="{{ route('home') }}">HOME</a></li>
                <li class="{{ set_active_link('clips', 'active') }}"><a href="{{ route('clips') }}">CLIPS</a></li>
                <li class="{{ set_active_link('games', 'active') }}"><a
                            href="{{ route('games') }}">GAMES</a></li>
                <li class="{{ set_active_link('screenshots', 'active') }}"><a
                            href="{{ route('screenshots') }}">SCREENSHOTS</a></li>
            </ul>
        </div>
    </div>
</div>