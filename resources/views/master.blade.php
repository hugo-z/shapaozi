@extends('adminlte::page')

@push('css')
    @if(config('adminlte.plugins.responsive'))
        <link rel="stylesheet" href="//cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
        <link rel="stylesheet" href="//cdn.datatables.net/responsive/2.2.1/css/responsive.dataTables.min.css">
    @endif

    @if(config('adminlte.plugins.bootstrapswitch'))
        <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-switch-master/dist/css/bootstrap3/bootstrap-switch.min.css') }}">
    @endif
@endpush

@push('js')
    @if(config('adminlte.plugins.responsive'))
        <script src="//cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"></script>
        <script src="//cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js"></script>
    @endif

    @if (config('adminlte.plugins.vue'))
        <script src="{{ asset('bower_components/vue/dist/vue.js') }}"></script>
    @endif
    
    @if(config('adminlte.plugins.bootstrapswitch'))
        <script src="{{ asset('vendor/bootstrap-switch-master/dist/js/bootstrap-switch.min.js') }}"></script>
        <script>
            $("[type='checkbox']").bootstrapSwitch();
        </script>
    @endif
@endpush