<!-- Modal -->
<div class="modal fade" id="exchangeModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('group.exchange.new')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-deck d-flex align-items-center">
                    <div class="card source-card w-45 border-primary">
                        <div class="card-header"></div>
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted"></h6>
                            <p class="card-text"></p>
                        </div>
                    </div>
                    <a class="submit-btn" href="#"><i class="fas fa-3x fa-arrow-circle-right"></i></a>
                    <div class="card target-card w-45 border-primary">
                        <div class="card-header">
                            <select class="selectpicker" name="target_id" data-width="100%"></select>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle text-muted"></h6>
                            <p class="card-text"></p>
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="modal-footer">--}}
                {{--<button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('global.cancel')</button>--}}
                {{--<button type="button" class="btn btn-success">@lang('global.submit')</button>--}}
            {{--</div>--}}
        </div>
    </div>
</div>