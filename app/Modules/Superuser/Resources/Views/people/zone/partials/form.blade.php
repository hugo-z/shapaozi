<form role="form" method="post" action="{{ !isset($zone) ? action('ZoneController@store') : action('ZoneController@store', ['id' => $zone->id]) }}">
    {{ csrf_field() }}
    {{--  填写区域名称  --}}
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="name">{{ __('superuser::zone.html.text.name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ isset($zone) ? $zone->name : old('name') }}">
            </div>
        </div>
    </div>
    {{--  选择相关赛事  --}}
    <div class="row">
        <div class="contest">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ __('superuser::zone.html.text.select_contest') }}</label>
                    <select class="form-control zone-select" id="contest" name="contest">
                        <option value="0">{{ __('common.html.option1') }}</option>
                        @if (isset($contests))
                        @foreach ($contests as $contest)
                        <option 
                        value="{{ $contest->id }}"
                        @if (isset($selectedContest) && $contest->id == $selectedContest->id)
                        selected
                        @endif
                        >
                        {{ $contest->name }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                    <p class="help-block text-info">{{ __('superuser::zone.messages.help.contest_select') }}</p>
                </div>
            </div>
        </div>
    </div>
    {{--  选择国家  --}}
    <div class="row">
        <div class="zone-group" id="country">
            <div class="col-md-4">
                <div class="form-group">
                    <label>{{ __('common.html.label.country') }}</label>
                    <select class="form-control zone-select country" name="country" style="width: 100%;" onchange="selectCountry()">
                        <option value="0">{{ __('common.html.option1') }}</option>
                        @if (isset($countries))
                        @foreach ($countries as $country)
                        <option 
                        value="{{ $country->location_id }}" 
                        data-lvl="{{ $country->level_type }}"
                        @if (isset($region) && $country->location_id == $region->location_id)
                        selected
                        @endif
                        >
                        {{ $country->name . ' ' . $country->pinyin }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                </div> 
            </div>
        </div>
    </div>
    {{--  选择赛区类别  --}}
    <div class="row">
        <div class="col-md-4">
                <label>{{ __('superuser::zone.html.text.division_type') }}</label>
            <div class="form-group">
                
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-primary btn-flat 
                    @if (isset($zone))
                    @if ($zone->type == 'province')
                    active
                    @endif
                    @endif
                    provinceCity" onclick="selectDivisionType($(this))" data-trigger="focus">
                        <input 
                        type="radio" 
                        name="divisionType" 
                        id="provinceDivision"
                        autocomplete="off" 
                        @if(isset($zone))
                        @if ($zone->type == 'province')
                        checked
                        @endif
                        @else
                        disabled
                        @endif
                        value="province"
                        > 
                        {{ __('superuser::contest.html.division_options.province') }}
                    </label>
                    <label class="btn btn-primary btn-flat 
                    @if (isset($zone))
                    @if ($zone->type == 'city')
                    active
                    @endif
                    @endif
                    provinceCity" onclick="selectDivisionType($(this))" data-trigger="focus">
                        <input 
                        type="radio" 
                        name="divisionType" 
                        id="cityDivision" 
                        autocomplete="off"
                        @if(isset($zone))
                        @if ($zone->type == 'city')
                        checked
                        @endif
                        @else
                        disabled
                        @endif
                        value="city"
                        > 
                        {{ __('superuser::contest.html.division_options.city') }}
                    </label>
                </div>
                <p class="help-block text-info">{{ __('superuser::zone.messages.help.division_select') }}</p>
            </div>
        </div>
    </div>
    {{--  选择相关大赛地区  --}}
    <div class="row">
        <div class="zone-group division-group">
            <div class="col-md-4 province-select {{ isset($zone) ? '' : 'field-display' }}">
                <label>{{ __('common.html.label.province') }}</label>
                <div class="form-group">
                    <select class="form-control zone-select location provinces" {{ isset($zone) && $zone->type == 'province' ? 'multiple' : '' }} style="width: 100%;" name="provinces[]">
                        @if (isset($zone) && !empty($selectedRegions['provinces']))
                            @foreach ($provinces as $province)
                                <option 
                                value="{{ $province->location_id }}"
                                @if (in_array($province->location_id, $selectedRegions['provinces']))
                                selected
                                @endif
                                >
                                    {{ $province->name . $province->pinyin }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div> 
            </div>

            <div class="col-md-4 city-select {{ isset($zone) && $zone->type == 'city' ? '' : 'field-display' }}">
                <label>{{ __('common.html.label.city') }}</label>
                <div class="form-group">
                    <select class="form-control zone-select location cities" style="width: 100%;" multiple="multiple" name="cities[]">
                        @if (isset($zone) && !empty($selectedRegions['cities']))
                            @foreach ($cities as $city)
                                <option 
                                value="{{ $city->location_id }}"
                                @if (in_array($city->location_id, $selectedRegions['cities']))
                                selected
                                @endif
                                >
                                    {{ $city->name . $city->pinyin }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div> 
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <label for="active">{{ __('superuser::zone.html.text.active') }}</label>
            <div class="form-group">
                <input type="checkbox" class="form-control" id="active" name="active" value="1" {{ isset($zone) ? 'checked' : '' }}>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-md-push-9">
            <div class="form-group">
                <input type="submit" class="form-control btn btn-primary btn-flat" value="{{ __('common.html.button.submit') }}">
            </div>
        </div>
    </div>
</form>