@extends('app')

@section('head')
    <meta property="og:title" content="{{ $game->title }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ route('game', [$game->title]) }}"/>
    <meta property="og:image" content="{{ $game->resize_image_url }}"/>
    <meta property="og:description" content="{{ $game->description }}"/>
@endsection

@section('title')
    {{ $game->title }}
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>{{ $game->title }}</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb" style="margin-bottom: 60px">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                <div class="media">
                    <div class="media-left media-middle">
                        <img data-aload="{{ $game->resize_image_url }}" class="media-object"
                             alt="{{ $game->title }}" style="max-width: none; height: 607.50px;">
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">{{ $game->title }}</h3>
                        <p>
                            {{ $game->description }}
                        </p>
                        <p>
                            <strong>Released On: </strong>{{ $game->release_date->format('l jS \\of F, Y') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                <h3 class="centered">Dashboarders who have played {{ $game->title }}</h3>
                <hr>
                @foreach($gamers as $index => $gamer)
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <a href="{{ route('member', ['gamertag' => $gamer->gamertag]) }}"><img
                                    data-aload="{{ $gamer->display_pic }}" alt="gamer-{{$gamer->id}} thumbnail"></a>
                        <div class="centered">
                            <h4>{{ $gamer->gamertag }}</h4>
                            <h3>Earned Achievements: {{ $gamer->pivot->earned_achievements }}
                                <small>Last Unlock: {{ $gamer->pivot->last_unlock->toFormattedDateString() }}</small>
                            </h3>
                            <h3>{{ $gamer->pivot->current_gamerscore }} / {{ $gamer->pivot->max_gamerscore }}</h3>
                        </div>
                    </div>
                    @if($index !== 0 && ($index + 1) % 4 === 0)
            </div>
            <div class="row centered">
                @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
