<table class="table table-hover align-items-center mb-0" id="archives-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Code</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Updated On</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Remarks</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Actions</th>
        </tr>
    </thead>
    <tbody>
        @php
            $count = 1;
        @endphp
        @foreach ($documents as $doc)
            <tr>
            <td class="text-center text-sm"
            id="{{ $aes->encrypt($doc->id) }}"
            >
            {{ $count }}</td>
            <td>
                <div class="d-flex px-2 py-1">
                    <div class="me-2">
                        {!! QrCode::size(35)->generate($doc->qrcode) !!}
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <a>
                            <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                        </a>
                    </div>
                </div>
            </td>
           
            <td class="text-center">
                <span class="text-xs fw-bold">
                    {{ date('M. d, Y | h:i A', strtotime($doc->updated_at)) }}
                </span>
            </td>
            <td class="text-wrap text-center">
                <span class="text-xs fw-bold text-success text-start">
                    @if($doc->remarks != null)
                        {!! $doc->remarks !!}
                    @else
                        <span class="text-secondary">-</span>
                    @endif
                </span>
            </td>
            <td class="text-center">
                <a wire:navigate title="View" href="{{ route('office-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2"
                    data-toggle="tooltip">
                    <i class="fas fa-eye text-sm"></i>
                </a>
            </td>
            </tr>
            @php
                $count += 1;
            @endphp
        @endforeach
    </tbody>
</table>