@extends('layouts.admin')
@section('title', @ucfirst(__('app.admin')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-home" aria-hidden="true"></i>
        @ucfirst(__('app.admin'))
    </h1>
</div>

<div class="row row-cols-1 row-cols-md-3">
    <div class="col mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-folder-open" aria-hidden="true"></i>
                @ucfirst(__('app.categories'))
            </div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#modalCategoryCreate">
                    <span>@ucfirst(__('app.categoryCreate'))</span>
                </a>
                <a href="{{ route('admin.category.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.categoryCount'))</span>
                    <span>{{ count($categories) }}</span>
                </a>
            </div>
            @if ($categories->last())
            <div class="card-footer text-muted text-right">
                <small><em>@ucfirst(__('app.updatedAt', ['date' => $categories->sortBy('updated_at')->last()->updated_at->format('d/m/Y @ H:i')]))</em></small>
            </div>
            @endif
        </div>
    </div>
    <div class="col mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-address-book" aria-hidden="true"></i>
                @ucfirst(__('app.addresses'))
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.address.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.addressCreate'))</span>
                </a>
                <a href="{{ route('admin.address.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.addressCount'))</span>
                    <span>{{ count($addresses) }}</span>
                </a>
                @foreach ($continents as $continent)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.addressesIn' . $continent->region))</span>
                    @php
                    $countryTotal = 0;
                    foreach ($countries->where('region', $continent->region) as $countryCount)
                    {
                        $countryTotal += count($countryCount->hasAddresses);
                    }
                    @endphp
                    <span>{{ $countryTotal }} </span>
                </div>
                @endforeach
            </div>
            @if ($addresses->last())
            <div class="card-footer text-muted text-right">
                <small><em>@ucfirst(__('app.updatedAt', ['date' => $addresses->sortBy('updated_at')->last()->updated_at->format('d/m/Y @ H:i')]))</em></small>
            </div>
            @endif
        </div>
    </div>
    <div class="col mb-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-globe" aria-hidden="true"></i>
                @ucfirst(__('app.countries'))
            </div>
            <div class="list-group list-group-flush">
                <a href="{{ route('admin.country.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.countryAll'))</span>
                    <span>{{ count($countries) }}</span>
                </a>
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.countryCount'))</span>
                    <span>{{ count($hasAddresses) }}</span>
                </div>
                @foreach ($continents as $continent)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <span>@ucfirst(__('app.countriesIn' . $continent->region))</span>
                    <span>{{ count($hasAddresses->where('region', $continent->region)) }} </span>
                </div>
                @endforeach
            </div>
            <div class="card-footer text-muted text-right">
                <small><em>@ucfirst(__('app.updatedAt', ['date' => $addresses->sortBy('updated_at')->last()->updated_at->format('d/m/Y @ H:i')]))</em></small>
            </div>
        </div>
    </div>
</div>
    
@include('modals.categoryCreate')
@endsection