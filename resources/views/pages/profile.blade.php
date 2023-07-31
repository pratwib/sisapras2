<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

@include('partials.head')

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        @if (session()->has('message'))
        <div class="bs-toast toast fade show toast-placement-ex bg-primary top-0 start-50 translate-middle-x m-3" role=" alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Sisapras</div>
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
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </nav>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="mb-0 card-header d-flex align-items-center">
                                    <h5 class="card-title">Detail Profile</h5>
                                    <span class="badge bg-label-primary ms-2" style="margin-bottom: 14px;">
                                        @if($user->role === 'user')
                                        <span>Peminjam</span>
                                        @elseif($user->role === 'admin')
                                        <span>Admin</span>
                                        @elseif($user->role === 'superadmin')
                                        <span>Super Admin</span>
                                        @endif
                                    </span>
                                    <div class="d-flex ms-auto">
                                        <button type="button" href="#editModal{{ $user->user_id }}" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->user_id }}">Edit Profile</button>

                                        <!-- Edit Profile Modal -->
                                        <div class="modal fade" id="editModal{{ $user->user_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalTitle">Edit Profile</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('profile.edit.'. $user->role, ['id' => $user->user_id]) }}" method="post">
                                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="name" class="form-label">Nama</label>
                                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Masukkan nama" value="{{ $user->name }}" autofocus>
                                                                @error('name')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="username" class="form-label">Username</label>
                                                                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" placeholder="Masukkan username" value="{{ $user->username }}">
                                                                @error('username')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="hp_number" class="form-label">Nomor HP</label>
                                                                <input type="tel" class="form-control @error('hp_number') is-invalid @enderror" id="hp_number" name="hp_number" placeholder="Masukkan nomor hp" value="{{ $user->hp_number }}">
                                                                @error('hp_number')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="email" class="form-label">Email</label>
                                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Masukkan email" value="{{ $user->email }}">
                                                                @error('email')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            @if($user->role === 'superadmin'||$user->role === 'admin')
                                                            <div class=" mb-3 form-password-toggle">
                                                                <label class="form-label" for="password">Password</label>
                                                                <div class="input-group input-group-merge">
                                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password" value="{{ $user->password }}">
                                                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                                                </div>
                                                                @error('password')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            @endif
                                                            @if($user->role === 'user')
                                                            <div class="mb-3">
                                                                <label for="reg_number" class="form-label">NIM / NIP</label>
                                                                <input type="text" class="form-control @error('reg_number') is-invalid @enderror" id="reg_number" name="reg_number" placeholder="Masukkan NIM atau NIP" value="{{ $user->reg_number }}">
                                                                @error('reg_number')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="department" class="form-label">Departemen / Jurusan</label>
                                                                <select class="form-select @error('department') is-invalid @enderror" type="text" id="department" name="department">
                                                                    @foreach($departments as $department)
                                                                    <option value="{{ $department }}" @if($department===$user->department) selected @endif >{{ $department }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('department')
                                                                <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            @endif
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
                                    </div>
                                </div>



                                <!-- Detail Profile -->
                                <div class="card-body">
                                    <div class="col">
                                        <div class="mb-3 col-md">
                                            <label for="name" class="mb-0 form-label">Nama</label>
                                            <input class="form-control-plaintext" type="text" id="name" value="{{ $user->name }}" />
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label for="username" class="mb-0 form-label">Username</label>
                                            <input type="text" class="form-control-plaintext" id="username" value="{{ $user->username }}" />
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label class="mb-0 form-label" for="hp_number">Nomor HP</label>
                                            <input type="tel" id="hp_number" class="form-control-plaintext" value="{{ $user->hp_number }}" />
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label for="email" class="mb-0 form-label">Email</label>
                                            <input class="form-control-plaintext" type="email" id="email" value="{{ $user->email }}" />
                                        </div>
                                        @if($user->role === 'user')
                                        <div class="mb-3 col-md">
                                            <label for="reg_number" class="mb-0 form-label">NIM / NIP</label>
                                            <input class="form-control-plaintext" type="text" id="reg_number" placeholder="-" value="{{ $user->reg_number }}" />
                                        </div>
                                        <div class="mb-3 col-md">
                                            <label for="department" class="mb-0 form-label">Departemen</label>
                                            <input class="form-control-plaintext" type="text" id="department" placeholder="-" value="{{ $user->department }}" />
                                        </div>
                                        @endif
                                        @if($user->role === 'admin')
                                        <div class="mb-3 col-md">
                                            <label for="location_name" class="mb-0 form-label">Lokasi</label>
                                            <input type="text" id="location_name" class="form-control-plaintext" value="{{ $location->location_name }}" />
                                        </div>
                                        @endif
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