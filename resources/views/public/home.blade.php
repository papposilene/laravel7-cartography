@extends('layouts.app')
@section('title', @ucfirst(__('app.countriesList')))

@section('content')
<div class="d-flex flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3">
    <div class="mb-3 w-100">
        <a href="{{ route('public.map.index') }}" class="btn btn-lg btn-primary btn-block">
            @ucfirst(__('app.mapAllData'))
        </a>
    </div>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap pb-2 mb-3">
    <div class="col-12 col-md-8 mb-3 table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <th colspan="2" scope="col">
                    <button class="btn btn-secondary btn-block" disabled>@ucfirst(__('app.countriesList'))</button>
                </th>
            </tr>
            @foreach($countries->chunk(2) as $chunk)
            <tr>
                @foreach($chunk as $homeCountry)
                <td class="w-50">
                    <a href="{{ route('public.country.show', ['cca3' => strtolower($homeCountry->cca3)]) }}" class="btn btn-light btn-block d-flex justify-content-between align-items-center">
                        <span>{{ $homeCountry->flag }} {{ $homeCountry->name_eng_common }}</span>
                        <span>{{ count($homeCountry->hasAddresses) }}</span>
                    </a>
                </td>
                @endforeach
            </tr>
            @endforeach
        </table>
    </div>
    <div class="col-12 col-md-4 mb-3 table-responsive">
        <table class="table table-sm table-borderless">
            <tr>
                <th scope="col">
                    <button class="btn btn-secondary btn-block" disabled>@ucfirst(__('app.categoriesList'))</button>
                </th>
            </tr>
            @foreach($categories as $homeCategory)
            <tr>
                <td>
                    <a href="{{ route('public.category.show', ['slug' => $homeCategory->slug]) }}" class="btn btn-light btn-block d-flex justify-content-between align-items-center">
                        <span><i class="fas fa-{{ $homeCategory->icon }}"></i> {{ $homeCategory->name }}</span>
                        <span>{{ count($homeCategory->hasAddresses) }}</span>
                    </a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection