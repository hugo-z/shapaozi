// Location dropdown
$(function () {
    var locationSelector = $('.location');
    var locationUrl = $('#locationUrl').val();

    locationSelector.parent().delegate ('.location', 'change',  function () {
        if (this.value.length !== 0 && this.id !== 'district') {
            var that = this;
            $.ajax ({
                url: locationUrl,
                type: 'GET',
                dataType: 'json',
                data: {locationId: this.value, type: that.id},
                success: function (data) {
                    var options = '<option value="">请选择...</option>';
                    switch (that.id) {
                        case 'country':
                            var selectSelector = $('#province');
                            break;
                        case 'province':
                            var selectSelector = $('#city');
                            break;
                        case 'city':
                            var selectSelector = $('#district');
                            break;
                        default:
                            break;
                    }
                    
                    for (var i = 0; i < data.length; i++) {
                        options += '<option value="' + data[i].location_id + '">' + data[i].name + '</option>';
                    }

                    selectSelector.append(options);
                }
            })
        }
    })
});
