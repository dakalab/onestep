<!-- Terms and conditions modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="Terms and conditions" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><b>{{ __('adminlte_lang::message.conditions') }}</b></h3>
            </div>

            <div class="modal-body">
            <div id="conditionsMainContent" class="content">
            {!! \Setting::getValue('terms') !!}
            </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
