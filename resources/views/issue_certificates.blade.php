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
        <div class="col-6">
          <div class="c-card">
            <div class="row u-justify-center">
              <a href="issue/all" class="c-btn">Issue Certificate for All</a>
              <a href="issue/download" class="c-btn" style="margin-left:4px;">Download CSV</a>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="c-card">
            <form action="search" method="get">
              <div class="row">
                <div class="col-md-12">
                  <div class="c-field has-icon-right">
                    <input class="c-input" type="text" name="s" id="s" placeholder="Search by applicant's IEEE number or Email or Team name">
                    <span class="c-field__icon">
                      <i class="feather icon-search"></i>
                    </span>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="c-table-responsive@wide">
            @if(isset($dataArray['attendees']))
            <table class="c-table c-table-responsive">
              <thead class="c-table__head">
                <tr class="c-table__row">
                  <th class="c-table__cell c-table__cell--head">#</th>
                  <th class="c-table__cell c-table__cell--head">Issue Certificate</th>
                  <th class="c-table__cell c-table__cell--head">Member Type</th>
                  <th class="c-table__cell c-table__cell--head">Member Name</th>
                  <th class="c-table__cell c-table__cell--head">Rank</th>
                  <th class="c-table__cell c-table__cell--head">Email</th>
                  <th class="c-table__cell c-table__cell--head">Team Name</th>
                </tr>
              </thead>
              <tbody>
                @php $resultCounter = 1; @endphp
                @foreach ($dataArray['attendees'] as $singleData)
                <tr class="c-table__row">
                  <td class="c-table__cell">{{ $resultCounter++ }}</td>
                  <td class="c-table__cell">
                    <div class="c-dropdown dropdown">
                      <a href="/issue/{{ $singleData->member_uid }}" class="c-btn c-btn--info" role="button">
                        Issue Certificate
                      </a>
                    </div>
                  </td>
                  <td class="c-table__cell">{{ $singleData->member_type }}</td>
                  <td class="c-table__cell"><a href="/generate-certificate/{{ $singleData->member_uid }}" target="_blank">{{ $singleData->member_fname }} {{ $singleData->member_lname }}</a></td>
                  <td class="c-table__cell">{{ $singleData->rank }}</td>
                  <td class="c-table__cell">{{ $singleData->member_email }}</td>
                  <td class="c-table__cell">{{ $singleData->team_name }}</td>
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
          {{ $dataArray['attendees']->appends(request()->except('page'))->links() }}
        </div>
      </div>
      @include('layouts.footer')
    </div>
  </main>
</div>
@endsection
