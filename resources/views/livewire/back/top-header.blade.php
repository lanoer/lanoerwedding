<div>
    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        <img class="rounded-circle header-profile-user" src="{{ $user->picture }}" alt="Header Avatar">
        <span class="d-none d-xl-inline-block ms-1">{{ $user->name }}</span>
        <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-end">
        <!-- item-->
        <a class="dropdown-item" href="{{ route('users.edit', $user->username) }}"><i
                class="bx bx-user font-size-16 align-middle me-1"></i>
            Profile</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item text-danger"
            href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i
                class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
            Logout</a>
        <form action="{{ route('logout') }}" id="logout-form" method="POST">@csrf</form>
    </div>
</div>
