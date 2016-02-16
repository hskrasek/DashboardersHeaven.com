@extends('app')

@section('title')
    Members
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Our Members.</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container mtb">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 centered">
                <h2>We rage quit often.</h2>
                <br>
                <div class="hline"></div>
            </div>
        </div>
    </div>
    <div id="portfoliowrap">
        <div class="portfolio-centered">
            <div class="recentitems portfolio">
                @foreach($gamers as $gamer)
                    <div class="portfolio-item graphic-design">
                        <div class="he-wrap tpl6">
                            <img src="{{ $gamer->display_pic }}" alt="{{ $gamer->gamertag }}'s Gamer Pic">
                            <div class="he-view">
                                <div class="bg a0" data-animate="fadeIn">
                                    <h3 class="a1" data-animate="fadeInDown">{{ $gamer->gamertag }}</h3>
                                    <a href="{{ route('member', [$gamer->gamertag]) }}" class="dmbutton a2"
                                       data-animate="fadeInUp"><i class="fa fa-user"></i></a>
                                    @if($gamer->clips->count() > 0)
                                    <a href="{{ route('member.clips', [$gamer->gamertag]) }}" class="dmbutton a2"
                                       data-animate="fadeInUp"><i class="fa fa-video-camera"></i></a>
                                    @endif
                                    @if($gamer->screenshots->count() > 0)
                                    <a href="{{ route('member.screenshots', [$gamer->gamertag]) }}" class="dmbutton a2"
                                       data-animate="fadeInUp"><i class="fa fa-picture-o"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection