@extends('layouts.app')

@section('content')
    <h4 class="page-title">@if($id > 0) {{__('Edit tests item')}} @else {{ __('New tests item') }} @endif</h4>
    <form action="/save-test" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="row mb-3">
            <label for="testTitle" class="col-sm-2 col-form-label">{{  __('Test title') }}</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="testTitle" value="{{ $title }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
@endsection
