@extends('layouts.app')

@section('content')
    @if( $rule == 1 ) <div class="dt-action-buttons text-xl-end text-lg-start text-lg-end text-start "><div class="dt-buttons"><a href="/new-user-item"><button class="dt-button btn btn-primary btn-add-record ms-2" tabindex="0" aria-controls="DataTables_Table_0" type="button">
                    <span>Add Record</span></button></a> </div></div> @endif
    <div class="container">
        <div class="content">
            <table class="table">
                <thead>
                <tr>
                    <th>Managers login</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr><td>{{ $user['name'] }}</td><td class="actions">
                            <a href="/edit-user/{{ $user['id'] }}" class="item-edit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit font-small-4"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                            <a href="javascript:;" onclick="deleteUserItem({{ $user['id'] }})" class="delete-record"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 font-small-4 me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                        </td></tr>

                @endforeach
                </tbody>
                <tfoot>
                <tr>
                    <th>Managers login</th>
                    <th class="cell-fit">Actions</th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
@endsection
@push('blade_js')
    <script src="{{ url('js/user-list.js') }}"></script>
@endpush

