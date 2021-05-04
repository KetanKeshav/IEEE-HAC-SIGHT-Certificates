@extends('layouts.template')
@section('title', 'Claim Certificate')
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
          <h4 class="c-alert__title">Oops! Not found!</h4>
          <p>{!! session('error') !!}</p>
        </div>
        <button class="c-close" data-dismiss="alert" type="button">×</button>
      </div>
    </div>
  </div>
  @endif

  @if(!session('success') && !session('error'))
  <div class="o-page__card">
    <div class="c-card c-card--center">
      <span class="c-icon c-icon--large u-mb-small">
        <img src="/Xtreme13_color.png" alt="IEEE Xtreme">
      </span>

      <h4 class="u-mb-medium">Claim certificate</h4>
      <form action="/claim" method="post" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="c-field">
          <label class="c-field__label">Member # or Email Address</label>
          <input class="c-input u-mb-small" name="searchKey" placeholder="e.g. Enter your IEEE member number or Registered Email Address" required>
        </div>

        <!-- <div class="c-field">
          <label class="c-field__label">Email</label>
          <input class="c-input u-mb-small" name="memberEmail" placeholder="e.g. Enter your registered email address">
        </div> -->

        <div class="c-field">
          <label class="c-field__label">Attendee Type</label>
          <select class="c-select__input u-mb-small" name="memberType">
            <option value="member">Participant</option>
            <option value="ambassador">Ambassador</option>
            <option value="judge">Judge</option>
            <option value="proctor">Proctor</option>
            <option value="execom">Execom</option>
          </select>
        </div>

        <input class="c-btn c-btn--fullwidth c-btn--info" type="submit" value="Claim Xtreme Certificate"/>
      </form>
    </div>
  </div>
  @endif
</div>
@endsection
