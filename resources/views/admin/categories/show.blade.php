@extends('layouts.admin')
@section('title', $category->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <a href="{{ route('admin.category.index') }}" class="text-dark text-decoration-none">
            <i class="fas fa-folder-open" aria-hidden="true" title="@ucfirst(__('app.categoriesList'))"></i>
        </a>
        {{ $category->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @can('update')
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCategoryEdit">
                <i class="fas fa-edit" aria-hidden="true" title="@ucfirst(__('app.categoryEdit'))"></i>
                <span class="sr-only">@ucfirst(__('app.categoryEdit'))</span>
            </button>
        </div>
        @endcan
        @can('create')
        <div class="btn-group mr-2">
            <a href="{{ route('admin.address.create') }}" role="button" class="btn btn-sm btn-secondary">
                <i class="fas fa-plus" aria-hidden="true" title="@ucfirst(__('app.addressCreate'))"></i>
                <span class="sr-only">@ucfirst(__('app.addressCreate'))</span>
            </a>
            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalAddressesImport">
                <i class="fas fa-file-upload" aria-hidden="true" title="@ucfirst(__('app.modalAddressesImport'))"></i>
                <span class="sr-only">@ucfirst(__('app.modalAddressesImport'))</span>
            </button>
        </div>
        @endcan
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
            
<div class="row row-cols-1 mt-2">
    <div class="col mb-4">
        <div class="card">
            <div class="list-group list-group-flush">
                @if (count($category->hasAddresses) < 1)
                <a href="{{ route('admin.address.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>
                        @ucfirst(__('app.addressCreate'))
                    </span>
                    <span class="badge badge-primary badge-pill">&raquo;</span>
                </a>
                @endif
                @foreach($addresses as $address)
                <a href="{{ route('admin.address.show', ['uuid' => $address->uuid]) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>
                        {{ $address->name }}<br />
                        @if ($address->owner)
                        <small>
                            <i class="fas fa-user-tie" aria-hidden="true"></i> 
                            {{ $address->owner }}
                        </small><br />
                        @endif
                        <small>
                            <i class="fas fa-address-book" aria-hidden="true"></i>
                            {{ $address->address }}
                        </small>
                    </span>
                    <span>
                        <i class="@if($address->status) fas fa-store-alt text-success @else fas fa-store-alt-slash text-danger @endif" aria-hidden="true"></i>
                        {{ $address->locatedAt->flag }}
                    </span>
                </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
    
{{ $addresses->links() }}
    
@include('modals.categoryEdit')
@endsection