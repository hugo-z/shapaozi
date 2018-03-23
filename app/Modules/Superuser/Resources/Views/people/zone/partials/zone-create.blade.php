<script>
$ (function () {
    var $zoneSelect = $('.zone-select');
    var $locationSelect = $('.location');

    $zoneSelect.select2();

    // The onChange event on the location selection dropdown
    

    // Add change event on future selection
    /* $locationSelect.parent().parent().parent().delegate('.location', 'change', function (e) {
        getSubsidiaries($(this));
    }) */
})

// Get the subsidiaries of the selected location
function getSubsidiaries(that) {
    var $locationId = that.val();
    var $zoneGroup  = $('.zone-group .col-md-6');
    
    if ($locationId != 0 && typeof(that.attr('multiple')) == 'undefined') {
        $.ajax({
            url: "{{ route('ajaxZones') }}",
            type: "GET",
            dataType: "json",
            data: {locationId: $locationId},
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            success: function (data) {
                // console.log(data.length);return false;
                if (data['array'].length > 0) {
                    switch (data['lvl_type']) {
                        case 0:
                            $('.provinces').html(fillInSelection(data['array']));
                            break;
                        case 1:
                            $('.cities').html(fillInSelection(data['array']));
                    }
                }
                
            }
        })
    }
}

function fillInSelection(data) {
    var html = '<option value="0">请选择...</option>';

    for (var i = 0; i < data.length; i++) {
        html += '<option value="' + data[i]['location_id'] + '" data-lvl="' + data[i]['level_type'] + '">';
        html += data[i]['name'];
        html += '</option>';
    }

    return html;
}
</script>