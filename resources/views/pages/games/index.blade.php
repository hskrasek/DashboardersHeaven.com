@extends('app')
@inject('titles', 'DashboardersHeaven\Services\Titles\TitleService')

@section('title')
    Dashboarder's Games
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Dashboarder's Games</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            @foreach($games as $index => $game)
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{ route('game', [$game->title]) }}">
                        <img data-aload="{{ $game->image_url }}" alt="game-{{$game->id}} thumbnail">
                    </a>
                    <h4>{{ $game->title }}</h4>
                </div>
                @if($index !== 0 && ($index + 1) % 4 === 0)
        </div>
        <div class="row centered">
            @endif
            @endforeach
        </div>
        <div class="row centered">
            {!! $games->render() !!}
        </div>
    </div>
@endsection