<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Home</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <!-- Icons-->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link rel="stylesheet" href="../assets/css/styles.css" />
</head>

<body id="page-top">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="">SISAPRAS</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#sop">SOP & Panduan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Layanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#items">Barang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contacts">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">SISTEM INFORMASI<br>SARANA DAN PRASARANA</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Silakan lakukan peminjaman alat elektronik dan barang lainnya hanya di Sisapras<br>Fakultas Teknik Universitas Diponegoro</p>
                    <a class="btn btn-light btn-xl me-3" href="{{ route('register') }}">Register</a>
                    <a class="btn btn-primary btn-xl" href="{{ route('login') }}">Login</a>
                </div>
            </div>
        </div>
    </header>

    <!-- About-->
    <section class="page-section bg-primary" id="sop">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">SOP & PANDUAN</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 mb-4">Terdapat beberapa hal yang harus diperhatikan saat melakukan peminjaman<br>Silakan klik tombol dibawah ini untuk mengunduh berkas</p>
                    <a class="btn btn-light btn-xl" href="{{ route('home.sop') }}">Unduh</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services-->
    <section class="page-section" id="services">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">LAYANAN</h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-3"><i class=" bx bx-sort-alt-2 fs-1 text-primary"></i></div>
                        <h3 class=" h4 mb-3">Pinjam</h3>
                        <p class="text-muted mb-0">Ajukan peminjaman barang yang kamu perlukan</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-3"><i class="bx bx-check fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-3">Ambil</h3>
                        <p class="text-muted mb-0">Ambil barang kamu di lokasi yang telah disetujui</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-3"><i class="bx bx-undo fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-3">Kembali</h3>
                        <p class="text-muted mb-0">Kembalikan barang yang kamu pinjam dengan tepat waktu</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-3"><i class="bx bx-history fs-1 text-primary"></i></div>
                        <h3 class="h4 mb-3">Riwayat</h3>
                        <p class="text-muted mb-0">Kamu bisa melihat riwayat dan status peminjaman kamu</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio-->
    <div id="items">
        <div class="container-fluid p-0">
            <div class="row g-0">
                <div class="col-lg-4 col-sm-6">
                    <a class="item-box" href="../assets/img/item/fullsize/1.jpg" title="Project Name">
                        <img class="img-fluid" src="../assets/img/item/thumbnails/1.jpg" alt="..." />
                        <div class="item-box-caption">
                            <div class="project-category" style="font-size: 20px;">Elektronik</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="item-box" href="../assets/img/item/fullsize/2.jpg" title="Project Name">
                        <img class="img-fluid" src="../assets/img/item/thumbnails/2.jpg" alt="..." />
                        <div class="item-box-caption">
                            <div class="project-category" style="font-size: 20px;">Kabel-kabel</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="item-box" href="../assets/img/item/fullsize/3.jpg" title="Project Name">
                        <img class="img-fluid" src="../assets/img/item/thumbnails/3.jpg" alt="..." />
                        <div class="item-box-caption">
                            <div class="project-category" style="font-size: 20px;">Fotografi</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="item-box" href="../assets/img/item/fullsize/4.jpg" title="Project Name">
                        <img class="img-fluid" src="../assets/img/item/thumbnails/4.jpg" alt="..." />
                        <div class="item-box-caption">
                            <div class="project-category" style="font-size: 20px;">Perkakas</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="item-box" href="../assets/img/item/fullsize/5.jpg" title="Project Name">
                        <img class="img-fluid" src="../assets/img/item/thumbnails/5.jpg" alt="..." />
                        <div class="item-box-caption">
                            <div class="project-category" style="font-size: 20px;">ATK</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <a class="item-box" href="../assets/img/item/fullsize/6.jpg" title="Project Name">
                        <img class="img-fluid" src="../assets/img/item/thumbnails/6.jpg" alt="..." />
                        <div class="item-box-caption p-3">
                            <div class="project-category" style="font-size: 20px;">Perabotan</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact-->
    <section class="page-section" id="contacts">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 col-xl-6 text-center">
                    <h2 class="mt-0">KONTAK</h2>
                    <hr class="divider" />
                    <p class="text-muted mb-5">Hubungi kami<br>jika kamu mengalami kendala dalam proses peminjaman barang</p>
                </div>
            </div>
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bx bxl-whatsapp fs-1 text-primary"></i></div>
                        <h4 class=" h4 mb-3">Whatsapp</h4>
                        <a class="text-muted mb-0" href="https://wa.me/6285800115790">085800115790</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bx bx-envelope fs-1 text-primary"></i></div>
                        <h4 class="h4 mb-3">Email</h4>
                        <p class="text-muted mb-0">ftsarpras@gmail.com</p>
                    </div>
                </div>
            </div>
    </section>

    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5">
            <div class="small text-center text-muted">
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script>
                - SIFT
            </div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SimpleLightbox plugin JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.js"></script>
    <!-- Core theme JS-->
    <script src="../assets/vendor/js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>