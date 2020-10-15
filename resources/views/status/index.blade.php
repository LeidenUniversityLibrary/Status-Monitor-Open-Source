@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.22/r-2.2.6/datatables.min.css" />
@endsection
@section('content')

@if($data['down_detector'] == 'true' )
<div id="currentStatusAlert">
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Service degradation</h4>
        <p>We have noticed and issue on our systems and your experience might not be optimal.</p>
        <p>We are aware of the situation. We are doing our best to restore the services as quickly as possible.
        </p>
        <p class="mb-0">Please visit this page again in a few minutes to check if services have been restored. If you need further
            assistance, please contact us <a
                href="https://www.example.com/" target="_blank"
                rel="noopener">here</a>.</p>
    </div>
</div>
@else
<div id="currentStatusAlert">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">All our applications appear to be available.</h4>
        <p class="mb-0">Still having difficulties? Please contact us <a
                href="https://www.example.com/" target="_blank"
                rel="noopener">here</a>.</p>
    </div>
</div>
@endif

@foreach ($data['alerts'] as $alert)
    @if ($alert->is_publicly_visible == '1')

    <div class="alert alert-warning" role="alert">
        <h4 class="alert-heading">{{$alert->title}}</h4>
        <p>{{$alert->custom_alert}}</p>
    </div>
    @endif
@endforeach


<div class="table-responsive" id="activeMonitors">
    <table id="datatablex" class="table table-hover" style="width:100%; padding-bottom:1em;">
        <thead>
            <tr>
                <th scope="col">Application</th>
                <th scope="col">Status</th>
                <th scope="col">Last checked at</th>
                @auth
                <th scope="col">Visibility</th>
                @endauth
            </tr>
        </thead>
        <tbody>
            @guest
                @foreach ($data['monitors'] as $status)
                    @if ($status->visible_to_admin_only == '0' and $status->uptime_status === 'down')
                        <tr>
                            <td id="monitorNameCol">{{$status->app_name}}</a></td>
                            <td id="monitorStatusCol"><i class="fas fa-2x fa-times-circle text-danger"></i>
                                <p style="display: none">down</p>
                            </td>
                            <td id="monitorLastCheckCol">{{$status->uptime_last_check_date}}</td>
                        </tr>
                    @elseif ($status->visible_to_admin_only == '0' and $status->uptime_status === 'up')
                        <tr>
                            <td id="monitorNameCol"><a href="{{$status->url}}">{{$status->app_name}}</a></td>
                            <td id="monitorStatusCol"><i class="fas fa-2x fa-check-circle text-success"></i>
                                <p style="display: none">up</p>
                            </td>
                            <td id="monitorLastCheckCol">{{$status->uptime_last_check_date}}</td>
                        </tr>
                    @elseif ($status->visible_to_admin_only == '0')
                        <tr>
                            <td id="monitorNameCol"><a href="{{$status->url}}">{{$status->app_name}}</a></td>
                            <td id="monitorStatusCol"><i class="fas fa-2x fa-question-circle text-warning"></i>
                                <p style="display: none">unknown</p>
                            </td>
                            <td id="monitorLastCheckCol">{{$status->uptime_last_check_date}}</td>
                        </tr>
                    @endif
                @endforeach
            @endguest
            @auth
                @foreach ($data['monitors'] as $status)
                    @if ($status->uptime_status === 'down')
                        <tr>
                            <td id="monitorNameCol">{{$status->app_name}}</a></td>
                            <td id="monitorStatusCol"><i class="fas fa-2x fa-times-circle text-danger"></i>
                                <p style="display: none">down</p>
                            </td>
                            <td id="monitorLastCheckCol">{{$status->uptime_last_check_date}}</td>
                            <td id="monitorVisibilityCol">
                                @if ($status->visible_to_admin_only == "0")
                                Publicly visible
                                @else
                                Private
                                @endif
                            </td>
                        </tr>
                    @elseif ($status->uptime_status === 'up')
                        <tr>
                            <td id="monitorNameCol"><a href="{{$status->url}}">{{$status->app_name}}</a></td>
                            <td id="monitorStatusCol"><i class="fas fa-2x fa-check-circle text-success">
                                    <p style="display: none">up</p>
                            </td>
                            <td id="monitorLastCheckCol">{{$status->uptime_last_check_date}}</td>
                            <td id="monitorVisibilityCol">
                                @if ($status->visible_to_admin_only == "0")
                                Publicly visible
                                @else
                                Private
                                @endif
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td id="monitorNameCol"><a href="{{$status->url}}">{{$status->app_name}}</a></td>
                            <td id="monitorStatusCol"><i class="fas fa-2x fa-question-circle text-warning"></i>
                                <p style="display: none">unknown</p>
                            </td>
                            <td id="monitorLastCheckCol">{{$status->uptime_last_check_date}}</td>
                            <td id="monitorVisibilityCol">
                                @if ($status->visible_to_admin_only == "0")
                                Publicly visible
                                @else
                                Private
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            @endauth
        </tbody>
    </table>
</div>
@endsection
@section('javascript')

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.22/r-2.2.6/datatables.min.js"></script>
<script type="text/javascript" src="{{ asset('/js/datatable.js') }}"></script>
@endsection