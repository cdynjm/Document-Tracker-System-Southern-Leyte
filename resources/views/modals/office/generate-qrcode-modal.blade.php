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
                        <label for="">Number of QR Code/s</label>
                        <input type="number" class="form-control" step="1" min="1" value="1" name="quantity" required>
                        <label for="">Additional Information</label>
                        <input type="text" class="form-control" step="1" min="1" name="extension" required>
                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn btn-sm bg-dark text-white">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
