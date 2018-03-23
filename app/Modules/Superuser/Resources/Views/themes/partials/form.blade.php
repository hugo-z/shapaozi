<form action="{{ action('TemplateController@store') }}">
    {{ csrf_field() }}
    <div class="row">
        <div class="panel">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ trans('common.html.label.name') }}:</label>
                            <input type="text" class="form-control" name="name" value="{{ isset($templ) ? $templ->name : old('name') }}">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">{{ trans('common.html.label.name') }}:</label>
                            <input type="text" class="form-control" name="name" value="{{ isset($templ) ? $templ->name : old('name') }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                
                </div>
            </div>
        </div>
    </div>
</form>