<div class="mb-3">
    <label class="form-label">Upload National ID (Back and Front):</label>

    <div id="drop-zone-wrapper" class="row g-3 mb-3"> 
        <div class="col-6 col-md-6">
            <h6>Front Face</h6>
            <div class="drop-zone border rounded shadow-sm d-flex align-items-center justify-content-center text-muted text-center">
                <small>Drop Image</small>
                <input type="file" accept="image/*" class="d-none" name="nid_front">
            </div>
            <small class="text-muted file-name"></small>
        </div> 
        <div class="col-6 col-md-6">
            <h6>Back Face</h6>
            <div class="drop-zone border rounded shadow-sm d-flex align-items-center justify-content-center text-muted text-center">
                <small>Drop Image</small>
                <input type="file" accept="image/*" class="d-none" name="nid_back">
            </div>
            <small class="text-muted file-name"></small>
        </div> 
    </div>

    <div class="mb-3 w-100">
        <button type="submit" name="activateAccount" id="activateAccount" class="btn btn-danger btn-md btn-block activate-account float-end">Activate Your Account</button>
    </div>
</div>