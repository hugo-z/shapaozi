<form role="form" method="POST" action="{{ action('UsersController@store') }}" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <!-- step 1 -->
    @if ($step == 1)
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('superuser::user.html.text.basic_info') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name">{{ __('common.html.label.name') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="name" placeholder="{{ __('common.html.label.name') }}" value="{{ isset($user) ? $user->name : old('name') }}">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">{{ __('superuser::user.html.text.email') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="email" class="form-control" name="email" placeholder="{{ __('superuser::user.html.text.email') }}" value="{{ isset($user) ? $user->email : old('email') }}">
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="cell">{{ __('superuser::user.html.text.cell') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" name="cell" placeholder="{{ __('superuser::user.html.text.cell') }}" value="{{ isset($user) ? $user->cell : old('cell') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cell">{{ __('superuser::user.html.text.pass') }}</label>
                        <div class="row">
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="password" id="password" placeholder="{{ __('superuser::user.html.text.pass') }}" value="{{ old('password') }}">
                            </div>
                            <div class="col-md-4">
                                <button type="button" onclick="randPassword(this, 8, '{{ __('common.html.button.change') }}');" class="form-control btn btn-default btn-flat">{{ __('common.html.button.generate') }}</button>
                            </div>
                        </div>
                    </div>
                    
                    @if (isset($user))
                    <div class="form-group">
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('superuser::user.html.text.loc_choose') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="country">{{ __('common.html.label.country') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="country" id="country" class="location">
                                    <option value="">{{ __('common.html.option1') }}</option>
                                    @foreach ($countryModels as $countryModel)
                                    <option 
                                    value="{{ $countryModel->location_id }}"
                                    @if (isset($user) && $user->country == $countryModel->location_id)
                                    selected
                                    @endif
                                    >
                                    {{ $countryModel->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="province">{{ __('common.html.label.province') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="province" id="province" class="location">
                                    @if (isset($provinceModels))
                                        @foreach ($provinceModels as $provinceModel)
                                        <option 
                                        value="{{ $provinceModel->location_id }}"
                                        @if (isset($user) && $user->province == $provinceModel->location_id)
                                        selected
                                        @endif
                                        >
                                        {{ $provinceModel->name }}
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="city">{{ __('common.html.label.city') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="city" id="city" class="location">
                                    @if (isset($cityModels))
                                        @foreach ($cityModels as $cityModel)
                                        <option 
                                        value="{{ $cityModel->location_id }}"
                                        @if (isset($user) && $user->city == $cityModel->location_id)
                                        selected
                                        @endif
                                        >
                                        {{ $cityModel->name }}
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="country">{{ __('common.html.label.district') }}</label>
                        <div class="row">
                            <div class="col-md-12">
                                <select name="district" id="district" class="location">
                                    @if (isset($districtModels))
                                        @foreach ($districtModels as $districtModel)
                                        <option 
                                        value="{{ $districtModel->location_id }}"
                                        @if (isset($user) && $user->district == $districtModel->location_id)
                                        selected
                                        @endif
                                        >
                                        {{ $districtModel->name }}
                                        </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @elseif ($step == 2)
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('superuser::user.html.text.division_choose') }}
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input 
                            type="radio" 
                            name="divisionOption" 
                            id="provinceDivision" 
                            value="province" 
                            @if (isset($user) && $user->division == $user->province)
                            checked
                            @endif
                            >
                            {{ __('superuser::contest.html.division_options.province') }}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input 
                            type="radio" 
                            name="divisionOption" 
                            id="cityDivision" 
                            value="city"
                            @if (isset($user) && $user->division == $user->city)
                            checked
                            @endif
                            >
                            {{ __('superuser::contest.html.division_options.city') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @elseif ($step == 3)
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('superuser::user.html.text.assign_roles') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label>{{ __('superuser::user.html.text.role') }}</label>
                        <select id="roles" class="form-control" name="roles[]" multiple="true">
                            <option value="0" disabled="true">{{ __('common.html.option1') }}</option>
                            @foreach ($roleModels as $roleModel)
                                <option value="{{ $roleModel->id }}" 
                                    {{ isset($selectedRoles) 
                                    && !empty($selectedRoles) 
                                    && in_array($roleModel->id, $selectedRoles)
                                    ? "selected"
                                    : "" 
                                    }}>
                                    {{ $roleModel->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ __('superuser::user.html.text.ifban') }}
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="suspended">{{ __('superuser::user.html.text.suspended') }}</label>
                        <input 
                            type="checkbox" 
                            id="suspended" 
                            name="suspended" 
                            value="{{ isset($user) ? $user->suspended : 1 }}"
                            @if ($user && $user->suspended == 1)
                            checked
                            @endif
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>

    @elseif ($step == 'final')
    <div class="row">
        <div class="box box-success">
            
            <div class="box-body">
                <div class="form-group">
                    PlaceHolder for displaying overview of the user data
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="form-group">
        <input type="hidden" id="step" name="step" value="{{ is_numeric($step) ? ((int)$step + 1) : $step }}">
        @if (isset($user))
            <input type="hidden" name="user_id" value="{{ $user->id }}">
        @endif
        <input type="hidden" id="locationUrl" value="{{ route('getLoc') }}">
        <div class="row">
            @if ($step && (int)$step > 1)
            <div class="col-md-3">
                <a 
                href=
                "{{ null === $user ? route('editUser', ['step' => ((int)$step - 1)]) : route('editUser', ['id' => $user->id, 'step' => (int)$step - 1]) }}" 
                class="btn btn-block btn-primary btn-flat">
                {{ __('common.html.button.prev') }}
                </a>
            </div>
            @endif

            <div class="col-md-3" style="float:right">
                <a 
                href="javascript:
                submitForm(
                    this, 
                    '{{ is_numeric($step) ? ((int)$step + 1) : $step }}', 
                    '{{ null === $user ? route('addUserStep') : route('addUserStep', ['id' => $user->id]) }}');" 
                class="btn btn-block btn-primary btn-flat">
                    {{ $step == 'final' ? __("common.html.button.complete") : __("common.html.button.next") }}
                </a>
            </div>
            
        </div>
    </div>

    <!-- checkbox -->
    {{--  <div class="form-group">
        <div class="checkbox">
        <label>
            <input type="checkbox">
            Checkbox 1
        </label>
        </div>

        <div class="checkbox">
        <label>
            <input type="checkbox">
            Checkbox 2
        </label>
        </div>

        <div class="checkbox">
        <label>
            <input type="checkbox" disabled="">
            Checkbox disabled
        </label>
        </div>
    </div>  --}}

    <!-- radio -->
    {{--  <div class="form-group">
        <div class="radio">
        <label>
            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked="">
            Option one is this and that—be sure to include why it's great
        </label>
        </div>
        <div class="radio">
        <label>
            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
            Option two can be something else and selecting it will deselect option one
        </label>
        </div>
        <div class="radio">
        <label>
            <input type="radio" name="optionsRadios" id="optionsRadios3" value="option3" disabled="">
            Option three is disabled
        </label>
        </div>
    </div>  --}}
</form>