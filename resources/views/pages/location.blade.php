<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<title>Lokasi</title>

@include('partials.head')

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        @if (session()->has('message'))
        <div class="bs-toast toast fade show toast-placement-ex bg-primary top-0 start-50 translate-middle-x m-3" role=" alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Sisarpras</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">{{ session()->get('message') }}</div>
        </div>
        @endif
        <div class="layout-container">

            @include('partials.menu')

            <!-- Layout container -->
            <div class="layout-page">

                @include('partials.header')

                <!-- Content wrapper -->
                <div class="content-wrapper">

                    <!-- Content -->
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-style1">
                                <li class="breadcrumb-item mb-2">
                                    <a href="{{ route('dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active">Lokasi</li>
                            </ol>
                        </nav>

                        <!-- Small table -->
                        <div class="card">

                            <!-- Header table -->
                            <div class="card-header d-flex align-items-center">
                                <h5 class="card-title">Daftar Lokasi</h5>
                                <div class="ms-auto d-flex">

                                    <!-- Button Add Modal -->
                                    <button type="button" href="#addModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><span style="white-space: nowrap;">Tambah Lokasi</span></button>

                                    <!-- Add Location Modal -->
                                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true" data-bs-backdrop="static">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitle">Tambah Lokasi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('location.add') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="location_name" class="form-label">Lokasi</label>
                                                            <input type="text" class="form-control @error('location_name') is-invalid @enderror" id="location_name" name="location_name" placeholder="Masukkan nama lokasi" value="{{ old('location_name') }}" autofocus>
                                                            @error('location_name')
                                                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Kembali
                                                        </button>
                                                        <button type="submit" class="btn btn-primary">Tambahkan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tabel -->
                            <div class="ms-4 me-4 mb-4 table-responsive text-nowrap">
                                <table id="dataTable" class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Lokasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($locations as $location)
                                        <tr>
                                            <td>{{ $location->location_id }}</td>
                                            <td><strong>{{ $location->location_name }}</strong></td>
                                            <td>
                                                <!-- Button Edit modal -->
                                                <button type="button" href="#editModal{{ $location->location_id }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $location->location_id }}">
                                                    <span class="tf-icons bx bx-edit"></span>
                                                </button>

                                                <!-- Edit Location Modal -->
                                                <div class="modal fade" id="editModal{{ $location->location_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitle">Edit Lokasi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('location.edit', ['id' => $location->location_id]) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="location_name" class="form-label">Lokasi</label>
                                                                        <input type="text" class="form-control @error('location_name') is-invalid @enderror" id="location_name" name="location_name" placeholder="Masukkan nama lokasi" value="{{ $location->location_name }}" autofocus>
                                                                        @error('location_name')
                                                                        <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                        Kembali
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Button Delete Modal -->
                                                <button type="button" href="#deleteModal{{ $location->location_id }}" class="btn btn-sm btn-icon btn-danger ms-3 " data-bs-toggle="modal" data-bs-target="#deleteModal{{ $location->location_id }}">
                                                    <span class="tf-icons bx bx-x"></span>
                                                </button>

                                                <!-- Delete Location Modal -->
                                                <div class="modal fade" id="deleteModal{{ $location->location_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('location.delete', ['id' => $location->location_id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col mb-3">
                                                                            <h5 class="text" style="text-align: center; max-width: 30ch; overflow-wrap: break-word; white-space: normal;">Kamu yakin ingin menghapus<br>lokasi ini?</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button>
                                                                    <button type="submit" class="btn btn-danger">Ya, hapus</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--/ Small table -->

                        <!-- Restore Location -->
                        <div class="accordion mt-4">
                            <div class="card accordion-item">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse" data-bs-target="#locationRestore" aria-expanded="true" aria-controls="locationRestore">
                                        Restore Lokasi
                                    </button>
                                </h2>

                                <div id="locationRestore" class="accordion-collapse collapse">
                                    <div class="accordion-body">
                                        <div class="table-responsive text-nowrap">
                                            <table id="dataTable" class="table table-hover table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Lokasi</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-border-bottom-0">
                                                    @foreach($deletedLocations as $deletedLocation)
                                                    <tr>
                                                        <td>{{ $deletedLocation->location_id }}</td>
                                                        <td><strong>{{ $deletedLocation->location_name }}</strong></td>
                                                        <td>

                                                            <!-- Button Restore -->
                                                            <a type="button" href="{{ route('location.restore', ['id' => $deletedLocation->location_id]) }}" class="btn btn-sm btn-primary">Restore</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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