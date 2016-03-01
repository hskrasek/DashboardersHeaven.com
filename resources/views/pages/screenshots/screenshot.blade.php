@extends('app')
@inject('titles', 'DashboardersHeaven\Services\Titles\TitleService')

@section('head')
    <meta property="og:title" content="{{ $titles->generate($gamer, $screenshot) }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ route('screenshot', [$gamer->gamertag, $screenshot->screenshot_id]) }}"/>
    <meta property="og:image" content="{{ $screenshot->thumbnail_small }}"/>
    {{-- TODO: Change this to a screenshot description if we ever allow for custom descriptions.--}}
    <meta property="og:description" content="{{ $titles->generate($gamer, $screenshot) }}"/>
@endsection

@section('title')
    {{ $titles->generate($gamer, $screenshot) }}
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
                <a href="{{ $screenshot->url }}">
                    <img data-aload="{{ $screenshot->url }}" class="img-responsive"
                         alt="{{ $titles->generate($gamer, $screenshot) }}">
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <h2 class="centered">{{ !is_null($screenshot->game) ? $screenshot->game->title : 'Screenshot'}}</h2>
                <div class="hline"></div>
                <p>
                    <img src="{{ $gamer->display_pic }}" alt="{{ $gamer->gamertag }}'s Gamer Pic" width="75px"
                         class="pull-right">
                    Gamertag: <strong>{{ $gamer->gamertag }}</strong><br>
                    Saved: <span class="@if($screenshot->saved) text-success @else text-danger @endif">@if($screenshot->saved)
                            Yes @else No @endif</span><br>
                    Recorded:
                    <strong>
                        <time datetime="{{ $screenshot->taken_at }}">{{ $screenshot->taken_at }}</time>
                    </strong>
                </p>
            </div>
        </div>
    </div>
@endsection
