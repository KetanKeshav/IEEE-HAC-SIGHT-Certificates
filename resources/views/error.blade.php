@extends('layouts.template')
@section('title', 'Error')
@section('body_content')
<div class="o-page o-page--center">
  @if(session('success'))
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="c-alert c-alert--success alert u-mb-medium">
        <span class="c-alert__icon">
          <i class="feather icon-check"></i>
        </span>

        <div class="c-alert__content">
          <h4 class="c-alert__title">Congratulations!</h4>
          <p>{{ session('success') }}</p>
        </div>

        <button class="c-close" data-dismiss="alert" type="button">×</button>
      </div>
    </div>
  </div>
  @else (session('error'))
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="c-alert c-alert--danger alert u-mb-medium">
        <span class="c-alert__icon">
          <i class="feather icon-slash"></i>
        </span>

        <div class="c-alert__content">
          <h4 class="c-alert__title">Oops! Something went wrong</h4>
          <p>We are unable to process your request at the moment. Please try again later.</p>
        </div>
        <button class="c-close" data-dismiss="alert" type="button">×</button>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection
