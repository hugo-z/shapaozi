$(document).ready(function() {
    var provinceSelector = $('.provinces');
    provinceSelector.on('select2:select', function (e) {
        var selectedLocation = e.params.data.id;
        console.log(typeof(provinceSelector.attr('multiple')));
        if (typeof(provinceSelector.attr('multiple')) == 'undefined') {
            $('.city-select').removeClass('field-display');
            $.ajax({
                url: locationUrl,
                dataType: 'json',
                type: 'GET',
                data: {locationId: selectedLocation},
                success: function (cityData) {
                    var locationData = cityData.array;
                    
                    if ($('.cities').children().length > 0) {
                        $('.cities').children().remove();
                    }

                    $('.cities').select2({
                        'data': locationData,
                        'multiple': true,
                        'name': 'cities[]'
                    });
                }
            });  
        }
              
    });
    
})

/* Form submit action */
function submitForm(node, step, url = '')
{
    var frm = document.forms[1];
    var stepSelector = document.getElementById('step');

    frm.action = url;
    stepSelector.value = step;
    frm.submit();
}

/* Generate random password */
function randPassword(btn, digits = 8, changeButtonText)
{
    var chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678';
    var maxPos = chars.length;
    var password = '';

    for (var i = 0; i < digits; i++) {
        password += chars.charAt(Math.floor(Math.random() * maxPos));
    }

    btn.innerHTML = changeButtonText;
    document.getElementById('password').value = password;
}

/* Save Contest Form */
function saveContest(frm)
{
    var action = frm.action;
    var status = 0;
    if ($('#active').is(':checked')) {
        status = 1;
    }
    
    $.ajax({
        url: action,
        type: 'POST',
        dataType: 'json',
        data: {
            _token: frm.elements['_token'].value,
            name: frm.elements['name'].value,
            status: status
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        },
        success: function (data) {
            switch (data.status) {
                case false:
                    $.map(data.msg, function (param, i) {
                        var selector = $('#' + i);
                        selector.parent().addClass('has-error')
                        
                        selector.popover({
                            'animation': true,
                            'container': false,
                            'content': param,
                            'placement': 'top'
                        })
                    });
                    break;
                case true:
                    $('.modal').modal('hide');
                    location.reload();
            }
        }
    })
}

// Edit an existing contest
function editContest(contest = '', storeUrl)
{
    var frmEle      = $('#contest');
    var nameEle     = $('#name');
    var statusEle   = $('#active');
    var action      = storeUrl;

    if (contest) {
        var contestObj  = JSON.parse(contest);
        action += '/' + contestObj.id;
        
        nameEle.val(contestObj.name);
        switch (contestObj.status) {
            case 0:
                statusEle.bootstrapSwitch('state', false);
                break;
            case 1:
                statusEle.bootstrapSwitch('state', true);
                break;
        }
    } else {
        nameEle.val('');
        statusEle.bootstrapSwitch('state', false);
    }
    
    frmEle.attr('action', action);
}

// Select Country
function selectCountry()
{
    $('.provinceCity').removeClass('disabled');
    $('.provinceCity').children().prop('disabled', false);
}

// Select division type
function selectDivisionType(that, selectedValue = '')
{
    var location = !selectedValue ? $('.country').val() : selectedValue;
    var divisionType = that.children().val();
    
    switch (location) {
        case '0':
            var msg = "Please select country";
            
            that.popover({
                'animation': true,
                'container': false,
                'placement': 'top',
                'content': msg
            })
            break;
        default:
            that.popover('destroy');
            $.ajax({
                url: locationUrl,
                type: 'GET',
                dataType: 'json',
                data: {locationId: location},
                success: function (data) {
                    var locationArray = data.array;
                    
                    switch (divisionType) {
                        case 'province':
                            $('.province-select').removeClass('field-display');
                            $('.cities').removeAttr('name');

                            if ($('.cities').children().length > 0) {
                                $('.cities').children().remove();
                                $('.city-select').addClass('field-display');
                            }

                            $('.provinces').select2({
                                'data': locationArray,
                                'multiple': true,
                                'width': '120%'
                            });
                            break;
                        case 'city':
                            $('.province-select').removeClass('field-display');
                            if (typeof($('.cities').attr('name')) == 'undefined') {
                                $('.cities').attr('name', 'cities[]');
                                $('.provinces').removeAttr('name');
                            }
                            $('.provinces').select2({
                                'data': locationArray,
                                'multiple': false
                            });
                            // getAssociatedLocations();
                            break;
                    }
                    // $('.division-group').html(html);
                    
                }
            })
            break;
    }
    
}

// Creat or edit template
function editTemplate(templId, actionUrl)
{
    
}