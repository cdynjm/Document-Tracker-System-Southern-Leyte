<div>
   <div wire:poll.visible.10s="fetchRecentLogs">
    <table class="table table-hover align-items-center mb-0" id="archives-data-result">
        <thead>
            <tr>
                <th class="text-uppercase text-center text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                    #</th>
                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Name</th>
                
                <th
                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Logged On</th>
            </tr>
        </thead>
        <tbody>
            @php
                $count = 1;
            @endphp
            @foreach ($recentLogs as $rl)
                <tr>
                    <td class="text-center text-xs">{{ $count }}</td>
                    <td class="text-sm fw-bold">{{ $rl->User->name }}</td>
                    
                    <td class="text-xs text-center">{{ date('M. d, Y | h:i A', strtotime($rl->updated_at)) }}</td>
                </tr>
                @php
                    $count += 1;
                @endphp
            @endforeach
        </tbody>
    </table>
   </div>
</div>
