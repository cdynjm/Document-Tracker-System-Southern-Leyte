@php
    use App\Models\User;
    use App\Models\Tracker;
    use App\Models\Documents;
    
    $offices = User::where(['role' => 2])->get();

@endphp

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-md my-3 fixed-start ms-4" style="position: fixed; z-index: 10;"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex mt-3" href="">
            <img style="width: 50px; height: 50px;" src="https://southernleyte.gov.ph/wp-content/uploads/2023/03/Province-Logo.png" class="ms-4 mb-4 mt-2" alt="...">
            <span class="ms-3 sidebar-text fw-bolder fs-4">
                DTS
            <p style="font-size: 11px;">Document Tracking System</p>
          </span>
        </a>
    </div>

    <hr class="horizontal dark mt-0">

    @if(Auth::user()->role == 1)
        <div class="collapse navbar-collapse  w-auto h-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'admin-dashboard' ? 'active bg-dark text-white' : '' }}" href="{{ route('admin-dashboard') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                        </div>
                       
                        <span class="nav-link-text ms-1">Dashboard</span>
                        
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'offices' ? 'active bg-dark text-white' : '' }}" href="{{ route('offices') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-house-user text-success text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Offices</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'office-sections' ? 'active bg-dark text-white' : '' }}" href="{{ route('office-sections') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-table text-danger text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Sections</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'office-accounts' ? 'active bg-dark text-white' : '' }}" href="{{ route('office-accounts') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-users-cog text-info text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">Office Accounts</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'user-accounts' ? 'active bg-dark text-white' : '' }}" href="{{ route('user-accounts') }}">
                        <div
                            class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-user-check text-warning text-sm opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1">User Accounts</span>
                    </a>
                </li>
            </ul>
        </div>
    @endif

    @if(Auth::user()->role == 2)
    <div class="collapse navbar-collapse  w-auto h-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'office-dashboard' ? 'active bg-dark text-white' : '' }}" href="{{ route('office-dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'archives' ? 'active bg-dark text-white' : '' }}" href="{{ route('archives') }}">
                    <div
                        class="icon icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fa-solid fa-box-archive text-success text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Archives</span>
                </a>
            </li>
        </ul>
    </div>
    @endif

    @if(Auth::user()->role == 3)
    <div class="collapse navbar-collapse  w-auto h-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a wire:navigate class="nav-link {{ Route::currentRouteName() == 'user-dashboard' ? 'active bg-dark text-white' : '' }}" href="{{ route('user-dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <hr class="horizontal dark">
            <li class="nav-item">
                <h6 class="text-xs ms-4">Offices</h6>
            </li>
           
            @foreach ($offices as $of)
                <li class="nav-item">
                    <a wire:navigate class="nav-link {{ Request::url() == route('directory-offices', $aes->encrypt($of->officeID)) ? 'active bg-dark text-white fw-normal' : '' }}"
                        href="{{ route('directory-offices', ['id' => $aes->encrypt($of->officeID)]) }}?key={{ \Str::random(50) }}">
                        <div
                            class="icon icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase text-sm text-success opacity-10"></i>
                        </div>
                        <span class="nav-link-text ms-1 text-wrap text-xs ">{{ $of->Office->office }}</span>
                        @php
                            $tracker = Tracker::where(['officeID' => $of->officeID])->get();
                            $documents = Documents::where(['officeID' => $of->officeID])->where(['status' => 1])->get();
                        @endphp
                        @php
                            $dataID = $aes->encrypt($of->officeID);
                        @endphp
                        @include('data.count-data')
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif
</aside>
