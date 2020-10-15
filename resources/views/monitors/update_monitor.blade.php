@extends('layouts.app')
@section('css')
@endsection
@section('content')
<h2>Admin Panel</h2>
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif
<hr>
<h3>Update application to monitor</h3>
<!-- SECTION - Form to update monitor -->
<form action="{{ route('update_monitor', ['id' => $monitor->id]) }}" method="post" id="update-panel">
    @csrf
    <div class="form-group">
        <label for="url">URL to monitor</label>
        <input name="url" type="url" class="form-control" id="url" placeholder="https://www..."
            value="{{ $monitor->url }}" required>
        <div class="invalid-feedback">
            Please fill in this field.
        </div>
    </div>
    <div class="form-group">
        <label for="look_for_string">URL path to check (optional)</label>
        <input name="look_for_string" type="text" class="form-control" id="look_for_string"
            placeholder="index.php, home, etc." value="{{ $monitor->look_for_string }}">
    </div>
    <div class="form-group">
        <label for="app_name">Applition name</label>
        <input name="app_name" type="text" class="form-control" id="app_name" placeholder="Blog, EzProxy, Website"
            value="{{ $monitor->app_name }}" required>
        <div class="invalid-feedback">
            Please fill in this field.
        </div>
    </div>
    <div class="form-group">
        <label for="certificate_check_enabled">Check SSL certificate? <span class="text-muted">If a certificate
                will expire within 14 days, you will be notified. This column is not publicly visible.</span></label>
        @if ($monitor->certificate_check_enabled == "1")

        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate_check_enabled"
                id="certificate_check_enabled_no" value="0">
            <label class="form-check-label" for="certificate_check_enabled_no">
                No
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate_check_enabled"
                id="certificate_check_enabled_yes" value="1" checked>
            <label class="form-check-label" for="certificate_check_enabled_yes">
                Yes
            </label>
        </div>
        @else
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate_check_enabled"
                id="certificate_check_enabled_no" value="0" checked>
            <label class="form-check-label" for="certificate_check_enabled_no">
                No
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="certificate_check_enabled"
                id="certificate_check_enabled_yes" value="1">
            <label class="form-check-label" for="certificate_check_enabled_yes">
                Yes
            </label>
        </div>
        @endif
    </div>
    <div class="form-group">
        <label for="app_name">Visibility</label>
        @if ($monitor->visible_to_admin_only == "1")
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visible_to_admin_only" id="visible_to_admin_only_yes"
                value="1" checked>
            <label class="form-check-label" for="visible_to_admin_only_yes">
                Admin Only
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visible_to_admin_only" id="visible_to_admin_only_no"
                value="0">
            <label class="form-check-label" for="visible_to_admin_only_no">
                Public
            </label>
        </div>
        @else
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visible_to_admin_only" id="visible_to_admin_only_yes"
                value="1">
            <label class="form-check-label" for="visible_to_admin_only_yes">
                Admin Only
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visible_to_admin_only" id="visible_to_admin_only_no"
                value="0" checked>
            <label class="form-check-label" for="visible_to_admin_only_no">
                Public
            </label>
        </div>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a class="btn btn-danger" href="{{ route('admin_monitors') }}" role="button">Cancel</a>
</form>
<hr>
@endsection
@section('javascript')
@endsection