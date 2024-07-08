<div>
    <div wire:poll.visible.10s="fetchTracker">
        <div class="table-responsive p-4">
            <h6><i class="fa-solid fa-location-crosshairs text-lg text-danger"></i> Tracker</h6>
            <hr>
            @php
                $office = collect();
            @endphp

            <p class="text-sm
                @if($documents->trackerID == 0) 
                    fw-bolder current-tracker
                @endif 
                ">
                @if($documents->trackerID == 0) 
                    <i class="fa-solid fa-location-dot text-success text-lg me-2"></i> 
                @endif
                <i class="fa-solid fa-flag-checkered"></i> Department/Office |
                @foreach ($logs as $lg)
                    @if($lg->documentID == $documents->id && $lg->trackerID == 0)
                        <span class="text-xs">{{ date('M. d, Y - h:i A', strtotime($lg->updated_at)) }}</span></p>
                    @endif
                @endforeach
                <hr>
            <div class="tracker-progress">
                @foreach ($tracker as $tr)
                    @if (!$office->contains($tr->Section->Office->id))
                        <div class="office-item">
                            <p class="office-name text-sm">{{ $tr->Section->Office->office }}</p>
                            <ul class="section-list">
                    @endif
                    <li class="text-sm
                        @if($documents->trackerID == $tr->trackerID) 
                            current-tracker
                        @endif
                        "
                    > 
                    @if($documents->trackerID == $tr->trackerID)
                        <i class="fa-solid fa-location-dot text-success text-lg me-2"></i> 
                    @endif
                    {{ $tr->Section->section }}
                    
                    @foreach ($logs as $lg)
                        @if($lg->documentID == $documents->id && $lg->trackerID == $tr->trackerID)
                            | <span class="text-xs">{{ date('M. d, Y - h:i A', strtotime($lg->updated_at)) }}</span></p>
                        @endif
                    @endforeach
                    
                    <hr @if($documents->trackerID == $tr->trackerID) style="padding: 2px" @endif></li>
                    @php
                        $office->push($tr->Section->Office->id);
                    @endphp
                    @if ($loop->last || !$office->contains($tracker[$loop->index + 1]->Section->Office->id))
                            </ul>
                        </div>
                    @endif
                @endforeach
                <p class="text-sm
                @if($documents->status == 0)
                    fw-bolder text-success
                @endif
                ">
                @if($documents->status == 0)
                    <i class="fa-solid fa-circle-check text-success me-1"></i>
                @else
                    <i class="fa-solid fa-circle-minus text-danger me-1"></i>
                @endif
                Done
                @if($documents->status == 0)
                    <span class="text-normal">| {{ date('M. d, Y - h:i A', strtotime($documents->updated_at)) }}</span>
                @endif
                </p>
            </div>
        </div>
    </div>
</div>
