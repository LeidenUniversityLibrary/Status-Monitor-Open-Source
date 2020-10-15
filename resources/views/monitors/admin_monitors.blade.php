@extends('layouts.app')
@section('css')
@endsection
@section('content')

<h2>Admin Panel</h2>
<hr>
@if (session('status'))

<div class="alert alert-success" id="session-status">
    {{ session('status') }}
</div>
@elseif ($errors->any())
<div class="alert alert-danger" id='session-error'>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
<hr>
@endif
<h3>Add new application to monitor</h3>

<!-- SECTION - Form to create new monitor -->
<form action="{{route('admin_monitors')}}" method="post" id="admin-panel">
    @csrf
    <div class="form-group">
        <label for="url">URL to monitor</label>
        <input name="url" type="url" class="form-control" id="url" placeholder="https://www..."
            value="{{ old('url') ? old('url') : "" }}" required>
        <div class="invalid-feedback">
            Please fill in this field.
        </div>
    </div>
    <div class="form-group">
        <label for="look_for_string">URL path to check (optional)</label>
        <p class="text-muted"> For example: https://example.com/<u>path</u> - if you want to check for "path", type
            "path" in this field</p>
        <input name="look_for_string" type="text" class="form-control" id="look_for_string"
            placeholder="index.php, home, etc." value="{{ old('look_for_string') ? old('look_for_string') : "" }}">
    </div>
    <div class="form-group">
        <label for="app_name">Applition name</label>
        <input name="app_name" type="text" class="form-control" id="app_name" placeholder="Blog, EzProxy, Website"
            value="{{ old('app_name') ? old('app_name') : "" }}" required>
        <div class="invalid-feedback">
            Please fill in this field.
        </div>
    </div>
    <div class="form-group">
        <label for="certificate_check_enabled">Check SSL certificate?</label>
        <p class="text-muted">If a certificate will expire within 14 days, you will be notified. This column is not
            publicly visible</p>
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
        <div class="invalid-feedback">
            Please fill in this field.
        </div>
    </div>
    <div class="form-group">
        <label for="app_name">Visibility</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visible_to_admin_only" id="visible_to_admin_only_no"
                value="0" checked>
            <label class="form-check-label" for="visible_to_admin_only_no">
                Public
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="visible_to_admin_only" id="visible_to_admin_only_yes"
                value="1">
            <label class="form-check-label" for="visible_to_admin_only_yes">
                Admin Only
            </label>
        </div>
        <div class="invalid-feedback">
            Please fill in this field.
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

<hr>
<h3>Currently monitored applications</h3>
<div class="table-responsive" id="monitored-apps">
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">Application</th>
                <th scope="col">URL</th>
                <th scope="col">Status</th>
                <th scope="col">Last checked at</th>
                <th scope="col">SSL check</th>
                <th scope="col">SSL expiration date</th>
                <th scope="col">Admin only</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['monitors'] as $status)
            <tr>
                <td>{{$status->app_name}}</td>
                <td><a href="{{$status->url}}">{{$status->url}}</a></td>
                <td>{{$status->uptime_status}}</td>
                <td>{{$status->uptime_last_check_date}}</td>
                <td>@if ($status->certificate_check_enabled == "1")
                    Yes
                    @else
                    No
                    @endif
                </td>
                <td>{{$status->certificate_expiration_date}}</td>
                <td>
                    @if ($status->visible_to_admin_only == "0")
                    Publicly visible
                    @else
                    Private
                    @endif
                </td>
                <td>
                    <a class="btn btn-warning" href="{{ route('edit_monitor', ['id' => $status->id]) }}">Edit</a>
                </td>
                <td>
                    <form action="{{ route('delete_monitor',$status->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this monitor?')"
                            class="btn btn-danger" @if($status->app_name == 'example')
                            dusk='testapp'
                            @endif
                            >Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<hr>
<form action="{{ route('check_status_manually') }}" method="get">
    @csrf
    <button type="submit" class="btn btn-primary" id="manualMonitorCheckBtn">Update monitors status</button>
</form>
<form action="{{ route('check_SSL_certificates') }}" method="get">
    @csrf
    <button type="submit" class="btn btn-primary mt-3" id="manualSSLCheckBtn">Check SSL certificates</button>
</form>
@endsection
@section('javascript')
@endsection