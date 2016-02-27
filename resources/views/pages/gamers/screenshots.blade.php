@extends('app')

@section('title')
    {{ $gamer->gamertag }}'s Screenshots
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>{{ $gamer->gamertag }}'s Screenshots</h3>
            </div><!-- /row -->
        </div> <!-- /container -->
    </div><!-- /blue -->
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered" style="margin-bottom: 1%">
            @foreach($screenshots as $index => $screenshot)
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <a href="{{ route('member.screenshot', [$gamer->gamertag, $screenshot->screenshot_id]) }}"><img
                                src="{{ $screenshot->thumbnail_small }}"
                                alt="screenshot-{{ $screenshot->screenshot_id }} screenshot"
                                class="img-responsive img-thumbnail">
                    </a>
                </div>
                @if($index !== 0 && ($index + 1) % 4 === 0)
        </div>
        <div class="row centered" style="margin-bottom: 1%">
            @endif
            @endforeach
        </div>{{-- End of screenshots loop --}}
        <div class="row centered">
            {!! $screenshots->render() !!}
        </div>
    </div><!--/Portfoliowrap -->
@endsection