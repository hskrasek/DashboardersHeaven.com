@extends('app')
@inject('titles', 'DashboardersHeaven\Services\Titles\TitleService')

@section('title')
    Dashboarder's Screenshots
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Dashboarder's Screenshots</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            @foreach($screenshots as $index => $screenshot)
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{ route('member.screenshot', [$screenshot->gamer->gamertag, $screenshot->screenshot_id]) }}">
                        <img src="{{ $screenshot->thumbnail_small }}" alt="clip-{{$screenshot->id}} thumbnail">
                    </a>
                    <h4>
                        {{ $titles->generate($screenshot->gamer, $screenshot) }}
                    </h4>
                </div>
                @if($index !== 0 && ($index + 1) % 4 === 0)
        </div>
        <div class="row centered">
            @endif
            @endforeach
        </div>
        <div class="row centered">
            {!! $screenshots->render() !!}
        </div>
    </div>
@endsection