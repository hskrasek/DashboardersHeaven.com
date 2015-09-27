@extends('app')

@section('head')
    <meta property="og:title" content="@if(!empty($clip->name)) {{ $clip->name }} in @endif{{ $clip->game->title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('clip', [$gamer->gamertag, $clip->clip_id]) }}" />
    <meta property="og:image" content="{{ $clip->thumbnail_small }}" />
@endsection

@section('title')
@if(!empty($clip->name)) {{ $clip->name }} in @endif{{ $clip->game->title }}
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>@if(!empty($clip->name)) {{ $clip->name }} in @endif{{ $clip->game->title }}
                <small><time datetime="{{ $clip->recorded_at }}">{{ $clip->recorded_at }}</time></small>
                </h3>
            </div><!-- /row -->
        </div> <!-- /container -->
    </div><!-- /blue -->
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            <video id="video_{{ $clip->id }}" class="video-js vjs-default-skin vjs-big-play-button vjs-big-play-centered"
                   controls preload="auto"
                   poster="{{ $clip->thumbnail_small }}">
                <source src="{{ $clip->url }}" type='video/mp4'/>
                <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser
                    that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
            </video>
        </div>
    </div><!--/Portfoliowrap -->
@endsection
