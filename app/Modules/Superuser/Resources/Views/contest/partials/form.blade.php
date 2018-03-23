<form method="POST" action="{{ action('ContestController@store') }}" id="contest">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="panel-body">
                    <div class="form-group">
                        <label for="name">{{ trans('common.html.label.name') }}:</label>
                        <input type="text" class="form-control" id="name" name="name" value="" placeholder="{{ trans('common.html.label.name') }}">
                    </div>
                    <div class="form-group">
                        <label for="active">{{ trans('common.html.input.active') }}:</label>
                        <div class="switch">
                            <input type="checkbox" id="active" name="active">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="form-control btn btn-default btn-flat" onclick="saveContest(this.form);">{{ trans('common.html.button.submit') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>