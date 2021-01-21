<!-- Modal: modalCategoriesExport -->
<div class="modal fade" id="modalCategoriesExport" tabindex="-1" role="dialog" aria-labelledby="modalCategoriesExportTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCategoriesExportTitle">
                    @ucfirst(__('app.categoryExport'))
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <small>@ucfirst(__('app.categoryExportData'))</small>
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.export.xls.categories', ['type' => 'xlsx']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-excel" aria-hidden="true"></i> Excel
                </a>
                <a href="{{ route('admin.export.xls.categories', ['type' => 'csv']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-csv" aria-hidden="true"></i> CSV
                </a>
                <a href="{{ route('admin.export.xls.categories', ['type' => 'html']) }}" class="list-group-item list-group-item-action">
                    <i class="fas fa-file-code" aria-hidden="true"></i> HTML
                </a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">@ucfirst(__('app.close'))</button>
                <button type="submit" class="btn btn-primary">@ucfirst(__('app.categoryExport'))</button>
            </div>
        </div>
    </div>
</div>