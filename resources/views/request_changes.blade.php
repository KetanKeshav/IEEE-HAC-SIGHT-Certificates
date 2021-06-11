@extends('layouts.template')
@section('title', 'Request Changes')
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
  @elseif (session('error'))
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
  @elseif(!isset($dataArray))
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

  @if(!session('success') && isset($dataArray))
  <div class="o-page__card">
    <div class="c-card c-card--center">
      @if(isset($dataArray) && $dataArray['attendee'] == "pendingRequest")
      <h5>Your request is pending for approval from Team.</h5>
      @elseif(isset($dataArray) && $dataArray['attendee'] == "notFound")
      <h5>We are unable to identify your profile.</h5>
      @elseif(isset($dataArray))
      <span class="c-icon c-icon--large u-mb-small">
        <img src="/HAC_SIGHT_LOGO.png" alt="IEEE Xtreme">
      </span>

      <h4 class="u-mb-medium">Request for changes</h4>
      <form action="/request-changes" method="post" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" class="c-input u-mb-small" name="cert_id" value="{{ $dataArray['attendee']['cert_id'] }}" required>
        <input type="hidden" class="c-input u-mb-small" name="request_member_uid" value="{{ $dataArray['attendee']['request_member_uid'] }}" required>
        <input type="hidden" class="c-input u-mb-small" name="Certificate_Type" value="{{ $dataArray['attendee']['Certificate_Type'] }}" required>

        <div class="c-field">
          <label class="c-field__label">First Name</label>
          <input class="c-input u-mb-small" name="fname" placeholder="e.g. Enter your first name" value="{{ $dataArray['attendee']['fname'] }}" required>
        </div>

        <div class="c-field">
          <label class="c-field__label">Last Name</label>
          <input class="c-input u-mb-small" name="lname" placeholder="e.g. Enter your last name" value="{{ $dataArray['attendee']['lname'] }}" required>
        </div>

        <div class="c-field">
          @if (!in_array($dataArray['attendee']['Certificate_Type'],['ambassador','execom','proctor'] ))
            <label class="c-field__label">Certificate Type</label>
            <input class="c-input u-mb-small" name="Certificate_Type" placeholder="Enter your Certificate Type" value="{{ $dataArray['attendee']['Certificate_Type'] }}" required>    
          @else
            <input class="c-input u-mb-small" name="Certificate_Type" placeholder="Enter your Certificate Type" value="{{ $dataArray['attendee']['Certificate_Type'] }}" required style="display: none">    
          @endif
        </div>

        <input class="c-btn c-btn--fullwidth c-btn--info" type="submit" value="Request Changes"/>
      </form>
      @endif
    </div>
  </div>
  @endif
</div>
@endsection
