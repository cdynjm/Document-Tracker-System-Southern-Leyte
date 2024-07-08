@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('modals.office.scanner-modal')
@extends('modals.office.generate-qrcode-modal')
@extends('modals.office.print-selected-qrcode-modal')
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                
                <button class="btn bg-dark text-white fw-normal me-2" id="add-qrcode"><i class="fas fa-qrcode text-sm me-1"></i> Generate QR Code</button>
                <button class="btn bg-gradient-danger text-white fw-normal" id="startScanBtn"><i class="fas fa-camera-retro text-sm me-1"></i> Scan QR Code</button>
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-danger">Document Tracker</h5>
                            </div>
                            <!-- <a href="javascript:;" id="print-qrcode" class="text-sm text-danger"><i class="fas fa-print me-1"></i> Print QR Code</a> -->
                        </div>
                        <div class="mt-2">
                            <label for="" class="text-secondary fw-normal">Select All</label>
                            <input type="checkbox" class="me-2" id="masterCheckbox">
                            <a href="javascript:;" id="forward-selected-document" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fas fa-paper-plane text-sm me-1"></i> Forward
                            </a>
                            <a href="javascript:;" id="print-selected-qrcode" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fas fa-print text-sm me-1"></i> Print QR
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            @include('data.document-tracker-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

@push('scripts')
    
@endpush