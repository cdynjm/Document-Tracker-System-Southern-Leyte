<!-- The Modal -->
<div class="modal fade" id="generateQRCodeModal" aria-hidden="true" style="display: none;" >
    <div class="modal-dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">Generate QR Code/s</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">  
                    <form action="" id="generate-qrcode" enctype="multipart/form-data">
                        <label for="">Quantity</label>
                        <select name="quantity" id="" class="form-select" required>
                            <option value="">Select...</option>
                            @php
                                $range = range(1,10);
                            @endphp
                            @foreach ($range as $rn)
                                <option value="{{ $rn }}">{{ $rn }}</option>
                            @endforeach
                        </select>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
