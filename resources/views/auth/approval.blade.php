@extends('layouts.app')
@section('title', @ucfirst(__('auth.approval')))

@section('content')
<div class="col-12 col-md-7 pt-5">
    <div class="card">
        <h5 class="card-header">
            @ucfirst(__('auth.approval'))
        </h5>
        <div class="card-body">   
            @ucfirst(__('auth.approvalDesc'))
        </div>
    </div>
</div>
@endsection
