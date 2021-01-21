<div class="d-flex justify-content-end flex-wrap flex-md-nowrap align-items-center pt-2 mb-2 mt-3">
    <ul class="list-inline float-right text-muted">
        <!-- li class="list-inline-item">
            <a href="{{ route('public.about') }}" class="text-muted">
                @ucfirst(__('app.footerAbout', ['name' => config('app.name', 'Laravel')]))
            </a>
        </li -->
        <li class="list-inline-item">
            &copy; 2020 - {{ setting('app_name', config('app.name', 'Laravel Cartography')) }}.
        </li>
    </ul>
</div>