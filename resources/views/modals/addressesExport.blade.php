<!-- Modal: modalAddressesExport -->
<div class="modal fade" id="modalAddressesExport" tabindex="-1" role="dialog" aria-labelledby="modalAddressesExportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAddressesExportTitle">
                    @ucfirst(__('app.addressExport'))
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <small>@ucfirst(__('app.addressExportData'))</small>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.export.doc.addresses', ['type' => 'docx']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-word" aria-hidden="true"></i> Word
                </a>
                <a href="{{ route('admin.export.xls.addresses', ['type' => 'xlsx']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-excel" aria-hidden="true"></i> Excel
                </a>
                <a href="{{ route('admin.export.xls.addresses', ['type' => 'csv']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-csv" aria-hidden="true"></i> CSV
                </a>
                <a href="{{ route('admin.export.xls.addresses', ['type' => 'html']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-code" aria-hidden="true"></i> HTML
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@ucfirst(__('app.close'))</button>
            </div>
        </div>
    </div>
</div>