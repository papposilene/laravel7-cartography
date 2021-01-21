@extends('layouts.admin')
@section('title', @ucfirst(__('app.addressCreate')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-address-book" aria-hidden="true"></i>
        @ucfirst(__('app.addressCreate'))
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
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
            
<div class="row">
    <div class="col-12">
        <form action="{{ route('admin.address.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="place_id" id="place_id" value="" />
            <div class="">
                <p class="text-justify">
                    @ucfirst(__('app.newAddInstruction'))
                </p>
            </div>
            <div class="input-group border-secondary mb-3">
                <div id="map-new" class="leaflet-map-new rounded"></div>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary border-primary text-white" id="formName">
                        <i class="fas fa-landmark" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control border-primary" name="address_name" id="name" autocomplete="off" required="required" placeholder="@ucfirst(__('app.formName'))" aria-label="@ucfirst(__('app.formName'))" aria-describedby="formName" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-secondary border-secondary text-white" id="formOwner">
                        <i class="fas fa-address-card" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control border-secondary" name="address_owner" id="owner" autocomplete="off" placeholder="@ucfirst(__('app.formOwner'))" aria-label="@ucfirst(__('app.formOwner'))" aria-describedby="formOwner" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary border-primary text-white">
                        <i class="fas fa-map-marked-alt" aria-hidden="true"></i>
                    </span>
                </div>
                <textarea class="form-control border-primary" name="address_address" id="address" autocomplete="off" required="required" rows="4" placeholder="@ucfirst(__('app.formAddress'))" aria-label="@ucfirst(__('app.formAddress'))"></textarea>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primary border-primary text-white" for="formGeoloc">
                        <i class="fas fa-globe" aria-hidden="true"></i>
                    </label>
                </div>
                <input type="text" class="form-control border-primary" name="address_latlng" id="geoloc" autocomplete="off" required="required" placeholder="@ucfirst(__('app.formGeoloc'))" aria-label="@ucfirst(__('app.formGeoloc'))" aria-describedby="formGeoloc" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primary border-primary text-white" for="formCountry">
                        <i class="fas fa-map" aria-hidden="true"></i>
                    </label>
                </div>
                <input type="text" class="form-control border-primary" id="countries" autocomplete="off" required="required" placeholder="@ucfirst(__('app.formCountry'))" aria-label="@ucfirst(__('app.formCountry'))" aria-describedby="formCountry" />
                <input type="hidden" name="country_uuid" id="country_uuid" value="" required="required" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primary border-primary text-white" for="formCategory">
                        <i class="fas fa-folder-open" aria-hidden="true"></i>
                    </label>
                </div>
                <input type="text" class="form-control border-primary" id="categories" autocomplete="off" required="required" placeholder="@ucfirst(__('app.formCategory'))" aria-label="@ucfirst(__('app.formCategory'))" aria-describedby="formCategory" />
                <input type="hidden" name="category_uuid" id="category_uuid" value="" required="required" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-primary border-primary text-white" for="formStatus">
                        <i class="fas fa-store-alt" aria-hidden="true"></i>
                    </label>
                </div>
                <select class="form-control border-primary" name="address_status" id="formStatus">
                    <option value="1" selected="selected">@ucfirst(__('app.addressOpen'))</option>
                    <option value="0">@ucfirst(__('app.addressClosed'))</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-secondary border-secondary text-white" id="formPhone">
                        <i class="fas fa-phone" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control border-secondary" name="address_phone" autocomplete="off" placeholder="@ucfirst(__('app.formPhone'))" aria-label="@ucfirst(__('app.formPhone'))" aria-describedby="formPhone" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-secondary border-secondary text-white" id="formUrl">
                        <i class="fas fa-link" aria-hidden="true"></i>
                    </span>
                </div>
                <input type="text" class="form-control border-secondary" name="address_url" autocomplete="off" placeholder="@ucfirst(__('app.formUrl'))" aria-label="@ucfirst(__('app.formUrl'))" aria-describedby="formUrl" />
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-secondary border-secondary text-white">
                        <i class="fas fa-comment-alt" aria-hidden="true"></i>
                    </span>
                </div>
                <textarea class="form-control border-secondary" name="address_description" autocomplete="off" rows="7" placeholder="@ucfirst(__('app.formDescription'))" aria-label="@ucfirst(__('app.formDescription'))"></textarea>
            </div>
            <div class="mb-3 text-right">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save" aria-hidden="true"></i>
                    @ucfirst(__('app.save'))
                </button>
            </div>
		</form>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
$( function() {
    $("#categories").autocomplete({
        source: function (request, response) {
            $.getJSON("{!! route('api.categories.autocomplete', ['q']) !!}=" + request.term, function (data) {
                if(!data.length){
                    var result = [{
                        label: '@ucfirst(__('app.searchNotFound'))',
                        value: response.term
                    }];
                    response(result);
                }
                else
                {
                    response($.map(data, function (value, key) {
                        return {
                            label: value.name,
                            value: value.name,
                            uuid: value.uuid
                        };
                    }));
                }
            });
        },
		minLength: 3,
		select: function( event, ui ) {
            $("#category_uuid").val(ui.item.uuid);
		}
	});
    $("#countries").autocomplete({
        source: function (request, response) {
            $.getJSON("{!! route('api.countries.autocomplete', ['q']) !!}=" + request.term, function (data) {
                if(!data.length){
                    var result = [{
                        label: '@ucfirst(__('app.searchNotFound'))',
                        value: response.term
                    }];
                    response(result);
                }
                else
                {
                    response($.map(data, function (value, key) {
                        return {
                            uuid: value.uuid,
                            cca3: value.cca3,
                            label: value.name_eng_common,
                            value: value.name_eng_common
                        };
                    }));
                }
            });
        },
		minLength: 3,
		select: function( event, ui ) {
            $("#country_uuid").val(ui.item.uuid);
		}
	});
});

var map = L.map('map-new').setView([20, 0], 1);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
var geocoder = L.Control.geocoder({
        collapsed: false,
        errorMessage: '@ucfirst(__('app.nothing'))',
        placeholder: '@ucfirst(__('app.search'))',
        showResultIcons: true
    })
    .on('markgeocode', function(e) {
        console.log(e.geocode.properties);
        var osm_number = e.geocode.properties.address.house_number;
        var osm_street = e.geocode.properties.address.road;
        var osm_code = e.geocode.properties.address.postcode;
        var osm_city = e.geocode.properties.address.city;
        $("#name").val(e.geocode.properties.display_name);
        $("#address").val(osm_number + ', ' + osm_street +'\n' + osm_code + ' ' + osm_city);
        $("#place_id").val(e.geocode.properties.place_id);
        $("#geoloc").val(e.geocode.properties.lat + ', ' + e.geocode.properties.lon);
    }).addTo(map);
</script>
@endsection