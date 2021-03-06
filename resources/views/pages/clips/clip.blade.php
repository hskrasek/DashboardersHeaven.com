@extends('app')
@inject('titles', 'DashboardersHeaven\Services\Titles\TitleService')

@section('head')
    <meta property="og:title" content="{{ $titles->generate($gamer, $clip) }}"/>
    <meta property="og:type" content="video"/>
    <meta property="og:url" content="{{ route('member.clip', [$gamer->gamertag, $clip->clip_id]) }}"/>
    <meta property="og:video" content="{{ $clip->url }}"/>
    <meta property="og:video:url" content="{{ $clip->url }}"/>
    <meta property="og:video:secure_url" content="{{ $clip->url }}"/>
    <meta property="og:video:type" content="video/mp4"/>
    <meta property="og:video:width" content="640"/>
    <meta property="og:video:height" content="480"/>
    <meta property="og:image" content="{{ $clip->thumbnail_small }}"/>
    {{-- TODO: Change this to a clip description if we ever allow for custom descriptions.--}}
    <meta property="og:description" content="{{ $titles->generate($gamer, $clip) }}"/>
@endsection

@section('title')
    {{ $titles->generate($gamer, $clip) }}
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb" style="margin-bottom: 60px">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                <video class="video-js vjs-default-skin vjs-big-play-centered" id="video_{{ $clip->clip_id }}"
                       controls
                       preload="auto"
                       width="640"
                       data-setup="{}"
                >
                    <source src="{{ $clip->url }}" type='video/mp4'/>
                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a web rowser that <a
                                href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2 class="centered">{{ $clip->game_title }}</h2>
                <div class="hline"></div>
                <p>
                    <img src="{{ $gamer->display_pic }}" alt="{{ $gamer->gamertag }}'s Gamer Pic" width="75px"
                         class="pull-right">
                    Gamertag: <strong>{{ $gamer->gamertag }}</strong><br>
                    @if(!empty($clip->title))
                        Custom Title: {{ $clip->title }}
                    @endif
                    Saved: <span class="@if($clip->saved) text-success @else text-danger @endif">@if($clip->saved)
                            Yes @else No @endif</span><br>
                    Recorded:
                    <strong>
                        <time datetime="{{ $clip->recorded_at }}">{{ $clip->recorded_at }}</time>
                    </strong>
                </p>
            </div>
        </div>
    </div>
@endsection
