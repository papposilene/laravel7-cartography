@extends('layouts.admin')
@section('title', @ucfirst(__('app.countriesList')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-globe" aria-hidden="true"></i>
        @ucfirst(__('app.countriesList'))
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <form action="{{ route('admin.country.search') }}" method="POST">
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
    
{{ $countries->links() }}

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">@ucfirst(__('app.countryFlag'))</th>
                <th class="text-center">
                    @ucfirst(__('app.countryCommon'))
                    <span class="badge badge-pill badge-info float-right">
                        <i class="fas fa-angle-down" aria-hidden="true" aria-label="@ucfirst(__('app.orderByAsc'))"></i>
                    </span>
                </th>
                <th class="text-center">@ucfirst(__('app.addressCount'))</th>
                <th class="text-center">@ucfirst(__('app.actions'))</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
            <tr @if (count($country->hasAddresses) > 0)class="table-info"@endif>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.country.show', ['cca3' => strtolower($country->cca3)]) }}" class="text-dark text-decoration-none" title="{{ $country->name_eng_common }}">
                        {{ $country->flag }}
                    </a>
                </td>
                <td>
                    <a href="{{ route('admin.country.show', ['cca3' => strtolower($country->cca3)]) }}" class="text-dark text-decoration-none" title="{{ $country->name_eng_common }}">
                        {{ $country->name_eng_common }}
                    </a>
                </td>
                <td class="text-center">
                    {{ count($country->hasAddresses) }}
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.country.show', ['cca3' => strtolower($country->cca3)]) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $countries->links() }}

@include('modals.addressesImport')
@endsection