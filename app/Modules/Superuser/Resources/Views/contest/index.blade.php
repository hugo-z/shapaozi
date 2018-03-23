@extends('master')

@push('js')
    <script src="{{ asset('js/functions.js') }}"></script>
@endpush

@section('content_header')
    <h1>{{ trans('superuser::contest.html.common.list_title') }}</h1>
@endsection

@section('content')
<div class="row">
    @foreach ($contests as $contest)
    <div class="col-md-3">
        <div class="box box-warning">
            <div class="box-body">
                <a 
                data-toggle="modal" 
                data-target=".addContestForm" 
                cursor="pointer" 
                onclick="editContest('{{ $contest }}', '{{ action('ContestController@store') }}')">
                    {{ $contest->name }}
                </a>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-md-3">
        <div class="box box-default">
            <div class="box-body" style="text-align: center; font-size: 200%; color: #7d7a7a;">
                <a data-toggle="modal" data-target=".addContestForm" cursor="pointer">
                    <span class="glyphicon glyphicon-plus" onclick="editContest('', '{{ action('ContestController@store') }}')"></span>
                </a>
            </div>
        </div>
    </div>
</div>
@include('superuser::contest.partials.modal')
@endsection