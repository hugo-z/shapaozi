$(function () {
    var $zoneSelect = $('.zone-select');
    var $zoneType = $('.zoneType');
    var $locationSelect = $('.location');

    $zoneSelect.select2();

    // The onChange event on the zone type selection dropdown      
    $zoneType.on('change', function (e) {
        getAssociatedSelection();
    })
    

    // The onChange event on the location selection dropdown
    $locationSelect.on('change', function (e) {
        getSubsidiaries($(this));
    })

    // Add change event on future selection
    $locationSelect.parent().parent().parent().delegate('.location', 'change', function (e) {
        console.log($locationSelect.parent().parent().parent());
        getSubsidiaries($(this));
    })

    
})

// Get the dropdown list in accordance with the given zone type
function getAssociatedSelection() {
    var $zoneType  = $('.zoneType').val();
    var $zoneGroup = $('.zone-group .col-md-6');

    if ($zoneType != 0) {
        $.ajax({
            url: "{{ route('ajaxZones') }}",
            type: "GET",
            dataType: "json",
            data: {zoneType: $zoneType},
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                console.log(errorThrown);
            },
            success: function (data) {
                $zoneGroup.append(data['html']);
            }
        })
    }
}

// Get the subsidiaries of the selected location
function getSubsidiaries(that) {
    var $locationId = that.val();
    var $zoneGroup  = $('.zone-group .col-md-6');
    var $zoneType   = $('.zoneType').val();
    
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
                $zoneGroup.append(data['html']);
            }
        })
    }
    
}