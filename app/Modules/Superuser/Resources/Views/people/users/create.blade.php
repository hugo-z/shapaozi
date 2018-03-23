@extends('master')

@section('title', 'Add a User')

@section('content_header')
@switch ($step)
    @case (1)
        <h1>添加角色 - 基本信息</h1>
        @break
    @case (2)
        <h1>添加角色 - 设置赛区</h1>
        @break
    @case (3)
        <h1>添加角色 - 设置用户角色</h1>
        @break
@endswitch
@endsection

@section('content')
<div class="">
    <!-- general form elements disabled -->
    {{--  <div class="box box-warning">  --}}
        <!-- /.box-header -->
        <div class="box-body">
            @include('superuser::templates.errors')
            @include('superuser::templates.status')
            @include('superuser::people.users.partials.form', 
                        [
                            'locationUrl' => action('LocationController@ajaxData')
                        ]
                    )
        </div>
    <!-- /.box-body -->
    {{--  </div>  --}}
    <!-- /.box -->
</div>
{{--  {{ dd(public_path('js/superuser/function.js')) }}  --}}
@endsection

@section('js')
<script src="{{ asset('js/superuser/location.js') }}"></script>
<script src="{{ asset('js/functions.js') }}"></script>
<script>
    // Country select    
    $(function() {
        $('#roles').select2();
        $('.location').select2({
            'width': '100%'
        });
    })
</script>
@endsection