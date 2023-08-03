<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<title>Admin</title>

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
                                <li class="breadcrumb-item active">Admin</li>
                            </ol>
                        </nav>

                        <!-- Small table -->
                        <div class="card">

                            <!-- Header table -->
                            <div class="card-header d-flex align-items-center">
                                <h5 class="card-title">Daftar Admin</h5>
                                <div class="ms-auto d-flex">

                                    <!-- Button Add Modal -->
                                    <button type="button" href="#addModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><span style="white-space: nowrap;">Tambah Admin</span></button>

                                    <!-- Add Admin Modal -->
                                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitle">Tambah Admin</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.add') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Nama</label>
                                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama" value="{{ old('name') }}" autofocus>
                                                            @error('name')
                                                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="hp_number" class="form-label">Nomor HP</label>
                                                            <input type="tel" class="form-control @error('hp_number') is-invalid @enderror" id="hp_number" name="hp_number" placeholder="Masukkan nomor hp" value="{{ old('hp_number') }}">
                                                            @error('hp_number')
                                                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class=" mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ old('email') }}">
                                                            @error('email')
                                                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class=" mb-3 form-password-toggle">
                                                            <label class="form-label" for="password">Password</label>
                                                            <div class="input-group input-group-merge">
                                                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password">
                                                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                            </div>
                                                            @error('password')
                                                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="location_id" class="form-label">Lokasi</label>
                                                            <select class="form-select @error('location_id') is-invalid @enderror" type="text" id="location_id" name="location_id">
                                                                @foreach(session('locations') as $location)
                                                                <option value="{{ $location->location_id}}">{{ $location->location_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('location_id')
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
                                            <th>Nama</th>
                                            <th>Lokasi</th>
                                            <th>Nomor HP</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($admins as $admin)
                                        <tr>
                                            <td>{{ $admin->user_id}}</td>
                                            <td><strong>{{ $admin->name}}</strong></td>
                                            <td>{{ $admin->location_name}}</td>
                                            <td>{{ $admin->hp_number}}</td>
                                            <td>
                                                <!-- Button Edit modal -->
                                                <button type="button" href="#editModal{{ $admin->user_id }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $admin->user_id }}">
                                                    <span class="tf-icons bx bx-edit"></span>
                                                </button>

                                                <!-- Edit Admin Modal -->
                                                <div class="modal fade" id="editModal{{ $admin->user_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitle">Edit Admin</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.edit', ['id' => $admin->user_id]) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="name" class="form-label">Nama</label>
                                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama" value="{{ $admin->name }}" autofocus>
                                                                        @error('name')
                                                                        <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="hp_number" class="form-label">Nomor HP</label>
                                                                        <input type="tel" class="form-control @error('hp_number') is-invalid @enderror" id="hp_number" name="hp_number" placeholder="Masukkan nomor hp" value="{{ $admin->hp_number }}">
                                                                        @error('hp_number')
                                                                        <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="email" class="form-label">Email</label>
                                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ $admin->email }}">
                                                                        @error('email')
                                                                        <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class=" mb-3 form-password-toggle">
                                                                        <label class="form-label" for="password">Password</label>
                                                                        <div class="input-group input-group-merge">
                                                                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" value="{{ $admin->password }}">
                                                                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                                        </div>
                                                                        @error('password')
                                                                        <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="location_id" class="form-label">Lokasi</label>
                                                                        <select class="form-select @error('location_id') is-invalid @enderror" type="text" id="location_id" name="location_id">
                                                                            @foreach(session('locations') as $location)
                                                                            <option value=" {{ $location->location_id}}" @if($location->location_id === $admin->location_id) selected @endif >{{ $location->location_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error('location_id')
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
                                                <button type="button" href="#deleteModal{{ $admin->user_id }}" class="btn btn-sm btn-icon btn-danger ms-3 " data-bs-toggle="modal" data-bs-target="#deleteModal{{ $admin->user_id }}">
                                                    <span class="tf-icons bx bx-x"></span>
                                                </button>

                                                <!-- Delete Admin Modal -->
                                                <div class="modal fade" id="deleteModal{{ $admin->user_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('admin.delete', ['id' => $admin->user_id]) }}" method="POST">
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