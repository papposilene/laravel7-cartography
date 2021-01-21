<!-- Modal: modalUserUpdate -->
<div class="modal fade" id="modalRoleUpdate" tabindex="-1" role="dialog" aria-labelledby="modalRoleUpdateTitle" aria-hidden="true">    
    <div class="modal-dialog modal-dialog-centered" role="document">    
        <form method="POST" action="{{ route('admin.user.role') }}" class="needs-validation" novalidate />
            @csrf
            <input type="hidden" name="user_uuid" value="{{ $user->uuid }}" required="required" />
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRoleUpdateTitle">@ucfirst(__('app.userUpdate'))</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-secondary border border-secondary text-white" id="input-fname">
                                        <i class="fas fa-user" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" readonly name="user_fname" class="form-control border border-secondary" placeholder="@ucfirst(__('auth.fname'))" value="{{ $user->fname }}" autocomplete="off" aria-label="@ucfirst(__('auth.fname'))" aria-describedby="input-fname" />
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-secondary border border-secondary text-white" id="input-lname">
                                        <i class="fas fa-user-tie" aria-hidden="true"></i>
                                    </span>
                                </div>
                                <input type="text" readonly name="user_lname" class="form-control border border-secondary" placeholder="@ucfirst(__('auth.lname'))" value="{{ $user->lname }}" autocomplete="off" aria-label="@ucfirst(__('auth.lname'))" aria-describedby="input-lname" />
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary border border-primary text-white" id="input-username">
                                <i class="fas fa-user-secret" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" readonly name="user_uname" class="form-control border border-secondary" placeholder="@ucfirst(__('auth.uname'))" value="{{ $user->uname }}" autocomplete="off" required="required" aria-label="@ucfirst(__('auth.uname'))" aria-describedby="input-username" />
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-secondary border border-primary text-white" id="input-mail">
                                <i class="fas fa-at" aria-hidden="true"></i>
                            </span>
                        </div>
                        <input type="text" readonly name="user_email" class="form-control border border-secondary" placeholder="@ucfirst(__('auth.email'))" value="{{ $user->email }}" autocomplete="off" required="required" aria-label="@ucfirst(__('auth.email'))" aria-describedby="input-mail" />
                    </div>
                    @role('superAdmin')
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary border border-primary text-white" id="input-role">
                                &nbsp;<i class="fas fa-id-badge" aria-hidden="true"></i>
                            </span>
                        </div>
                        <select name="user_role" class="form-control border border-primary" required="required" aria-describedby="input-role">
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}" @if ($user->roles->first()->name === $role->name)selected="selected"@endif>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endrole
                    <button type="submit" class="btn btn-primary mt-3 float-right">@ucfirst(__('app.save'))</button>
                </div>
            </div>
        </form>
    </div>
</div>