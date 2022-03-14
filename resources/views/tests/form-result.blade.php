@extends('layouts.app')

@section('content')
    <h4 class="page-title">@if($id > 0) {{__('Edit test result item')}} @else {{ __('New test result item') }} @endif</h4>
    <form action="/save-result-test" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <input type="hidden" name="user_id" value="{{ $user_id }}">
        <div class="row mb-3">
            <label for="full_name" class="col-sm-2 col-form-label">{{  __('Full name') }}</label>
            <div class="col-sm-10">
                <input required type="text" name="full_name" class="form-control" id="full_name" value="{{ $full_name }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="date" class="col-sm-2 col-form-label">{{  __('Date') }}</label>
            <div class="col-sm-10">
                <input required type="date" name="date" class="form-control" id="date" value="{{ $date }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="location" class="col-sm-2 col-form-label">{{  __('Location') }}</label>
            <div class="col-sm-10">
                <input required type="text" name="location" class="form-control" id="location" value="{{ $location }}">
            </div>
        </div>
        <div class="row mb-3">
            <label for="test_id" class="col-sm-2 col-form-label">{{  __('Test') }}</label>
            <div class="col-sm-10">
                <select name="test_id" id="test_id" class="form-control" required>
                    <option value=""></option>
                    @foreach($tests as $test)
                        <option value="{{ $test->test_id }}" @if($test->test_id == $test_id) selected @endif>{{ $test->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label for="rating" class="col-sm-2 col-form-label">{{  __('Rating') }}</label>
            <div class="col-sm-10">
                <input required type="number" min="0" max="100" name="rating" class="form-control" id="rating" value="{{ $rating }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </form>
@endsection
@push('blade_js')
    <script src="{{ url('js/result-form.js') }}"></script>
@endpush
