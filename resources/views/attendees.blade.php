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
          <div class="c-table-responsive@wide">
            @if(isset($dataArray['attendees']))
            <table class="c-table c-table-responsive">
              <thead class="c-table__head">
                <tr class="c-table__row">
                  <th class="c-table__cell c-table__cell--head">#</th>
                  <th class="c-table__cell c-table__cell--head">Project Name</th>
                  <th class="c-table__cell c-table__cell--head">Member Name</th>
                  <th class="c-table__cell c-table__cell--head">Email</th>
                  <th class="c-table__cell c-table__cell--head">Certificate Type</th>
                </tr>
              </thead>
              <tbody>
                @php $resultCounter = 1; @endphp
                @foreach ($dataArray['attendees'] as $singleData)
                <tr class="c-table__row">
                  <td class="c-table__cell">{{ $resultCounter++ }}</td>
                  <td class="c-table__cell">{{ $singleData->Project_Name }}</td>
                  <td class="c-table__cell">{{ $singleData->Name }} </td>
                  <td class="c-table__cell">{{ $singleData->Email }}</td>
                  <td class="c-table__cell">{{ $singleData->Certificate_Type }}</td>
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
