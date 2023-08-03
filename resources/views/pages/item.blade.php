<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<title>Barang</title>

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
                                <li class="breadcrumb-item active">Barang</li>
                            </ol>
                        </nav>

                        <!-- Small table -->
                        <div class="card">

                            <!-- Header table -->
                            <div class="card-header d-flex align-items-center">
                                <h5 class="card-title">Daftar Barang</h5>
                                <div class="ms-auto d-flex">

                                    @if($user->role === 'admin')
                                    <!-- Button Add modal -->
                                    <button type="button" href="#addModal" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal"><span style="white-space: nowrap;">Tambah Barang</span></button>

                                    <!-- Add Item Modal -->
                                    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalTitle">Tambah Barang</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('item.add.'. $user->role) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="item_name" class="form-label">Barang</label>
                                                            <input type="text" class="form-control @error('item_name') is-invalid @enderror" id="item_name" name="item_name" placeholder="Masukkan nama barang" value="{{ old('item_name') }}" autofocus>
                                                            @error('item_name')
                                                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="item_desc" class="form-label">Deskripsi</label>
                                                            <textarea type="text" class="form-control" id="item_desc" name="item_desc" placeholder="Masukkan deskripsi barang" rows="3" value="{{ old('item_desc') }}"></textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="item_quantitiy" class="form-label">Stok</label>
                                                            <input type="number" class="form-control" id="item_quantity" name="item_quantity" placeholder="Masukkan stok barang" min="0" value="1">
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
                                    @endif
                                </div>
                            </div>

                            <!-- Tabel -->
                            <div class="ms-4 me-4 mb-4 table-responsive text-nowrap">
                                <table id="dataTable" class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Stok</th>
                                            <th>Lokasi</th>
                                            @if($user->role === 'user'||$user->role === 'admin')
                                            <th>Aksi</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody class="table-border-bottom-0">
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $item->item_id }}</td>
                                            <td><strong>{{ $item->item_name }}</strong></td>
                                            <td style="max-width: 20ch; overflow-wrap: break-word; white-space: normal;">
                                                {{ $item->item_desc }}
                                            </td>
                                            <td><strong>{{ $item->item_quantity }}</strong></td>
                                            <td>{{ $item->location_name}}</td>
                                            @if($user->role === 'user'||$user->role === 'admin')
                                            <td>
                                                @if($user->role === 'user')
                                                <!-- Button Borrow Modal -->
                                                <button type="button" href="#borrowModal{{ $item->item_id }}" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#borrowModal{{ $item->item_id }}">Pinjam</button>

                                                <!-- Borrow Item Modal -->
                                                <div class="modal fade" id="borrowModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="borrowModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitle">Pinjam Barang</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('item.borrow', ['id' => $item->item_id]) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="location_id" id="location_id" value="{{ $item->location_id }}">
                                                                    <input type="hidden" name="item_id" id="item_id" value="{{ $item->item_id }}">
                                                                    <input type="hidden" name="user_id" id="user_id" value="{{ $user->user_id }}">
                                                                    <div class="mb-3">
                                                                        <label for="item_name" class="form-label">Barang</label>
                                                                        <input readonly type="text" class="form-control" id="item_name" name="item_name" value="{{ $item->item_name}}">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="item_desc" class="form-label">Deskripsi</label>
                                                                        <textarea readonly type="text" class="form-control" id="item_desc" name="item_desc" rows="3">{{ $item->item_desc}}</textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="location_id" class="form-label">Lokasi</label>
                                                                        <select disabled class="form-select @error('location_id') is-invalid @enderror" type="text" id="location_id" name="location_id">
                                                                            @foreach(session('locations') as $location)
                                                                            <option value=" {{ $location->location_id}}" @if($location->location_id === $item->location_id) selected @endif >{{ $location->location_name}}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="lend_quantity" class="form-label">Jumlah</label>
                                                                        <input type="number" class="form-control @error('lend_quantity') is-invalid @enderror" id="lend_quantity" name="lend_quantity" placeholder="Masukkan jumlah pinjam" min="1" max="{{ $item->item_quantity }}" value="1">
                                                                    </div>
                                                                    @error('lend_quantity')
                                                                    <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                    @enderror
                                                                    <div class="mb-3">
                                                                        <label for="return_date" class="form-label">Tanggal Pengembalian</label>
                                                                        <input type="date" class="form-control @error('return_date') is-invalid @enderror" id="return_date" name="return_date" placeholder="Masukkan tanggal pengembalian" value="{{ old('return_date') }}">
                                                                    </div>
                                                                    @error('return_date')
                                                                    <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                    @enderror
                                                                    <div class="mb-3">
                                                                        <label for="lend_detail" class="form-label">Tujuan</label>
                                                                        <textarea type="text" class="form-control @error('lend_detail') is-invalid @enderror" id="lend_detail" name="lend_detail" rows="3" placeholder="Jelaskan tujuan meminjam barang...">{{ old('lend_detail') }}</textarea>
                                                                    </div>
                                                                    @error('lend_detail')
                                                                    <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                    @enderror
                                                                    <div class="mb-3">
                                                                        <label for="lend_photo" class="form-label">Foto Selfie</label>
                                                                        <input type="file" accept="image/*" class="form-control @error('lend_photo') is-invalid @enderror" id="lend_photo" name="lend_photo" value="{{ old('lend_photo') }}">
                                                                    </div>
                                                                    @error('lend_photo')
                                                                    <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                                        Kembali
                                                                    </button>
                                                                    <button type="submit" class="btn btn-primary">Pinjam</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                @if($user->role === 'admin')
                                                <!-- Button Edit modal -->
                                                <button type="button" href="#editModal{{ $item->item_id }}" class="btn btn-sm btn-icon btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->item_id }}">
                                                    <span class="tf-icons bx bx-edit"></span>
                                                </button>

                                                <!-- Edit Barang Modal -->
                                                <div class="modal fade" id="editModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="modalTitle">Edit Barang</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('item.edit.'. $user->role, ['id' => $item->item_id]) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <div class="mb-3">
                                                                        <label for="item_name" class="form-label">Barang</label>
                                                                        <input type="text" class="form-control @error('item_name') is-invalid @enderror" id="item_name" name="item_name" placeholder="Masukkan nama barang" value="{{ $item->item_name }}" autofocus>
                                                                        @error('item_name')
                                                                        <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="item_desc" class="form-label">Deskripsi</label>
                                                                        <textarea type="text" class="form-control" id="item_desc" name="item_desc" placeholder="Masukkan deskripsi barang" rows="3" value="{{ $item->item_desc }}">{{ $item->item_desc }}</textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="item_quantitiy" class="form-label">Stok</label>
                                                                        <input type="number" class="form-control" id="item_quantity" name="item_quantity" placeholder="Masukkan stok barang" min="0" value="{{ $item->item_quantity }}">
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
                                                <button type="button" href="#deleteModal{{ $item->item_id }}" class="btn btn-sm btn-icon btn-danger ms-3 " data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->item_id }}">
                                                    <span class="tf-icons bx bx-x"></span>
                                                </button>

                                                <!-- Delete Item Modal -->
                                                <div class="modal fade" id="deleteModal{{ $item->item_id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('item.delete.'. $user->role, ['id' => $item->item_id]) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col mb-3">
                                                                            <h5 class="text" style="text-align: center; max-width: 30ch; overflow-wrap: break-word; white-space: normal;">Kamu yakin ingin menghapus<br>barang ini?</h5>
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
                                                @endif
                                            </td>
                                            @endif
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