<table class="table table-hover align-items-center mb-0" id="document-tracker-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Code</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Current Location</th>
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
            @include('modals.office.print-qrcode-modal')
            <tr>
            <td class="text-end text-sm"
            id="{{ $aes->encrypt($doc->id) }}"
            qrcode="{{ $doc->qrcode }}"
            >
            @if($doc->trackerID == 0)
                <input type="checkbox" class="childCheckbox me-2" value="{{ $aes->encrypt($doc->id) }}">
                <input type="checkbox" class="childCheckboxHidden  me-2" data-name="{{ $doc->qrcode }}" value="{{ $doc->qrcode }}" hidden>
            @endif
            <span class="">{{ $count }}</span>
            </td>
            <td>
                <div class="d-flex px-2 py-1">
                    <div class="me-2" id="print-qrcode">
                        {!! QrCode::size(35)->generate($doc->qrcode) !!}
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <a>
                            <h6 class="mb-0 text-sm">{{ $doc->qrcode }}</h6>
                        </a>
                    </div>
                </div>
            </td>
            <td class="text-wrap">
                    @if($doc->trackerID != 0)
                        @foreach($tracker as $tr)
                            @if($tr->trackerID == $doc->trackerID)
                            <div class="d-flex flex-column mt-2 justify-content-center">
                                <a>
                                    <h6 class="mb-0 text-sm"><i class="fas fa-paper-plane"></i><span class="ms-1">{{ $tr->Section->Office->office }}</span></h6>
                                    <p class="text-sm">{{ $tr->Section->section }}</p>
                                </a>
                            </div>
                            @endif
                        @endforeach
                    @else
                    <span class="text-xs fw-bold text-danger">
                        <span class="me-2"><i class="fas fa-minus-circle"></i></span>Currently at your Office
                    </span>
                    @endif
            </td>
            <td class="text-center">
                <span class="text-xs fw-bold">
                    {{ date('M. d, Y | h:i A', strtotime($doc->updated_at)) }}
                </span>
            </td>
            <td class="text-wrap text-center">
                <span class="text-xs fw-bold text-danger text-start">
                    @if($doc->remarks != null)
                        {!! $doc->remarks !!}
                    @else
                        <span class="text-secondary">-</span>
                    @endif
                </span>
            </td>
            <td class="text-center">
                @if($doc->trackerID == 0)
                    <a href="javascript:;" id="forward-document" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                        data-toggle="tooltip">
                        <i class="fas fa-paper-plane text-sm"></i>
                    </a>
                @endif
                <a wire:navigate title="View" href="{{ route('office-document-tracker', ['id' => $aes->encrypt($doc->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2"
                    data-toggle="tooltip">
                    <i class="fas fa-eye text-sm"></i>
                </a>
                @if($doc->trackerID == 0)
                <a href="javascript:;" id="delete-qrcode" title="Delete" class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip">
                    <i class="fas fa-trash-alt text-sm"></i>
                </a>
                @endif
            </td>
            </tr>
            @php
                $count += 1;
            @endphp
        @endforeach
    </tbody>
</table>