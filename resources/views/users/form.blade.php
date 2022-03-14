@extends('layouts.app')

@section('content')
    <h4 class="page-title">@if($id > 0) {{__('Edit managers item')}} @else {{ __('New managers item') }} @endif</h4>
    <form action="/save-user" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="row mb-3">
            <label for="testTitle" class="col-sm-2 col-form-label">{{  __('User login') }}</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" id="userLogin" value="{{ $name }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="rule" class="col-sm-2 col-form-label">{{  __('Rule') }}</label>
            <div class="col-sm-10">
                <select name="rule" id="rule" class="form-control">
                    <option value="0" @if(isset($rule) && $rule == 0) selected @endif>{{ __('Manager') }}</option>
                    <option value="1" @if(isset($rule) && $rule == 1) selected @endif>{{ __('Admin') }}</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="password" class="col-sm-2 col-form-label">{{  __('Password') }}</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="row mb-3">
            <label for="test_list" class="col-sm-2 col-form-label">{{  __('Aviable tests') }}</label>
            <select class="form-control" name="test_list[]" id="test_list" multiple>
                @foreach($tests as $test)
                    <option @if(in_array($test['id'], $aviable_list)) selected @endif value="{{ $test['id'] }}">{{ $test['title'] }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
@endsection
