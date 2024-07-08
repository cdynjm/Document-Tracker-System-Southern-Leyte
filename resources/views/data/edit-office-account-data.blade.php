<form action="" id="update-office-account" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $aes->encrypt($officeAccount->id) }}" class="form-control" readonly>
    <div class="row">
        <div class="col-md-6 mb-2">
            <label for="">Account Name</label>
            <input type="text" class="form-control mb-2" value="{{ $officeAccount->name }}" name="name" required>

            <label for="">Office Name</label>
            <select name="office" class="form-select mb-2" id="" required>
                <option value="">Select...</option>
                @foreach ($offices as $of)
                    <option value="{{ $aes->encrypt($of->id) }}" @if($of->id == $officeAccount->officeID) selected @endif>{{ $of->office }}</option>
                @endforeach
            </select>

            <label for="">Email</label>
            <input type="email" class="form-control mb-2" value="{{ $officeAccount->email }}" name="email" required>

            <label for="">New Password</label>
            <input type="password" class="form-control mb-2" name="password">
        </div>

        <div class="col-md-6 mb-2">

            <h6 class="mb-3">Document Tracking Process</h6>
           
            <button class="btn btn-sm bg-dark text-white" id="add-tracker" type="button"><i class="fas fa-plus"></i></button>
            <button class="btn btn-sm bg-gradient-danger text-white" id="delete-tracker" type="button"><i class="fas fa-trash"></i></button>
            
            <div id="tracker-container">
                @foreach ($tracker as $tr)
                <select name="tracker[]" id="" class="form-select mb-2" required>
                    <option value="">Select...</option>
                    @foreach ($offices as $of)
                        <optgroup label="{{ $of->office }}">
                            @foreach ($sections as $sec)
                                @if($sec->officeID == $of->id)
                                    <option value="{{ $aes->encrypt($sec->id) }}" @if($tr->sectionID == $sec->id) selected @endif>{{ $sec->section }}</option>
                                @endif
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
                @endforeach
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <button type="submit" class="btn btn-sm bg-dark text-white">Update</button>
    </div>
</form>