@extends('layouts.template')
@section('title', 'Dashboard')
@section('body_content')
<div class="o-page">
  @include('layouts.sidebar')
  <main class="o-page__content">
    @include('layouts.header')
    <div class="container">
      <div class="row">
        <div class="col-12">
          @include('layouts.alerts')
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="c-table-responsive@wide">
            @if(isset($dataArray['changes']))
            <table class="c-table c-table-responsive">
              <thead class="c-table__head">
                <tr class="c-table__row">
                  <th class="c-table__cell c-table__cell--head">#</th>
                  <th class="c-table__cell c-table__cell--head">Member Type</th>
                  <th class="c-table__cell c-table__cell--head">First Name</th>
                  <th class="c-table__cell c-table__cell--head">Last Name</th>
                  <th class="c-table__cell c-table__cell--head">Team Name</th>
                  <th class="c-table__cell c-table__cell--head">Actions</th>
                </tr>
              </thead>
              <tbody>
                @php $resultCounter = 1; @endphp
                @foreach ($dataArray['changes'] as $singleData)
                <tr class="c-table__row">
                  <td class="c-table__cell">{{ $resultCounter++ }}</td>
                  @php
                    $singleChanges = unserialize($singleData->changes)
                  @endphp
                  <td class="c-table__cell">{{ ucfirst($singleData->member_type) }}</td>
                  <td class="c-table__cell">
                    <a class="c-badge c-badge--small c-badge--danger" href="#">
                      {{ $singleData->team['member_fname'] }}
                    </a> /
                    <a class="c-badge c-badge--small c-badge--success" href="#">
                      {{ $singleChanges['member_fname'] }}
                    </a>
                  </td>
                  <td class="c-table__cell">
                    <a class="c-badge c-badge--small c-badge--danger" href="#">
                      {{ $singleData->team['member_lname'] }}
                    </a> /
                    <a class="c-badge c-badge--small c-badge--success" href="#">
                      {{ $singleChanges['member_lname'] }}
                    </a>
                  </td>
                  <td class="c-table__cell">
                    <a class="c-badge c-badge--small c-badge--danger" href="#">
                      {{ $singleData->team['team_name'] }}
                    </a> /
                    <a class="c-badge c-badge--small c-badge--success" href="#">
                      {{ $singleChanges['team_name'] }}
                    </a>
                  </td>
                  <td class="c-table__cell">
                    <a class="c-btn c-btn--small c-btn--success" href="requested-changes/approve/{{ $singleData->id }}">Approve</a>
                    <a class="c-btn c-btn--small c-btn--danger" href="requested-changes/reject/{{ $singleData->id }}">Reject</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <div class="row u-justify-center">
              <div class="col-md-6">
                <div class="c-alert c-alert--danger">
                  <span class="c-alert__icon">
                    <i class="feather icon-slash"></i>
                  </span>

                  <div class="c-alert__content">
                    <h4 class="c-alert__title">Oops! nothing is here.</h4>
                    <p>No information available at the moment. Please come later.</p>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
          <p>&nbsp;</p>
          {{ $dataArray['changes']->appends(request()->except('page'))->links() }}
        </div>
      </div>
      @include('layouts.footer')
    </div>
  </main>
</div>
@endsection
