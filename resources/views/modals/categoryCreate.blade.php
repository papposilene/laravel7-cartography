<!-- Modal: modalCategoryEdit -->
<div class="modal fade" id="modalCategoryCreate" tabindex="-1" role="dialog" aria-labelledby="modalCategoryCreateTitle" aria-hidden="true">
    <form method="POST" action="{{ route('admin.category.store') }}" class="needs-validation" novalidate>
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">    
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCategoryCreateTitle">
                        @ucfirst(__('app.categoryCreate'))
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary border-primary text-white" id="input-category">
                                <i class="fas fa-folder-open" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" name="category_name" class="form-control border-primary" autocomplete="off" required="required" placeholder="@ucfirst(__('app.formCategory'))" aria-label="@ucfirst(__('app.category'))" aria-describedby="input-category" />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary border-primary text-white" id="input-icon">
                                <i class="fas fa-image" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" name="category_icon" class="form-control border-primary" autocomplete="off" required="required" placeholder="@ucfirst(__('app.formIcon'))" aria-label="@ucfirst(__('app.formIcon'))" aria-describedby="input-icon" />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary border-primary text-white" id="input-color">
                                <i class="fas fa-palette" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" id="color" name="category_color" class="form-control border-primary" autocomplete="off" required="required" placeholder="@ucfirst(__('app.hexade'))" aria-label="@ucfirst(__('app.formColor'))" aria-describedby="input-color" />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary border-secondary text-white" id="input-description">
                                <i class="fas fa-comment-alt" aria-hidden="true"></i>
                            </span>
                        </div>
                        <textarea id="descForm" name="category_description" class="form-control border-secondary autocomplete="off" required="required" placeholder="@ucfirst(__('app.formDescription'))" rows="5" aria-label="@ucfirst(__('app.formDescription'))" aria-describedby="input-description" /></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">@ucfirst(__('app.close'))</button>
                    <button type="submit" class="btn btn-primary">@ucfirst(__('app.save'))</button>
                </div>
            </div>
        </div>
    </form>
</div>