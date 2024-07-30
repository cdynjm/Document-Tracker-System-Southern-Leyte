<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl
        {{ str_contains(Request::url(), 'virtual-reality') == true ? ' mt-3 mx-3 bg-primary' : '' }}"
        data-scroll="false">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb w-100">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                
            </ol>
            <h6 class="font-weight-bolder text-dark mb-0">{{ $title }}</h6>
            @can('accessOffice', Auth::user())
                <p class="text-end text-sm mt-2 fw-bold">{{ auth()->user()->Office->office }}</p>   
            @endcan
            @can('accessUser', Auth::user())
                <p class="text-end text-sm mt-2 fw-bold">{{ auth()->user()->Section->Office->office }}</p>   
            @endcan
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group">
                    
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    
                    <a href="javascript:;" class="nav-link text-dark p-0 mt-2" id="dropdownMenuButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                        @can('accessAdmin', Auth::user())
                            <span class=" fw-bolder d-sm-inline">{{ auth()->user()->name }}</span>
                            <img src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" class="avatar avatar-sm ms-2 img-fluid rounded-circle" alt="user1">   
                        @endcan
                        @can('accessOffice', Auth::user())
                            <span class=" fw-bolder d-sm-inline">{{ auth()->user()->name }}</span>
                            <img src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" class="avatar avatar-sm ms-2 img-fluid rounded-circle" alt="user1">
                        @endcan
                        @can('accessUser', Auth::user())
                            <span class=" fw-bolder d-sm-inline">{{ auth()->user()->name }}</span>
                            <img src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" class="avatar avatar-sm ms-2 img-fluid rounded-circle" alt="user1">
                            <p class="text-sm">{{ auth()->user()->Section->section }}</p>
                        @endcan
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3"
                        aria-labelledby="dropdownMenuButton">
                        <li class="list-group-item p-0" style="border: none !important;">
                            <a wire:navigate 
                            @can('accessAdmin', Auth::user())
                                href="{{ route('admin-profile') }}"
                            @endcan
                            @can('accessOffice', Auth::user())
                                href="{{ route('office-profile') }}"
                            @endcan
                            @can('accessUser', Auth::user())
                                href="{{ route('user-profile') }}"
                            @endcan
                            class=" ms-2 nav-link text-dark font-weight-bold p-0">
                                <i class="fas fa-user-circle me-2"></i> Profile
                            </a>
                        </li>
                        <hr>
                        <li class="list-group-item p-0" style="border: none !important;">
                            <form id="sign-out">
                                @csrf
                                <button class="ms-2 nav-link text-dark font-weight-bold p-0 border-0 bg-white">
                                    <i class="fas fa-sign-out-alt me-2"></i> Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-dark p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-dark"></i>
                            <i class="sidenav-toggler-line bg-dark"></i>
                            <i class="sidenav-toggler-line bg-dark"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<hr class="horizontal dark m-0">

<!-- End Navbar -->
