@extends('layouts.template')
@section('title', 'Dashboard')
@section('body_content')
<div class="o-page">
  @include('layouts.sidebar')
  <main class="o-page__content">
    @include('layouts.header')
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-xl-3">
          <div class="c-card">
            <span class="c-icon c-icon--info u-mb-small">
              <i class="feather icon-users"></i>
            </span>

            <h3 class="c-text--subtitle">Attendees</h3>
            <h1>{{ $dataArray['attendees'] }}</h1>
          </div>
        </div>

        <div class="col-md-6 col-xl-3">
          <div class="c-card">
            <span class="c-icon c-icon--danger u-mb-small">
              <i class="feather icon-codepen"></i>
            </span>

            <h3 class="c-text--subtitle">Teams</h3>
            <h1>{{ $dataArray['teams'] }}</h1>
          </div>
        </div>

        <div class="col-md-6 col-xl-3">
          <div class="c-card">
            <span class="c-icon c-icon--success u-mb-small">
              <i class="feather icon-award"></i>
            </span>

            <h3 class="c-text--subtitle">Issued Certificates</h3>
            <h1>{{ $dataArray['issued_certificates_email'] }} / {{ $dataArray['issued_certificates'] }}</h1>
          </div>
        </div>

        <div class="col-md-6 col-xl-3">
          <div class="c-card">
            <span class="c-icon c-icon--warning u-mb-small">
              <i class="feather icon-edit"></i>
            </span>

            <h3 class="c-text--subtitle">Changes Requested</h3>
            <h1>{{ $dataArray['changes_requested'] }}</h1>
          </div>
        </div>
      </div>
      @include('layouts.footer')
    </div>
  </main>
</div>
@endsection
