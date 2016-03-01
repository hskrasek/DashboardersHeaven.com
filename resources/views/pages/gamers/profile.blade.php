@extends('app')

@section('head')
    <meta property="og:title" content="{{ $gamer->gamertag }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{ route('member', [$gamer->gamertag]) }}"/>
    <meta property="og:image" content="{{ $gamer->display_pic }}"/>
    {{-- TODO: Change this to a clip description if we ever allow for custom descriptions.--}}
    <meta property="og:description" content="{{ $gamer->gamertag }}s profile."/>
@endsection

@section('title')
    {{ $gamer->gamertag }}
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>{{ $gamer->gamertag }}'s Profile</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb" style="margin-bottom: 60px">
        <div class="row">
            <div class="gamer-profile-info col-lg-4 col-md-4 col-sm-4 col-lg-offset-2 col-md-offset-2 col-sm-offset-2">
                <div class="media">
                    <div class="media-left media-middle">
                        <img data-aload="{{ $gamer->display_pic }}" class="media-object gamer-pic"
                             alt="{{ $gamer->gamertag }}'s gamer pic" style="max-width: none">
                    </div>
                    <div class="media-body">
                        <h3 class="media-heading">{{ $gamer->gamertag }}</h3>
                        <p>
                            <strong>Gamerscore:</strong> {{ $gamer->gamerscore }}<br>
                            <strong>Years on Xbox Live:</strong> {{ $gamer->level }}<br>
                            @if(!empty($gamer->motto))
                                <strong>Motto:</strong> {{ $gamer->motto }}<br>
                            @endif
                        </p>
                        @if(!empty($gamer->bio))
                            <p>
                                <strong>Bio:</strong> {{ $gamer->bio }}<br>
                            </p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div id="chart"></div>
            </div>
        </div>
        <div class="row centered">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <h3 class="centered">Games played</h3>
                @foreach($gamer->games as $index => $game)
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <img data-aload="{{ $game->image_url }}" alt="game-{{$game->id}} thumbnail">
                        <h4>{{ $game->title }}</h4>
                    </div>
                    @if($index !== 0 && ($index + 1) % 4 === 0)
            </div>
            <div class="row centered">
                @endif
                @endforeach
            </div><!-- portfolio container -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="application/javascript">
        var chart = c3.generate({
            bindto: '#chart',
            data: {
                x: 'x',
                url: '/ajax/gamerscores/{{ $gamer->id }}',
                mimeType: 'json',
            },
            legend: {
                show: true
            },
            axis: {
                x: {
                    label: {
                        text: 'Date',
                        position: 'outer-center'
                    },
                    type: 'timeseries',
                    tick: {
                        format: '%e %b %y',
                        rotate: 65,
                        multiline: true,
                        fit: true,
                    },
                },
                y: {
                    label: {
                        text: 'Gamerscore',
                        position: 'outer-center'
                    },
                    tick: {
                        format: d3.format(',')
                    }
                }
            },
            tooltip: {
                format: {
                    title: function (data) {
                        return 'Gamerscore on ' + d3.time.format('%e %b %y')(data);
                    },
                    value: function (value, ratio, id) {
                        var format = id === 'gamerscore' ? d3.format(',') : d3.time.format('%e %b %y');

                        return format(value);
                    }
                }
            }
        });
    </script>
@endsection