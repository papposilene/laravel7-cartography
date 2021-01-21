@extends('layouts.admin')
@section('title', @ucfirst(__('app.settings')))

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-cog" aria-hidden="true"></i>
        @ucfirst(__('app.settings'))
    </h1>
</div>


@includeIf(config('app_settings.flash_partial'))
<form method="post" action="{{ url(config('app_settings.url')) }}" class="form-horizontal mb-3" enctype="multipart/form-data" role="form">
    @csrf
    <div class="row row-cols-1 row-cols-md-3">
        @if( isset($settingsUI) && count($settingsUI) )
        @foreach(Arr::get($settingsUI, 'sections', []) as $section => $fields)
        <div class="col mb-4">
            @component('app_settings::section', compact('fields'))
            <div class="{{ Arr::get($fields, 'section_body_class', config('app_settings.section_body_class', 'card-body')) }}">
                @foreach(Arr::get($fields, 'inputs', []) as $field)
                @if(!view()->exists('app_settings::fields.' . $field['type']))
                <div style="background-color: #f7ecb5; box-shadow: inset 2px 2px 7px #e0c492; border-radius: 0.3rem; padding: 1rem; margin-bottom: 1rem">
                    Defined setting <strong>{{ $field['name'] }}</strong> with
                    type <code>{{ $field['type'] }}</code> field is not supported. <br>
                    You can create a <code>fields/{{ $field['type'] }}.balde.php</code> to render this input however you want.
                </div>
                @endif
                @includeIf('app_settings::fields.' . $field['type'] )
                @endforeach
            </div>
            @endcomponent
        </div>
        @endforeach
        @endif
    </div>

    <div class="mb-3 text-right">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save" aria-hidden="true"></i>
            @ucfirst(__('app.save'))
        </button>
    </div>
</form>


@endsection