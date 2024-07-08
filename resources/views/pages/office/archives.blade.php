@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Archives'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                
                <button class="btn bg-gradient-danger text-white fw-normal" id="startScanArchiveBtn"><i class="fas fa-camera-retro text-sm me-1"></i> Scan QR Code</button>
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-success">Documents</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-4">
                            @include('data.archives-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection
