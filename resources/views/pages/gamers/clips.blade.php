@extends('app')
@inject('titles', 'DashboardersHeaven\Services\Titles\TitleService')

@section('title')
    {{ $gamer->gamertag }}'s Clips
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>{{ $gamer->gamertag }}'s Clips</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            @foreach($clips as $index => $clip)
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{ route('member.clip', [$gamer->gamertag, $clip->clip_id]) }}"><img
                                src="{{ $clip->thumbnail_small }}" alt="clip-{{$clip->id}} thumbnail"></a>
                    <h4>{{ $titles->generate($gamer, $clip) }}</h4>
                </div>
                @if($index !== 0 && ($index + 1) % 4 === 0)
        </div>
        <div class="row centered">
            @endif
            @endforeach
        </div>{{-- End of screenshots loop --}}
        <div class="row centered">
            {!! $clips->render() !!}
        </div>
    </div>
@endsection