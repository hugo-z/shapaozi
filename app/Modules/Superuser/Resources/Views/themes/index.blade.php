@extends('master')

@section('content_header')
    <h1>Templates List</h1>
@endsection

@section('content')
<div class="row">
    {{--  @foreach ($contests as $contest)  --}}
    <div class="col-md-4">
        <div class="box box-warning">
            <div class="box-body">
                <a 
                data-toggle="modal" 
                data-target=".addContestForm" 
                cursor="pointer" 
                onclick="">
                    {{--  {{ $contest->name }}  --}}
                </a>
            </div>
        </div>
    </div>
    {{--  @endforeach  --}}
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body" style="text-align: center; font-size: 200%; color: #7d7a7a;">
                <a data-toggle="modal" data-target=".addContestForm" cursor="pointer">
                    <span class="glyphicon glyphicon-plus" onclick="editTemplate('', '{{ action('TemplateController@store') }}')"></span>
                </a>
            </div>
        </div>
    </div>
</div>
@include('superuser::themes.partials.modal')
@endsection