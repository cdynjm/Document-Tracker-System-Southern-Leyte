<table class="table table-hover align-items-center mb-0" id="document-data-result">
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
            @foreach ($tracker as $tr)
                @if ($tr->trackerID == $doc->trackerID && $tr->sectionID == auth()->user()->sectionID)
                    <tr>
                        <td class="text-center text-sm"
                        id="{{ $aes->encrypt($doc->id) }}"
                        officeID="{{ $aes->encrypt($offices->id) }}"
                        dataID="{{ $aes->encrypt($offices->id) }}"
                        >
                        <input type="checkbox" class="childCheckbox me-2" value="{{ $aes->encrypt($doc->id) }}">
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
                            <span class="text-xs fw-bold text-danger text-start">
                                @if($doc->remarks != null)
                                    {!! $doc->remarks !!}
                                @else
                                    <span class="text-secondary">-</span>
                                @endif
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="javascript:;" id="reject-document" title="Reject/Return" class="text-secondary font-weight-bold text-xs me-2"
                                data-toggle="tooltip">
                                <i class="fa-regular fa-circle-left text-lg"></i>
                            </a>
                            <a href="javascript:;" id="forward-document" class="text-secondary fw-bolder text-xs me-2" title="Forward"
                                data-toggle="tooltip">
                                <i class="fas fa-paper-plane text-sm"></i>
                            </a>
                        </td>
                    </tr>
                    @php
                        $count += 1;
                    @endphp
                @endif
             @endforeach
        @endforeach
    </tbody>
</table>