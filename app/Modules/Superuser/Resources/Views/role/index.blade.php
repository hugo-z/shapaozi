@extends('master')

@section('title', 'Roles Manage')

@section('content_header')
    <h1>Roles Manage</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="box-title">
          <a href="{{ route('addRole') }}" class="btn btn-block btn-default btn-flat">
            {!! __('common.html.icons.add') !!} {{ __('superuser::role.html.button.create') }}
          </a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="roles-list" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>{{ __('common.html.label.id') }}</th>
              <th>{{ __('superuser::role.html.list.name') }}</th>
              <th>{{ __('superuser::role.html.list.permission') }}</th>
              <th>{{ __('superuser::role.html.list.created') }}</th>
              <th>{{ __('superuser::role.html.list.actions') }}</th>
            </tr>
          </thead>
          
          <tfoot>
            
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
          'pageDivId' => 'roles-list', 
          'routeName' => route("rolePager"),
          'paging' => 'true',
          'search' => 'true'
        ]
      )
@endsection