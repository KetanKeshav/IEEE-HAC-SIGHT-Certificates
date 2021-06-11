@extends('layouts.template')
@section('title', 'Dashboard')
@section('body_content')
<div class="o-page">
  @include('layouts.sidebar')
  <main class="o-page__content">
    @include('layouts.header')
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-xl-6">
          <div class="c-card" data-mh="attendee-import">
            <form action="import-attendees" method="post" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="row">
                <div class="col-md-8">
                  <div class="c-field u-mb-medium">
                    <input class="c-input" type="file" id="UploadAttendeeFile" name="UploadAttendeeFile">
                    <label class="c-field__label" for="user-name">Upload attendee list in CSV format</label>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="c-field u-mb-medium">
                    <input type="submit" value="Upload" class="c-btn c-btn--fullwidth c-btn--info"/>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="col-md-6 col-xl-6">
          <div class="c-card" data-mh="attendee-import">
            Please upload the csv file with proper meta fields. Download the <a href="downloads/HACorSIGHTSample.csv" target="_blank">sample file</a>.
          </div>
        </div>

      </div>

      <div class="row">
        <div class="col-12">
          <div class="c-table-responsive@wide">
            @if(isset($dataArray['filePath']) && $dataArray['filePath'] != "false")
            <table class="c-table">
              <thead class="c-table__head">
                <tr class="c-table__row">
                  <th class="c-table__cell c-table__cell--head">#</th>
                  <th class="c-table__cell c-table__cell--head">id</th>
                  <th class="c-table__cell c-table__cell--head">Certificate Type</th>
                  <th class="c-table__cell c-table__cell--head">Project Name</th>
                  <th class="c-table__cell c-table__cell--head">Member Email</th>
                  <th class="c-table__cell c-table__cell--head">Import Status</th>
                </tr>
              </thead>
              <tbody>
                @php $resultCounter = 1; @endphp
                @foreach ($dataArray['importStatus'] as $singleData)
                <tr class="c-table__row">
                  <td class="c-table__cell">{{ $resultCounter++ }}</td>
                  <td class="c-table__cell">{{ $singleData['data']['id'] }}</td>
                  <td class="c-table__cell">{{ $singleData['data']['Certificate_Type'] }}</td>
                  <td class="c-table__cell">{{ $singleData['data']['Project_Name'] }}</td>
                  <td class="c-table__cell">{{ $singleData['data']['Email'] }}</td>
                  <td class="c-table__cell">
                    @if($singleData['status'] == "Yes")
                      <a class="c-badge c-badge--small c-badge--success">Success</a>
                    @else
                      <a class="c-badge c-badge--small c-badge--danger">Failed</a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @elseif(isset($dataArray['filePath']) && $dataArray['filePath'] == "false")
            <div class="row u-justify-center">
              <div class="col-md-6">
                <div class="c-alert c-alert--danger">
                  <span class="c-alert__icon">
                    <i class="feather icon-slash"></i>
                  </span>

                  <div class="c-alert__content">
                    <h4 class="c-alert__title">Oops! something is really wrong</h4>
                    <p>Looks like you uploaded a wrong file. Please upload a vlid CSV file to the system!</p>
                  </div>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
      </div>
      @include('layouts.footer')
    </div>
  </main>
</div>
@endsection
