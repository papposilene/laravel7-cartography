@extends('layouts.admin')
@section('title', @ucfirst(__('app.addressesList')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-address-book" aria-hidden="true"></i>
        @ucfirst(__('app.addressesList'))
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @can('create')
        <div class="btn-group mr-2">
            <a href="{{ route('admin.address.create') }}" role="button" class="btn btn-sm btn-primary">
                <i class="fas fa-plus" aria-hidden="true" title="@ucfirst(__('app.addressCreate'))"></i>
                <span class="sr-only">@ucfirst(__('app.addressCreate'))</span>
            </a>
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAddressesImport">
                <i class="fas fa-file-upload" aria-hidden="true" title="@ucfirst(__('app.addressImport'))"></i>
                <span class="sr-only">@ucfirst(__('app.addressImport'))</span>
            </button>
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalAddressesExport">
                <i class="fas fa-file-download" aria-hidden="true" title="@ucfirst(__('app.addressExport'))"></i>
                <span class="sr-only">@ucfirst(__('app.addressExport'))</span>
            </button>
        </div>
        @endcan
        @role('superAdmin')
        <div class="btn-group mr-2">
            <a href="{{ route('admin.address.index', ['deleted' => 1]) }}" role="button" class="btn btn-sm btn-warning">
                <i class="fas fa-history" aria-hidden="true" title="@ucfirst(__('app.history'))"></i>
                <span class="sr-only">@ucfirst(__('app.history'))</span>
            </a>
        </div>
        @endrole
        <form action="{{ route('admin.address.search') }}" method="POST">
            @csrf
            <div class="input-group input-group-sm">
                <input type="text" class="form-control border border-secondary" name="q" value="{{ old('q') }}" placeholder="@ucfirst(__('app.search'))" aria-label="@ucfirst(__('app.search'))">
                <div class="input-group-append">
                    <button type="submit" class="border border-secondary btn-sm">
                        <i class="fas fa-search" aria-hidden="true" aria-label="@ucfirst(__('app.search'))"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
    
{{ $addresses->links() }}

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">@ucfirst(__('app.category'))</th>
                <th class="text-center">
                    @ucfirst(__('app.addressName'))
                    <span class="badge badge-pill badge-info float-right">
                        <i class="fas fa-angle-down" aria-hidden="true" aria-label="@ucfirst(__('app.orderByAsc'))"></i>
                    </span>
                </th>
                <th class="text-center">@ucfirst(__('app.country'))</th>
                <th class="text-center">@ucfirst(__('app.actions'))</th>
            </tr>
        </thead>
        <tbody>
            @foreach($addresses as $address)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.category.show', ['uuid' => $address->inCategory->uuid]) }}"
                        class="text-dark text-decoration-none"
                        title="{{ $address->inCategory->name }}">
                        <i class="{{ $address->inCategory->icon }}" aria-hidden="true"></i>
                        <span class="sr-only">{{ $address->inCategory->name }}</span>
                    </a>
                </td>
                <td>
                    <span class="badge badge-pill float-right">
                        <i class="@if($address->status) fas fa-store-alt text-success @else fas fa-store-alt-slash text-danger @endif" aria-hidden="true"></i>
                    </span>
                    <a href="{{ route('admin.address.show', ['uuid' => $address->uuid]) }}" class="text-dark text-decoration-none">
                        {{ $address->name }}
                    </a><br />
                    <small>{{ $address->address }}</small>
                </td>
                <td>
                    <a href="{{ route('admin.country.show', ['cca3' => strtolower($address->locatedAt->cca3)]) }}" class="text-dark text-decoration-none">
                        {{ $address->locatedAt->flag }}
                        {{ $address->locatedAt->name_eng_common }}
                    </a>
                </td>
                <td class="text-center">
                    @can('delete')
                    @if ($address->deleted_at)
                    <form action="{{ route('admin.address.restore') }}" method="POST">    
                    @else
                    <form action="{{ route('admin.address.delete') }}" method="POST">
                    @endif
                        @csrf
                        <input type="hidden" name="address_uuid" value ="{{ $address->uuid }}" />
                        @endcan
                        <a href="{{ route('admin.address.show', ['uuid' => $address->uuid]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </a>
                        @can('delete')
                        @if ($address->deleted_at)
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

{{ $addresses->links() }}

@include('modals.addressesImport')
@include('modals.addressesExport')
@endsection