<div class="modal fade addContestForm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4>{{ trans('superuser::contest.html.common.create_title') }}</h4>
            </div>
            <div class="modal-body">
                @include('superuser::contest.partials.form')
            </div>
        </div>
    </div>
</div>