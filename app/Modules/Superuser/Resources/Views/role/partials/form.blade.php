<form role="form" method="POST" action="{{ action('RoleController@store') }}" enctype="multipart/form-data" >
    {{ csrf_field() }}
    <!-- text input -->
    <div class="form-group">
        <label>{{ trans('superuser::role.html.common.role_name') }}</label>
        <input type="text" class="form-control" name="display_name" placeholder="{{ trans('superuser::role.html.common.role_name') }}" value="{{ isset($role) ? $role->display_name : '' }}">
    </div>
    
    <div class="form-group">
        <label>{{ trans('superuser::role.html.common.short_name') }}</label>
        <input type="text" class="form-control" name="name" placeholder="{{ trans('superuser::role.html.common.short_name') }}" value="{{ isset($role) ? $role->name : '' }}">
    </div>
    
    <div class="form-group">
        <label>{{ trans('superuser::role.html.common.permits') }}</label>
        <select id="permissions" class="form-control" name="permissions[]" multiple="true">
            <option value="0" disabled="true">{{ trans('common.html.option1') }}</option>
            @foreach ($permissionModels as $permissionModel)
                <option value="{{ $permissionModel->id }}" 
                    {{ isset($selectedPermissions) 
                    && !empty($selectedPermissions) 
                    && in_array($permissionModel->id, $selectedPermissions)
                    ? "selected"
                    : "" 
                    }}>
                    {{ $permissionModel->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>{{ trans('role.html.common.role_desc') }}</label>
        <textarea id="description" class="form-control" name="description" cols="30" rows="10">{{ isset($role) ? $role->description : "" }}</textarea>
    </div>

    <div class="form-group">
        @if(isset($role))
        <input type="hidden" name="role_id" value="{{ $role->id }}">
        @endif
        <button class="btn btn-block btn-primary btn-flat">{{ trans('common.html.button.submit') }}</button>
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