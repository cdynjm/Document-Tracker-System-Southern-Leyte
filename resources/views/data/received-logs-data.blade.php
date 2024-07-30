<table class="table table-hover align-items-center mb-0" id="received-logs-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Code</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                From</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Source Office</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Date & Time</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp
        @foreach ($receivedLogs as $rl)
            
                <tr>
                    <td class="text-center text-sm">
                    {{ $count }}</td>
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="me-2">
                                {!! QrCode::size(35)->generate($rl->Document->qrcode) !!}
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <a>
                                    <h6 class="mb-0 text-sm">{{ $rl->Document->qrcode }}</h6>
                                </a>
                            </div>
                        </div>
                    </td>
                
                    <td class="text-center">
                        <div class="text-center text-sm fw-bolder">
                            {{ $rl->username }}
                        </div>
                        <span class="text-xs fw-bold text-dark text-start">
                            @if($rl->officeID == null)
                                From the Source Office
                            @else
                                {{ $rl->Office->section }}
                            @endif
                        </span>
                    </td>
                    <td class="text-wrap text-center">
                        <span class="text-xs fw-bold text-success text-start">
                            {{ $rl->User->name }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="text-xs fw-bold">
                            {{ date('M. d, Y | h:i A', strtotime($rl->updated_at)) }}
                        </span>
                    </td>
                </tr>
                @php
                    $count += 1;
                @endphp
               
        @endforeach
    </tbody>
</table>