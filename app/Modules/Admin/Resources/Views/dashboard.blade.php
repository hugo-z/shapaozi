@extends('adminlte::page')

@section('title', __('admin::dashboard.html.title'))

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
    <!-- Info boxes -->
    <div class="row">
        @if(auth()->user())
        @include('admin::templates.contestant')
        @endif
        <!-- /.col -->
      </div>
      <!-- /.row -->
@endsection

@section('js')
    <script> console.log('Hi!'); </script>
@endsection