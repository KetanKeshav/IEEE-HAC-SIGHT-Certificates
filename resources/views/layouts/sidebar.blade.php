<div class="o-page__sidebar js-page-sidebar">
  <aside class="c-sidebar">
    <div class="c-sidebar__brand">
      <a href="#"><img src="/HAC_SIGHT_LOGO.png" width="190" alt="IEEEXtreme"></a>
    </div>

    <!-- Scrollable -->
    <div class="c-sidebar__body">

      <span class="c-sidebar__title">Dashboard</span>
      <ul class="c-sidebar__list">
        <li>
          @if($dataArray['uri']=="Dashboard")
          <a class="c-sidebar__link is-active" href="dashboard">
          @else
          <a class="c-sidebar__link" href="dashboard">
          @endif
            <i class="c-sidebar__icon feather icon-home"></i>Dashboard
          </a>
        </li>
      </ul>

      <span class="c-sidebar__title">Certificates</span>
      <ul class="c-sidebar__list">
        <li>
          @if($dataArray['uri']=="Issue Certificates")
          <a class="c-sidebar__link is-active" href="issue-certificates">
          @else
          <a class="c-sidebar__link" href="issue-certificates">
          @endif
            <i class="c-sidebar__icon feather icon-command"></i>Issue Certificates
          </a>
        </li>
        <li>
          @if($dataArray['uri']=="Issued Certificates")
          <a class="c-sidebar__link is-active" href="issued-certificates">
          @else
          <a class="c-sidebar__link" href="issued-certificates">
          @endif
            <i class="c-sidebar__icon feather icon-award"></i>Issued Certificates
          </a>
        </li>
        <li>
          @if($dataArray['uri']=="Pending Certificates")
          <a class="c-sidebar__link is-active" href="pending-certificates">
          @else
          <a class="c-sidebar__link" href="pending-certificates">
          @endif
            <i class="c-sidebar__icon feather icon-upload"></i>Pending Certificates
          </a>
        </li>
      </ul>

      <span class="c-sidebar__title">Users</span>
      <ul class="c-sidebar__list">
        <li>
          @if($dataArray['uri']=="Import Attendees")
          <a class="c-sidebar__link is-active" href="import-attendees">
          @else
          <a class="c-sidebar__link" href="import-attendees">
          @endif
            <i class="c-sidebar__icon feather icon-upload-cloud"></i>Import Attendees
          </a>
        </li>
        <li>
          @if($dataArray['uri']=="Attendees")
          <a class="c-sidebar__link is-active" href="attendees">
          @else
          <a class="c-sidebar__link" href="attendees">
          @endif
            <i class="c-sidebar__icon feather icon-users"></i>Attendees
          </a>
        </li>
        <li>
          @if($dataArray['uri']=="Teams")
          <a class="c-sidebar__link is-active" href="teams">
          @else
          <a class="c-sidebar__link" href="teams">
          @endif
            <i class="c-sidebar__icon feather icon-codepen"></i>Teams
          </a>
        </li>
      </ul>

      <span class="c-sidebar__title">Changes</span>
      <ul class="c-sidebar__list">
        <li>
          @if($dataArray['uri']=="Requested Changes")
          <a class="c-sidebar__link is-active" href="requested-changes">
          @else
          <a class="c-sidebar__link" href="requested-changes">
          @endif
            <i class="c-sidebar__icon feather icon-edit"></i>Requested Changes
          </a>
        </li>
        <li>
          @if($dataArray['uri']=="Approved Changes")
          <a class="c-sidebar__link is-active" href="approved-changes">
          @else
          <a class="c-sidebar__link" href="approved-changes">
          @endif
            <i class="c-sidebar__icon feather icon-user-check"></i>Approved Changes
          </a>
        </li>
      </ul>

    </div>


    <a class="c-sidebar__footer" href="logout">
      Logout <i class="c-sidebar__footer-icon feather icon-power"></i>
    </a>
  </aside>
</div>
