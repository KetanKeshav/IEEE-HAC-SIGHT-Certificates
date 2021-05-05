@extends('layouts.template')
@section('title', 'Sign In')
@section('body_content')
<div class="o-page o-page--center">
  <div class="row">
    <div class="col-12">
      @include('layouts.alerts')
    </div>
  </div>
  <div class="o-page__card">
    <div class="c-card c-card--center">
      <span class="c-icon c-icon--large u-mb-small">
        <img src="/HAC_SIGHT_LOGO.png" alt="IEEE Xtreme">
      </span>

      <h4 class="u-mb-medium">Welcome Back :)</h4>
      <form action="login" method="post" enctype="application/x-www-form-urlencoded">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="c-field">
          <label class="c-field__label">Email Address</label>
          <input class="c-input u-mb-small" type="text" name="email" placeholder="e.g. adam@sandler.com" required>
        </div>

        <div class="c-field">
          <label class="c-field__label">Password</label>
          <input class="c-input u-mb-small" type="password" name="password" placeholder="Enter your password" required>
        </div>

        <button class="c-btn c-btn--fullwidth c-btn--info">Login</button>
      </form>
    </div>
  </div>
</div>
@endsection
