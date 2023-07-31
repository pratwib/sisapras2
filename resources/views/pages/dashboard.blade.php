<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

@include('partials.head')

<body>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      @include('partials.menu')

      <!-- Layout container -->
      <div class="layout-page">

        @include('partials.header')

        <!-- Content wrapper -->
        <div class="content-wrapper">

          <!-- Content -->
          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">

              @if($user->role === 'superadmin')
              <div class="col-lg col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="icon" style="color: var(--bs-dark); background-color: rgba(35, 52, 70, 0.1); padding: 10px; border-radius: 20%;">
                        <i class="bx bx-briefcase" style="font-size: 24px;"></i>
                      </div>
                    </div>
                    <h3 class="card-title mb-1">{{ $adminCount }}</h3>
                    <span class="d-block mb-3">Admin Lokasi</span>
                    <a href="{{ route('admin') }}" class="btn btn-sm btn-outline-dark">Lihat Detail</a>
                  </div>
                </div>
              </div>

              <div class="col-lg col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="icon" style="color: var(--bs-info); background-color: rgba(3, 195, 236, 0.1); padding: 10px; border-radius: 20%;">
                        <i class="bx bx-buildings" style="font-size: 24px;"></i>
                      </div>
                    </div>
                    <h3 class="card-title mb-1">{{ $locationCount }}</h3>
                    <span class="d-block mb-3">Lokasi Peminjaman</span>
                    <a href="{{ route('location') }}" class="btn btn-sm btn-outline-info">Lihat Detail</a>
                  </div>
                </div>
              </div>

              @elseif($user->role === 'user'||$user->role === 'admin')
              <div class="col-lg col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="icon" style="color: var(--bs-warning); background-color: rgba(255, 171, 0, 0.1); padding: 10px; border-radius: 20%;">
                        <i class="bx bx-package" style="font-size: 24px;"></i>
                      </div>
                    </div>
                    <h3 class="card-title mb-1">{{ $itemCount }}</h3>
                    <span class="d-block mb-3">Barang Tersedia</span>
                    <a href="{{ route('item.'. $user->role) }}" class="btn btn-sm btn-outline-warning">Lihat Detail</a>
                  </div>
                </div>
              </div>

              <div class="col-lg col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="icon" style="color: var(--bs-success); background-color: rgba(113, 221, 55, 0.1); padding: 10px; border-radius: 20%;">
                        <i class="bx bx-sort-alt-2" style="font-size: 24px;"></i>
                      </div>
                    </div>
                    <h3 class="card-title mb-1">{{ $borrowCount }}</h3>
                    <span class="d-block mb-3">Barang Dipinjam</span>
                    <a href="{{ route('borrow.'. $user->role) }}" class="btn btn-sm btn-outline-success ">Lihat Detail</a>
                  </div>
                </div>
              </div>

              <div class="col-lg col-md">
                <div class="card">
                  <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                      <div class="icon" style="color: var(--bs-danger); background-color: rgba(255, 62, 29, 0.1); padding: 10px; border-radius: 20%;">
                        <i class="bx bx-history" style="font-size: 24px;"></i>
                      </div>
                    </div>
                    <h3 class="card-title mb-1">{{ $historyCount }}</h3>
                    <span class="d-block mb-3">Riwayat Peminjaman</span>
                    <a href="{{ route('history.'. $user->role) }}" class="btn btn-sm btn-outline-danger">Lihat Detail</a>
                  </div>
                </div>
              </div>
              @endif

            </div>
          </div>
          <!-- / Content -->

          @include('partials.footer')

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  @include('partials.script')
</body>

</html>