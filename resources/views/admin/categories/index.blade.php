@extends('layouts.admin')
@section('title', @ucfirst(__('app.categoriesList')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-folder-open" aria-hidden="true"></i>
        @ucfirst(__('app.categoriesList'))
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @can('create')
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalCategoryCreate">
                <i class="fas fa-plus" aria-hidden="true" title="@ucfirst(__('app.categoryCreate'))"></i>
                <span class="sr-only">@ucfirst(__('app.categoryCreate'))</span>
            </button>
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalCategoriesImport">
                <i class="fas fa-file-upload" aria-hidden="true" title="@ucfirst(__('app.categoryImport'))"></i>
                <span class="sr-only">@ucfirst(__('app.categoryImport'))</span>
            </button>
            <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalCategoriesExport">
                <i class="fas fa-file-download" aria-hidden="true" title="@ucfirst(__('app.categoryExport'))"></i>
                <span class="sr-only">@ucfirst(__('app.categoryExport'))</span>
            </button>
        </div>
        @endcan
        @role('superAdmin')
        <div class="btn-group mr-2">
            <a href="{{ route('admin.category.index', ['deleted' => 1]) }}" role="button" class="btn btn-sm btn-warning">
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
    
{{ $categories->links() }}

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">@ucfirst(__('app.icon'))</th>
                <th class="text-center">
                    @ucfirst(__('app.categoryName'))
                    <span class="badge badge-pill badge-info float-right">
                        <i class="fas fa-angle-down" aria-hidden="true" aria-label="@ucfirst(__('app.orderByAsc'))"></i>
                    </span>
                </th>
                <th class="text-center">@ucfirst(__('app.addressCount'))</th>
                <th class="text-center">@ucfirst(__('app.actions'))</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">
                    <i class="{{ $category->icon }}" aria-hidden="true"></i>
                </td>
                <td>
                    <a href="{{ route('admin.category.show', ['uuid' => $category->uuid]) }}" class="text-dark text-decoration-none">
                        {{ $category->name }}
                    </a>
                </td>
                <td class="text-center">{{ count($category->hasAddresses) }}</td>
                <td class="text-center">
                    @can('delete')
                    @if ($category->deleted_at)
                    <form action="{{ route('admin.category.restore') }}" method="POST">    
                    @else
                    <form action="{{ route('admin.category.delete') }}" method="POST">
                    @endif
                        @csrf
                        <input type="hidden" name="category_uuid" value ="{{ $category->uuid }}" />
                        @endcan
                        @can('delete')
                        @if ($category->deleted_at)
                        <button class="btn btn-sm btn-warning">
                            <i class="fas fa-history" aria-hidden="true"></i>
                        </button>
                        @else
                        <a href="{{ route('admin.category.show', ['uuid' => $category->uuid]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </a>
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

{{ $categories->links() }}
    
@include('modals.categoryCreate')
@include('modals.categoriesImport')
@include('modals.categoriesExport')
@endsection