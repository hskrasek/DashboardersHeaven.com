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
                        <img src="{{ $game->resize_image_url }}" class="media-object"
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
                                    src="{{ $gamer->display_pic }}" alt="gamer-{{$gamer->id}} thumbnail"
                                    class="img-responsive"></a>
                        <div class="centered">
                            <h3>{{ $gamer->gamertag }}</h3>
                            <h4>Earned Achievements: {{ $gamer->pivot->earned_achievements }}
                                <br>
                                <small>Last Unlock: {{ $gamer->pivot->last_unlock->toFormattedDateString() }}</small>
                            </h4>
                            <h3>{{ $gamer->pivot->current_gamerscore }} / {{ $gamer->pivot->max_gamerscore }}</h3>
                        </div>
                    </div>
                    @if($index !== 0 && ($index + 1) % 4 === 0)
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                @endif
                @endforeach
            </div>
        </div>
        @if (!$clips->isEmpty())
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                    <h3 class="centered">Clips from {{ $game->title }}</h3>
                    <hr>
                    @foreach($clips as $index => $clip)
                        <div class="col-lg-3 col-md-3 col-sm-3">
                            <a href="{{ route('clip', ['clip_id' => $clip->clip_id]) }}"><img
                                        src="{{ $clip->thumbnail_small }}" alt="clip-{{$clip->id}} thumbnail"></a>
                        </div>
                        @if($index !== 0 && ($index + 1) % 4 === 0)
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                    @endif
                    @endforeach
                </div>
                <div>
                    <div class="col-lg-8 col-md-8 col-sm-8 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                        <a href="{{ route('clips', ['title_id' => $game->title_id]) }}"><h3 class="centered">Click here for more clips from {{ $game->title }}</h3></a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
