<!-- Success Message Handling -->
@if (session('success'))
@include('layouts.alert-messages',['alertMessage'=>session('success')])
@yield('alert_success')
@endif
<!-- Success Message Handling -->
<!-- Error Message Handling -->
@if (session('error'))
@include('layouts.alert-messages',['alertMessage'=>session('error')])
@yield('alert_error')
@endif
<!-- Error Message Handling -->
