<table class="table table-hover align-items-center mb-0" id="user-account-data-result">
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
    @foreach ($userAccounts as $ua)
        <tr>
         <td class="text-center text-sm"
         id="{{ $aes->encrypt($ua->id) }}"
         name="{{ $ua->name }}"
         section="{{ $aes->encrypt($ua->sectionID) }}"
         email="{{ $ua->email }}"
         >{{ $count }}</td>
         <td>
             <div class="d-flex px-2 py-1">
                 <div>
                     <img src="https://img.freepik.com/premium-vector/anonymous-user-circle-icon-vector-illustration-flat-style-with-long-shadow_520826-1931.jpg" class="avatar avatar-sm me-3"
                         alt="user1">
                 </div>
                 <div class="d-flex flex-column justify-content-center">
                     <a>
                         <h6 class="mb-0 text-sm">{{$ua->name }}</h6>
                         <p class="text-xs text-secondary mb-0">{{ $ua->email }}</p>
                     </a>
                 </div>
             </div>
         </td>
         <td>
            <a>
                <h6 class="mb-1 mt-1 text-sm">{{ $ua->Section->Office->office }}</h6>
                <p class="text-sm text-secondary mb-0">{{ $ua->Section->section }}</p>
            </a>
         </td>
         <td class="text-center">
             <a href="javascript:;" id="edit-user-account" class="text-secondary font-weight-bold text-xs me-2"
                 data-toggle="tooltip">
                 <i class="fas fa-pen-alt text-sm"></i>
             </a>
             <a href="javascript:;" id="delete-user-account" class="text-secondary font-weight-bold text-xs"
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