@section('alert_success')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="c-alert c-alert--success alert u-mb-medium">
      <span class="c-alert__icon">
        <i class="feather icon-check"></i>
      </span>

      <div class="c-alert__content">
        <h4 class="c-alert__title">Congratulations!</h4>
        <p>{{ $alertMessage }}</p>
      </div>

      <button class="c-close" data-dismiss="alert" type="button">×</button>
    </div>
  </div>
</div>
@endsection
@section('alert_error')
<div class="row">
  <div class="col-md-6 offset-md-3">
    <div class="c-alert c-alert--danger alert u-mb-medium">
      <span class="c-alert__icon">
        <i class="feather icon-slash"></i>
      </span>

      <div class="c-alert__content">
        <h4 class="c-alert__title">Oops! Something went wrong</h4>
        <p>{{ $alertMessage }}</p>
      </div>

      <button class="c-close" data-dismiss="alert" type="button">×</button>
    </div>
  </div>
</div>
@endsection
