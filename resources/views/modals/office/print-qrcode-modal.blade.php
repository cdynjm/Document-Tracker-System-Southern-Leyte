<!-- The Modal -->
<div class="modal fade" id="printQRCodeModal{{ $doc->qrcode }}" aria-hidden="true" style="display: none;" >
    <div class="modal-dialog">
        <div class="modal-content border-radius-md">
            <div class="modal-header">
                <h5 class="modal-title">QR Code</h5>
                <button type="button" class="btn-close bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body text-center">  
                    <div id="qrCodeContainer">
                        {!! QrCode::size(150)->generate($doc->qrcode) !!}
                        <p style="margin: 20px;">{{ $doc->qrcode }}</p>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <button id="printQRCodeButton" class="btn btn-sm bg-dark text-white">Print</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
