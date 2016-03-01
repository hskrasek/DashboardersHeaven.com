@extends('app')

@section('title')
    Not Found
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Oops...</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mtb">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 centered">
                <div class="title"><h2>Seems as if this page could not be found. Sorry about that. Go <a
                                href="{{ route('home') }}">home</a></h2></div>
            </div>
        </div>
    </div>
@endsection