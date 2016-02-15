@extends('app')
@inject('clipService', 'DashboardersHeaven\Services\ClipService')

@section('title')
    Dashboarder's Clips
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Dashboarder's Clips</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            @foreach($clips as $index => $clip)
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{ route('member.clip', [$clip->gamer->gamertag, $clip->clip_id]) }}"><img
                                src="{{ $clip->thumbnail_small }}" alt="clip-{{$clip->id}} thumbnail"></a>
                    <h4>{{ $clipService->generateTitle($clip, $clip->gamer) }}</h4>
                </div>
                @if($index !== 0 && ($index + 1) % 4 === 0)
        </div>
        <div class="row centered">
            @endif
            @endforeach
        </div>
        <div class="row centered">
            {!! $clips->render() !!}
        </div>
    </div>
@endsection