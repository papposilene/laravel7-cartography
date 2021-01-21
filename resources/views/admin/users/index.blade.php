@extends('layouts.admin')
@section('title', @ucfirst(__('app.usersList')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users" aria-hidden="true"></i>
        @ucfirst(__('app.usersList'))
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @role('superAdmin')
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalUserInvite">
                <i class="fas fa-user" aria-hidden="true" title="@ucfirst(__('app.userInvite'))"></i>
                <span class="sr-only">@ucfirst(__('app.userInvite'))</span>
            </button>
        </div>
        <div class="btn-group mr-2">
            <a href="{{ route('admin.user.index', ['deleted' => 1]) }}" role="button" class="btn btn-sm btn-warning">
                <i class="fas fa-history" aria-hidden="true" title="@ucfirst(__('app.history'))"></i>
                <span class="sr-only">@ucfirst(__('app.history'))</span>
            </a>
        </div>
        @endrole
        <form action="{{ route('admin.user.search') }}" method="POST">
            @csrf
            <div class="input-group input-group-sm">
                <input type="text" class="form-control border border-secondary" name="q" placeholder="@ucfirst(__('app.search'))" aria-label="@ucfirst(__('app.search'))">
				<div class="input-group-append">
                    <button type="submit" class="border border-secondary btn-sm">
                        <i class="fas fa-search" aria-hidden="true" aria-label="@ucfirst(__('app.search'))"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
    
{{ $users->links() }}

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">
                    @ucfirst(__('app.userName'))
                    <span class="badge badge-pill badge-info float-right">
                        <i class="fas fa-angle-down" aria-hidden="true" aria-label="@ucfirst(__('app.orderByAsc'))"></i>
                    </span>
                </th>
                @role('superAdmin'|'admin')
                <th class="text-center">@ucfirst(__('app.userRole'))</th>
                @endrole
                <th class="text-center">@ucfirst(__('app.userActivity'))</th>
                <th class="text-center">@ucfirst(__('app.userLastIn'))</th>
                <th class="text-center">@ucfirst(__('app.actions'))</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            @role('guest')
            @continue($user->uuid != Auth::id())
            @endrole
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ route('admin.user.show', ['uuid' => $user->uuid]) }}" class="text-dark text-decoration-none">
                        {{ $user->uname }}
                    </a>
                </td>
                @role('superAdmin'|'admin')
                <td>
                    @if ($user->approved_at)
                    {{ $user->roles->first()->name }}
                    @else
                    @ucfirst(__('app.userWaiting'))
                    @endif
                </td>
                @endrole
                <td class="text-center">
                    {{ count($user->hasActivities) }}
                </td>
                <td class="text-center">
                    @if ($user->lastLoginAt())
                    @datetime($user->lastLoginAt())
                    @else
                    00/00/0000 @ 00:00
                    @endif
                </td>
                <td class="text-center">
                    @can('delete')
                    @if ($user->deleted_at)
                    <form action="{{ route('admin.user.restore') }}" method="POST">    
                    @else
                    <form action="{{ route('admin.user.delete') }}" method="POST">
                    @endif
                        @csrf
                        <input type="hidden" name="user_uuid" value ="{{ $user->uuid }}" />
                        @endcan
                        <a href="{{ route('admin.user.show', ['uuid' => $user->uuid]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </a>
                        @can('delete')
                        @if ($user->deleted_at)
                        <button class="btn btn-sm btn-warning">
                            <i class="fas fa-history" aria-hidden="true"></i>
                        </button>
                        @else
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash" aria-hidden="true"></i>
                        </button>
                        @endif
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $users->links() }}

@endsection