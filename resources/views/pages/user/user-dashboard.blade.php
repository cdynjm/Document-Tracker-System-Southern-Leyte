@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Illuminate\Support\Str;
    use App\Http\Controllers\AESCipher;
    $aes = new AESCipher();
@endphp

@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dashboard'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <div id="clock" class="clock fs-1 fw-bold ms-auto">
                    <span id="hours">00</span>:<span id="minutes">00</span>:<span id="seconds">00</span> <span id="ampm">AM</span>
                </div>
                <div id="date" class="date fs-6 fw-normal ms-auto mb-3"></div>
            </div>
            <script>
                function updateClock() {
                    const now = new Date();
                    let hours = now.getHours();
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    const seconds = String(now.getSeconds()).padStart(2, '0');
                    const ampm = hours >= 12 ? 'PM' : 'AM';
            
                    hours = hours % 12;
                    hours = hours ? hours : 12;
                    hours = String(hours).padStart(2, '0');
            
                    document.getElementById('hours').textContent = hours;
                    document.getElementById('minutes').textContent = minutes;
                    document.getElementById('seconds').textContent = seconds;
                    document.getElementById('ampm').textContent = ampm;
                }
            
                function updateDate() {
                    const now = new Date();
                    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                    const formattedDate = now.toLocaleDateString(undefined, options);
                    document.getElementById('date').textContent = formattedDate;
                }
            
                updateClock();
                updateDate();
                setInterval(updateClock, 1000);
                setInterval(updateDate, 60000);  // Update date every minute
            </script>
            <div class="col-md-12">
                <div class="card border-radius-md">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-2 text-sm text-success">Document Received Logs</h5>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <hr class="mx-4 mb-0">
                        <div class="table-responsive p-4">
                            @include('data.received-logs-data')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection

