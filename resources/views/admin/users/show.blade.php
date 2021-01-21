@extends('layouts.admin')
@section('title', $user->uname)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <a href="{{ route('admin.user.index') }}" class="text-dark text-decoration-none">
            <i class="fas fa-user" aria-hidden="true" title="@ucfirst(__('app.usersList'))"></i>
        </a>
        {{ $user->uname }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(Auth::id() === $user->uuid)
        @can('update')
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUserUpdate">
                <i class="fas fa-edit" aria-hidden="true" title="@ucfirst(__('app.userEdit'))"></i>
                <span class="sr-only">@ucfirst(__('app.userEdit'))</span>
            </button>
        </div>
        @endcan
        @endif
        @role('superAdmin')
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalRoleUpdate">
                <i class="fas fa-user-check" aria-hidden="true" title="@ucfirst(__('app.userEdit'))"></i>
                <span class="sr-only">@ucfirst(__('app.userEdit'))</span>
            </button>
        </div>
        @endrole
    </div>
</div>
            
<div class="row row-cols-1 mt-2">
    <div class="col mb-4">
        <div class="card">
            <div class="list-group list-group-flush">
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $user->uname }}</span>
                    <span class="badge badge-primary">{{ $user->roles->first()->name }}</span>
                </div>
                <div class="list-group-item">
                    {{ $user->email }}
                </div>
                <div class="list-group-item">
                    {{ $user->fname }} {{ $user->lname }}
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.userActivities'))</span>
                    <span>{{ count($user->hasActivities) }}</span>
                </div>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.userLastLog'))</span>
                    <span>
                        @if ($user->lastLoginAt())
                        @datetime($user->lastLoginAt())
                        @else
                        00/00/0000 @ 00:00    
                        @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

@empty($user->approved_at)
<div class="row row-cols-1 mt-2">
    <div class="col mb-4">
        <div class="card">
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.user.approve', ['uuid' => $user->uuid]) }}" class="list-group-item list-group-item-action list-group-item-success d-flex justify-content-center">
                    @ucfirst(__('app.userApproval'))
                </a>
                <a href="{{ route('admin.user.disapprove', ['uuid' => $user->uuid]) }}" class="list-group-item list-group-item-action list-group-item-danger d-flex justify-content-center">
                    @ucfirst(__('app.userDisapproval'))
                </a>
            </div>
        </div>
    </div>
</div>
@endempty

@isset($user->hasActivities)
<div class="row row-cols-1 mt-2">
    <div class="col mb-4">
        <div class="card">
            <div class="card-header">
                @ucfirst(__('app.activityLog'))
            </div>
            <div class="list-group list-group-flush">
                @foreach ($user->hasActivities->sortByDesc('id') as $activity)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>
                        # {{ $activity->id }}. @ucfirst(__('app.activity' . ucfirst($activity->description)))
                        @if ($activity->subject_type === 'App\Address' && isset($activity->isAddress->name))
                        &laquo; {{ $activity->isAddress->name }} &raquo;.
                        @elseif ($activity->subject_type === 'App\Category' && isset($activity->isCategory->name))
                        &laquo; {{ $activity->isCategory->name }} &raquo;.
                        @elseif ($activity->subject_type === 'App\User' && isset($activity->isUser->uname))
                        &laquo; {{ $activity->isUser->uname }} &raquo;.
                        @else
                        &laquo; {{ __('app.activityItemDeleted') }} &raquo;.
                        @endif
                    </span>
                    <span>@datetime($activity->created_at)</span>
                </div>
                @break($loop->iteration == 10)
                @endforeach
            </div>
        </div>
    </div>
</div>
@endisset

@role('superAdmin')
@include('modals.roleUpdate')
@endrole
@include('modals.userUpdate')
@endsection