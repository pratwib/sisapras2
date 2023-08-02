<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<title>Reset Password</title>

@include('partials.head')

<body>

    <!-- Content -->
    <div class="container-xxl">
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

        <div class="authentication-wrapper authentication-basic container-p-y">

            <!-- Register -->
            <div class="card" style="min-width: 400px;">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="app-brand justify-content-center mb-4">
                        <a href="/" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1406 1406">
                                    <g fill="#696cff">
                                        <path d="M 227.5,155.5 C 596.5,155.333 965.5,155.5 1334.5,156C 1369.95,161.445 1393.11,181.278 1404,215.5C 1404.77,219.147 1405.44,222.814 1406,226.5C 1406.67,596.167 1406.67,965.833 1406,1335.5C 1401.06,1366.57 1384.23,1388.4 1355.5,1401C 1348.74,1403.68 1341.74,1405.35 1334.5,1406C 965.5,1406.67 596.5,1406.67 227.5,1406C 196.051,1401.36 173.884,1384.53 161,1355.5C 158.391,1349.07 156.725,1342.4 156,1335.5C 155.333,965.833 155.333,596.167 156,226.5C 163.83,186.502 187.663,162.836 227.5,155.5 Z" />
                                    </g>
                                    <g fill="#fefeff">
                                        <path d="M 483.5,1072.5 C 491.984,1073.49 500.651,1073.83 509.5,1073.5C 509.5,1100.83 509.5,1128.17 509.5,1155.5C 455.873,1161.26 413.706,1142.26 383,1098.5C 371.727,1080.08 365.394,1060.08 364,1038.5C 363.667,986.833 363.333,935.167 363,883.5C 361.054,876.942 358.054,870.942 354,865.5C 333.297,846.462 312.297,827.795 291,809.5C 275.351,787.407 277.185,766.907 296.5,748C 317.193,733.645 337.026,718.145 356,701.5C 358.573,697.455 360.573,693.122 362,688.5C 363.317,631.878 363.984,575.212 364,518.5C 371.951,464.886 401.451,429.053 452.5,411C 471.249,406.865 490.249,405.365 509.5,406.5C 509.5,434.167 509.5,461.833 509.5,489.5C 500.161,489.334 490.827,489.5 481.5,490C 464.512,494.321 453.346,504.821 448,521.5C 447.667,576.167 447.333,630.833 447,685.5C 442.471,727.416 422.971,760.249 388.5,784C 394.5,789.333 400.5,794.667 406.5,800C 430.551,822.604 444.051,850.437 447,883.5C 447.333,935.167 447.667,986.833 448,1038.5C 452.217,1057.89 464.05,1069.22 483.5,1072.5 Z" />
                                    </g>
                                    <g fill="#fefeff">
                                        <path d="M 1057.5,1155.5 C 1057.5,1128.17 1057.5,1100.83 1057.5,1073.5C 1066.02,1073.83 1074.35,1073.49 1082.5,1072.5C 1101.65,1069.85 1113.82,1059.18 1119,1040.5C 1119.33,987.5 1119.67,934.5 1120,881.5C 1123.67,850.431 1136.51,823.931 1158.5,802C 1165.35,796.402 1172.02,790.569 1178.5,784.5C 1164.88,774.046 1152.71,762.046 1142,748.5C 1128.99,728.815 1121.66,707.148 1120,683.5C 1119.67,629.5 1119.33,575.5 1119,521.5C 1113.54,504.372 1102.04,493.872 1084.5,490C 1075.51,489.5 1066.51,489.334 1057.5,489.5C 1057.5,461.833 1057.5,434.167 1057.5,406.5C 1123.34,401.266 1169.51,428.599 1196,488.5C 1198.81,498.058 1201.14,507.725 1203,517.5C 1203.33,572.5 1203.67,627.5 1204,682.5C 1205.66,693.658 1210.83,702.824 1219.5,710C 1239.81,724.079 1259.31,739.246 1278,755.5C 1286.93,768.081 1288.93,781.747 1284,796.5C 1282.17,800.828 1279.84,804.828 1277,808.5C 1257.13,826.705 1236.96,844.538 1216.5,862C 1211.45,867.391 1207.61,873.557 1205,880.5C 1203.68,935.122 1203.02,989.788 1203,1044.5C 1193.36,1103.47 1159.53,1139.97 1101.5,1154C 1086.87,1155.35 1072.2,1155.85 1057.5,1155.5 Z" />
                                    </g>
                                    <g fill="#fefeff">
                                        <path d="M 782.5,479.5 C 840.165,476.11 894.499,487.943 945.5,515C 949.639,517.639 953.639,520.472 957.5,523.5C 940.5,544.833 923.5,566.167 906.5,587.5C 869.433,557.208 827.1,545.708 779.5,553C 732.266,566.967 717.099,597.134 734,643.5C 745.643,661.478 760.81,675.645 779.5,686C 826.332,706.409 870.999,730.409 913.5,758C 954.512,793.001 972.012,837.501 966,891.5C 960.101,947.503 932.601,989.003 883.5,1016C 856.025,1030.76 826.691,1039.1 795.5,1041C 740.706,1044.53 687.706,1036.53 636.5,1017C 624.554,1011.69 612.888,1005.86 601.5,999.5C 600.417,998.635 600.251,997.635 601,996.5C 612.167,970.333 623.333,944.167 634.5,918C 634.85,916.743 635.517,916.409 636.5,917C 681.158,959.996 734.158,976.663 795.5,967C 846.113,951.608 865.613,918.108 854,866.5C 842.5,843 825,825.5 801.5,814C 754.668,793.591 710.001,769.591 667.5,742C 629.419,707.635 613.253,664.801 619,613.5C 624.525,565.231 648.358,529.398 690.5,506C 707.361,497.158 725.028,490.491 743.5,486C 756.626,483.74 769.626,481.573 782.5,479.5 Z" />
                                    </g>
                                    <g fill="#a1a3ff">
                                        <path d="M 483.5,1072.5 C 492.5,1072.5 501.5,1072.5 510.5,1072.5C 510.831,1100.34 510.498,1128.01 509.5,1155.5C 509.5,1128.17 509.5,1100.83 509.5,1073.5C 500.651,1073.83 491.984,1073.49 483.5,1072.5 Z" />
                                    </g>
                                    <g fill="#898aff">
                                        <path d="M 1082.5,1072.5 C 1074.35,1073.49 1066.02,1073.83 1057.5,1073.5C 1057.5,1100.83 1057.5,1128.17 1057.5,1155.5C 1056.5,1128.01 1056.17,1100.34 1056.5,1072.5C 1065.17,1072.5 1073.83,1072.5 1082.5,1072.5 Z" />
                                    </g>
                                </svg>
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">SISAPRAS</span>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <!-- Login Form -->
                    @if ($errors->first('0'))
                    <div class="mb-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $errors->first('0') }}</div>
                    @endif
                    <form class="mb-3" action="{{ route('reset.post') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ request()->email }}">
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password')
                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-5 form-password-toggle">
                            <label class="form-label" for="comfirm_password">Konfirmasi Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                            @error('password')
                            <div class="mt-1 alert alert-danger" role="alert" style="font-size: 12px;">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="token" value="{{ request()->token }}">
                        <div class="mb-0">
                            <button class="btn btn-primary w-100" type="submit">Reset Password</button>
                        </div>
                    </form>
                </div>
                <!-- /Register -->
            </div>
        </div>
        <!-- / Content -->

        @include('partials.script')

</body>

</html>