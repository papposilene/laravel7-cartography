@extends('layouts.admin')
@section('title', $address->name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <a href="{{ route('admin.address.index') }}" class="text-dark text-decoration-none">
            <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
        </a>
        {{ $address->name }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @can('update')
        <div class="btn-group mr-2">
            <a href="{{ route('admin.address.edit', ['uuid' => $address->uuid]) }}" role="button" class="btn btn-sm btn-primary">
                <i class="fas fa-edit" aria-hidden="true" title="@ucfirst(__('app.addressEdit'))"></i>
                <span class="sr-only">@ucfirst(__('app.addressEdit'))</span>
            </a>
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

<div class="row row-cols-1 mt-2">
    <div class="col mb-4">
        <div class="card">
            <div class="list-group list-group-flush">
                <div id="map" class="leaflet-map list-group-item rounded"></div>
                <a href="{{ route('admin.category.show', ['uuid' => $address->category_uuid]) }}" class="list-group-item list-group-item-action">
                    <i class="{{ $address->inCategory->icon }}" aria-hidden="true"></i>
                    {{ $address->inCategory->name }}
                </a>
                @if ($address->owner)
                <div class="list-group-item">
                    <i class="fas fa-user" aria-hidden="true"></i>
                    {{ $address->owner }}
                </div>
                @endif
                <div class="list-group-item">
                    @nl2br($address->address)
                </div>
                <a href="{{ route('admin.country.show', ['cca3' => strtolower($address->locatedAt->cca3)]) }}" class="list-group-item list-group-item-action">
                    {{ $address->locatedAt->flag }}
                    {{ $address->locatedAt->name_eng_common }}
                </a>
                <div class="list-group-item">
                    @if ($address->status)
                        <i class="fas fa-store-alt text-success" aria-hidden="true"></i>
                        @ucfirst(__('app.addressOpen'))
                    @else
                        <i class="fas fa-store-alt-slash text-danger" aria-hidden="true"></i>
                        @ucfirst(__('app.addressClosed'))
                    @endif
                </div>
                @if ($address->description)
                <div class="list-group-item">
                    @nl2br($address->description)
                </div>
                @endif
                <div class="list-group-item">
                    <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                    {{ $address->latlng }}
                </div>
                @if ($address->phone)
                <div class="list-group-item">
                    <i class="fas fa-phone" aria-hidden="true"></i>
                    {{ $address->phone }}
                </div>
                @endif
                @if ($address->url)
                <a href="{{ $address->url }}" class="list-group-item list-group-item-action" target="_blank" rel="noopener">
                    <i class="fas fa-link" aria-hidden="true"></i>
                    {{ $address->url }}
                </a>
                @endif
            </div>
            <div class="card-footer text-muted text-right">
                <small><em>@ucfirst(__('app.updatedAt', ['date' => $address->updated_at->format('d/m/Y @ H:i')]))</em></small>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
var map = L.map('map').setView([{{ $address->latlng }}], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
L.marker([{{ $address->latlng }}], {
    icon: L.icon.fontAwesome({
        iconClasses: '{{ $address->inCategory->icon }}',
        iconXOffset: -2,
        iconYOffset: 0,
        // marker/background style
        markerColor: '{{ $address->inCategory->color }}',
        markerStrokeWidth: 1,
        markerStrokeColor: "#000",
        // icon style
        iconColor: "#FFF"
    })
}).addTo(map);
</script>
@endsection