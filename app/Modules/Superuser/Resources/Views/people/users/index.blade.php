@extends('master')

@section('title', trans('common.html.navi.user'))

@section('content_header')
    <h1>{{ trans('common.html.navi.user') }}</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="box-title">
          <a href="{{ route('editUser') }}" class="btn btn-default">
            {!! __('superuser::user.html.icons.add') !!} {{ __('superuser::user.html.button.create') }}
          </a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="users-list" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>{{ trans('superuser::user.html.text.id') }}</th>
              <th>{{ trans('superuser::user.html.text.name') }}</th>
              <th>{{ trans('superuser::user.html.text.email') }}</th>
              <th>{{ trans('superuser::user.html.text.cell') }}</th>
              <th>{{ trans('superuser::user.html.text.suspended') }}</th>
              <th>{{ trans('superuser::user.html.text.created') }}</th>
              <th>{{ trans('superuser::user.html.text.action') }}</th>
            </tr>
          </thead>
          
          <tfoot>
            <tr>
              <th>{{ trans('superuser::user.html.text.id') }}</th>
              <th>{{ trans('superuser::user.html.text.name') }}</th>
              <th>{{ trans('superuser::user.html.text.email') }}</th>
              <th>{{ trans('superuser::user.html.text.cell') }}</th>
              <th>{{ trans('superuser::user.html.text.suspended') }}</th>
              <th>{{ trans('superuser::user.html.text.created') }}</th>
              <th>{{ trans('superuser::user.html.text.action') }}</th>
            </tr>
          </tfoot>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
@endsection

@section('css')
    {{--  <link rel="stylesheet" href="/css/admin_custom.css">  --}}
@endsection

@section('js')
    @include('templates.pager', 
        [
          'pageDivId' => 'users-list', 
          'routeName' => route("userPager"),
          'paging' => 'true',
          'search' => 'true'
        ]
      )
@endsection