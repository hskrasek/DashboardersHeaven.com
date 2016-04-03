@extends('app')

@section('title')
    Photoshops
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Photoshops</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            <div class="col-lg-4 col-lg-offset-4">
                @forelse($photoshops as $photoshop)
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <a href="{{ $photoshop->uri }}">
                                <img src="{{ $photoshop->uri }}" class="img-responsive"
                                     alt="{{ $photoshop->title}}">
                            </a>
                        </div>
                        <div class="col-lg-8 col-sm-8 col-sm-8">
                            <p>
                                <a href="{{ route('photoshops.view', [$photoshop->id]) }}"><h3>{{ $photoshop->title }}</h3></a>
                                {{ $photoshop->description }}
                            </p>
                            <p>
                                <strong>Requested By: </strong> {{ $photoshop->gamer->gamertag }}
                            </p>
                        </div>
                    </div>
                @empty
                    <h2>Looks like Hunter hasn't completed any photoshops, slacker.</h2>
                @endforelse
            </div>
        </div>
    </div>
@endsection
