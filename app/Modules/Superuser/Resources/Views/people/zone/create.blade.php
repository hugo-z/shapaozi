@extends('master')

@section('content_header')
    <h1>{{ trans('') }}</h1>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/superuser/common.css') }}">
@endpush
@push('js')
    <script>
        var locationUrl = '{{ route('ajaxZones') }}'
        var provinceLabel = '{{ trans('common.html.label.province') }}';
        var option1 = '{{ trans('common.html.option1') }}';
    </script>
    <script src="{{ asset('js/functions.js') }}"></script>
@endpush

@section('content')

<div class="panel panel-default">
    <!-- /.box-header -->
    <div class="panel-heading">
        {{ trans('superuser::zone.html.text.create_title') }}
    </div>
    <div class="panel-body">
        @include('superuser::templates.errors')
        @include('superuser::templates.status')
        @include('superuser::people.zone.partials.form')
    </div>
    <!-- /.box-body -->
</div>
@endsection

@section('js')
@include('superuser::people.zone.partials.zone-create')
@endsection