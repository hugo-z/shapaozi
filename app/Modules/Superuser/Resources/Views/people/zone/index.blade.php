@extends('master')

@section('content_header')
    <h1>Zone List</h1>
@endsection

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <div class="box-title">
        <a href="{{ route('addZone') }}" class="btn btn-block btn-default btn-flat">
          {!! __('common.html.icons.add') !!} {{ __('superuser::zone.html.text.create_title') }}
        </a>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="zones-list" class="table table-bordered table-hover table-striped">
          <thead>
            <tr>
              <th>{{ __('common.html.label.id') }}</th>
              <th>{{ __('common.html.label.name') }}</th>
              <th>{{ __('superuser::zone.html.text.division_type') }}</th>
              <th>{{ __('superuser::zone.html.text.divisions') }}</th>
              <th>{{ __('superuser::zone.html.text.status') }}</th>
              <th>{{ __('common.html.label.actions') }}</th>
            </tr>
          </thead>
          
          <tfoot>
            <tr>
              <th>{{ __('common.html.label.id') }}</th>
              <th>{{ __('common.html.label.name') }}</th>
              <th>{{ __('superuser::zone.html.text.division_type') }}</th>
              <th>{{ __('superuser::zone.html.text.divisions') }}</th>
              <th>{{ __('superuser::zone.html.text.status') }}</th>
              <th>{{ __('common.html.label.actions') }}</th>
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

@section('js')
    @include('templates.pager', 
      [
        'pageDivId' => 'zones-list', 
        'routeName' => route("zonesPager"),
        'paging' => 'true',
        'search' => 'true'
      ]
    )
@endsection