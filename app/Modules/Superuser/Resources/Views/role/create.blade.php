@extends('master')

@section('title', 'Add a role')

@section('content_header')
<h1>添加角色</h1>
@endsection

@section('content')
<div class="">
    <!-- general form elements disabled -->
    <div class="box box-warning">
        <!-- /.box-header -->
        <div class="box-body">
            @include('superuser::templates.errors')
            @include('superuser::templates.status')
            @include('superuser::role.partials.form')
        </div>
    <!-- /.box-body -->
    </div>
    <!-- /.box -->
</div>
@endsection

@section('js')
<script>
    $(function() {
        $('#permissions').select2();
    })
</script>
@endsection