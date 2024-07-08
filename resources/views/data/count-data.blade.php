<span class="count-data-result" data-id="{{ $dataID }}">
    @php
        $count = 0;
    @endphp
    @foreach ($documents as $doc)
        @foreach ($tracker as $tr)
            @if ($tr->trackerID == $doc->trackerID && $tr->sectionID == auth()->user()->sectionID)
                @php
                    $count += 1;
                @endphp
            @endif
        @endforeach
    @endforeach
    @if($count != 0)
        <span class="badge bg-danger">
            {{ $count }}
        </span>
    @endif
</span>