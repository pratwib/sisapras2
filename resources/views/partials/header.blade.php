<!-- Navbar -->

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar" style="height: 56px;">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <h5 class="text-primary mt-3">Selamat datang, {{ $user->name }}!</h5>

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- Place this tag where you want the button to render. -->

            <!-- Role -->
            <div class="d-flex">
                <div class="avatar avatar-online me-2" style="width: 32px; height: 32px;">
                    <img src="https://w7.pngwing.com/pngs/81/570/png-transparent-profile-logo-computer-icons-user-user-blue-heroes-logo-thumbnail.png" alt class="w-px-32 h-auto rounded-circle" />
                </div>
                <span class="d-block mt-1">
                    @if($user->role === 'user')
                    <span>Peminjam</span>
                    @elseif($user->role === 'admin')
                    <span>Admin</span>
                    @elseif($user->role === 'superadmin')
                    <span>Super Admin</span>
                    @endif
                </span>
            </div>
            <!--/ User -->
        </ul>
    </div>
</nav>

<!-- / Navbar -->