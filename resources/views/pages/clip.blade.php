@extends('app')
@inject('clipService', 'DashboardersHeaven\Services\ClipService')

@section('head')
    <meta property="og:title" content="{{ $clipService->generateTitle($clip, $gamer) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('clip', [$gamer->gamertag, $clip->clip_id]) }}" />
    <meta property="og:image" content="{{ $clip->thumbnail_small }}" />
    {{-- TODO: Change this to a clip description if we ever allow for custom descriptions.--}}
    <meta property="og:description" content="{{ $gamer->gamertag }} playing {{ $clip->game->title }}" />
@endsection

@section('title')
{{ $clipService->generateTitle($clip, $gamer) }}
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>{{ $clipService->generateTitle($clip, $gamer) }}
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
