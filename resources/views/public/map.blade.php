@extends('layouts.app')
@if (isset($category))
@section('title', $category->name)
@elseif (isset($country))
@section('title', $country->name_eng_common)
@else
@section('title', setting('app_name', config('app.name', 'Laravel Cartography')))
@endif



@section('content')
<div id="map-container"></div>
<div id="map-sidebar"></div>
@isset ($category)
<div class="modal fade" id="modalAddressesList" data-keyboard="false" tabindex="-1" aria-labelledby="modalAddressesListTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="modalAddressesListTitle">
                    {{ count($category->hasAddresses) }} @lcfirst($category->name)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <ul class="modal-body list-group list-group-flush p-0">
                @foreach ($category->hasAddresses as $address)
                <li class="list-group-item d-flex justify-content-between align-items-top">
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
                    <span>{{ $address->locatedAt->flag }}</span>
                </li>
                @endforeach
            </ul>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    @ucfirst(__('app.close'))
                </button>
            </div>
        </div>
    </div>
</div>
@endisset
@endsection

@section('js')
<script type="text/javascript">
var clusters = new L.MarkerClusterGroup();
var markers = L.featureGroup();
@if (isset($country))
var map = L.map('map-container').setView([{{ $lng }}, {{ $lat }}], 5);
@else
var map = L.map('map-container').setView([0, -10], 2);
@endif

map.spin(true, {
    animation: 'spinner-line-fade-quick',
    lines: 10,
    length: 40,
    radius: 30,
    speed: 2,
    width: 10
});

var sidebar = L.control.sidebar('map-sidebar', {
    position: 'left',
    closeButton: true,
    autoPan: true
});

var baseMaps = {
    '<i class="fas fa-map-marker" aria-hidden="true"></i> @ucfirst(__('app.mapClusters'))': clusters,
    '<i class="fas fa-map-pin" aria-hidden="true"></i> @ucfirst(__('app.mapPins'))': markers
};

var countries = $.ajax({
    @if (isset($country))
    url: "{{ route('api.addresses.geojson', ['country' => $country->uuid]) }}",
    @elseif (isset($category))
    url: "{{ route('api.addresses.geojson', ['category' => $category->uuid]) }}",
    @else
    url: "{{ route('api.addresses.geojson') }}",
    @endif
    dataType: "json",
    success: console.log("Addresses successfully loaded."),
    error: function(xhr) {
        alert(xhr.statusText)
    }
});

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
    subdomains: 'abc',
    minZoom: 0,
    maxZoom: 19,
    crossOrigin: true,
    layers: [clusters]
}).addTo(map);

$.when(countries).done(function() {
    // Add requested external GeoJSON to map
    var kyCountries = L.geoJSON(countries.responseJSON, {
        onEachFeature: function(feature, layer) {
            if (feature.properties) {
                layer.on('click',function(){
                    sidebar.show(),
                    sidebar.setContent(
                        '<h2 class="h3 mt-3">' + feature.properties.address_name + '</h2>' +
                        '<ul class="text-center list-inline"><li class="list-inline-item">' + feature.properties.country_flag + ' ' + feature.properties.country_common + '</li>' +
                        '<li class="list-inline-item"><i class="fas fa-' + feature.properties.category_icon + '"></i> ' + feature.properties.category_name + '</li></ul>' + 
                        '<p class="text-justify">' + feature.properties.address_address + '.</p>' +
                        (feature.properties.address_desc ? '<p class="text-justify">' + feature.properties.address_desc + '</p>' : '') +
                        (feature.properties.address_url ? '<p class="text-justify"><a href="' + feature.properties.address_url + '" target="_blank" rel="noopener"><i class="fas fa-link"></i> @ucfirst(__('app.addressUrl'))</a><br />' : '') +
                        (feature.properties.address_phone ? '<a href="tel: ' + feature.properties.address_phone + '"><i class="fas fa-phone"></i> ' + feature.properties.address_phone + '</a><br />' : '') +
                        '<a href="https://www.google.com/maps/search/?api=1&query=' + feature.properties.address_latlng + '" target="_blank" rel="noopener"><i class="fas fa-map-marked-alt"></i> ' + feature.properties.address_latlng + '</a></p>'
                    )
                })
            }
        },
        pointToLayer: function(feature, latlng) {
            return marker = L.marker(latlng, {
                    icon: L.icon.fontAwesome({
                        iconClasses: feature.properties.category_icon,
                        iconXOffset: -2,
                        iconYOffset: 0,
                        // marker/background style
                        markerColor: feature.properties.category_color,
                        markerStrokeWidth: 1,
                        markerStrokeColor: "#000",
                        // icon style
                        iconColor: "#FFF"
                    })
                });
        }
    }).addTo(clusters).addTo(markers);
    clusters.addTo(map);
    map.spin(false);
});
L.control.layers(baseMaps).addTo(map);
@if(setting('map_locate', true))
L.control.locate({
    flyTo: true,
    icon: 'fas fa-map-marker',
    iconLoading: 'fas fa-spinner fa-spin',
    strings: {
        title: '@ucfirst(__('app.mapGeolocate'))'
    }
}).addTo(map);
@endif
@if(setting('map_fullscreen', true))
L.control.fullscreen({
    position: 'topleft',
    title: '@ucfirst(__('app.mapFullscreenOn'))',
    titleCancel: '@ucfirst(__('app.mapFullscreenOff'))',
    forceSeparateButton: true,
    fullscreenElement: false
}).addTo(map);
@endif
@if(setting('map_export', true))
L.easyPrint({
	title: '@ucfirst(__('app.mapExport'))',
    exportOnly: true,
    filename: 'map_export',
	position: 'topleft',
	sizeModes: ['Current', 'A4Portrait', 'A4Landscape']
}).addTo(map);
@endif
map.addControl(sidebar);
</script>
@endsection