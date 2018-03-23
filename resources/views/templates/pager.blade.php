<script>
    $(function () {
        var listIdSelecter = $('#{{ $pageDivId }}')
        listIdSelecter.DataTable({
            'ajax'        : '{{ $routeName }}',
            'paging'      : {{ $paging }},
            'lengthChange': true,
            'searching'   : {{ $search }},
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : true,
            'processing'  : true,
            'responsive'  : true,
            'rowReorder'  : {
                'selector': 'td:nth-child(2)'
            }
        })
    })
</script>