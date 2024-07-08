<!-- The Modal -->
<div class="modal fade" id="createUserAccountModal" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">New User Account</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="create-user-account" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Name</label>
                                <input type="text" class="form-control mb-2" name="name" required>

                                <label for="">Office Section</label>
                                <select name="section" id="" class="form-select mb-2" required>
                                    <option value="">Select...</option>
                                    @foreach ($offices as $of)
                                        <optgroup label="{{ $of->office }}">
                                            @foreach ($sections as $sec)
                                                @if($sec->officeID == $of->id)
                                                    <option value="{{ $aes->encrypt($sec->id) }}">{{ $sec->section }}</option>
                                                @endif
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>

                                <label for="">Email</label>
                                <input type="email" class="form-control mb-2" name="email" required>

                                <label for="">Password</label>
                                <input type="password" class="form-control mb-2" name="password" required>

                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
