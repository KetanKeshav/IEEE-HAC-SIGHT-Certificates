<header class="c-navbar u-mb-medium">
  <button class="c-sidebar-toggle js-sidebar-toggle">
    <i class="feather icon-align-left"></i>
  </button>

  <h2 class="c-navbar__title">{{ $dataArray['uri'] }}</h2>
  <div class="c-dropdown dropdown">
    <div class="c-avatar c-avatar--xsmall dropdown-toggle" id="dropdownMenuAvatar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
      <img class="c-avatar__img" src="https://api.adorable.io/avatars/72/abott@adorable.png" alt="IEEE Xtreme Admin">
    </div>
    <div class="c-dropdown__menu has-arrow dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuAvatar">
      <a class="c-dropdown__item dropdown-item" href="/logout">Logout</a>
    </div>
  </div>
</header>
