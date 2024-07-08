<table class="table table-hover align-items-center mb-0" id="office-account-data-result">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" width="5%">
                #</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Account Name</th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Office Name</th>
            <th
                class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action</th>
        </tr>
    </thead>
    <tbody>
       @php
           $count = 1;
       @endphp
       @foreach ($officeAccounts as $oa)
           <tr>
            <td class="text-center text-sm"
            id="{{ $aes->encrypt($oa->id) }}"
            >{{ $count }}</td>
            <td>
                <div class="d-flex px-2 py-1">
                    <div>
                        <img src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" class="avatar avatar-sm me-3"
                            alt="user1">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <a>
                            <h6 class="mb-0 text-sm">{{$oa->name }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $oa->email }}</p>
                        </a>
                    </div>
                </div>
            </td>
            <td>
                <span class="text-sm fw-bold">{{$oa->Office->office }}</span>
            </td>
            <td class="text-center">
                <a wire:navigate href="{{ route('edit-office-account', ['id' => $aes->encrypt($oa->id)]) }}?key={{ \Str::random(50) }}" class="text-secondary font-weight-bold text-xs me-2"
                    data-toggle="tooltip">
                    <i class="fas fa-pen-alt text-sm"></i>
                </a>
                <a href="javascript:;" id="delete-office-account" class="text-secondary font-weight-bold text-xs"
                    data-toggle="tooltip">
                    <i class="fas fa-trash-alt text-sm"></i>
                </a>
            </td>
           </tr>
           @php
                $count += 1;
            @endphp
       @endforeach
    </tbody>
</table>