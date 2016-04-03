@extends('app')

@section('title')
    Photoshop Requests
@endsection

@section('header')
    <div id="blue">
        <div class="container">
            <div class="row">
                <h3>Photoshop Requests</h3>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="container mtb">
        <div class="row centered">
            <div class="col-lg-4 col-lg-offset-4">
                <div class="controls">
                    <form action="{{ route('photoshops.requests.submit') }}" class="form-horizontal" method="post">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Title:</label>
                            <div class="col-sm-10"><input type="text" id="title" name="title" class="form-control" value="{{ Input::old('title') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">Description:</label>
                            <div class="col-sm-10"><textarea id="description" name="description"
                                                             class="form-control">{{ Input::old('description') }}</textarea></div>
                        </div>
                        <div class="form-group">
                            <label for="requestee" class="col-sm-2 control-label">Requestee:</label>
                            <div class="col-sm-10">
                                <select id="requestee" name="requestee" class="form-control">
                                    @foreach($gamers as $gamer)
                                        <option value="{{ $gamer->id }}">{{ $gamer->gamertag }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sources" class="control-label col-sm-2">Source Image:</label>
                            <div class="col-sm-10">
                                <textarea id="sources" name="sources" class="form-control"
                                          placeholder="Enter one url per line">{{ Input::old('sources') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-10 col-sm-offset-2">
                                {!! Recaptcha::render() !!}
                            </div>
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
