<div class="mb-3">
    <label class="form-label">Upload Portfolio (up to 6 images):</label>

    <div id="drop-zone-wrapper" class="row g-3">
        <?php for ($i = 0; $i < 6; $i++): ?>
            <div class="col-6 col-md-4">
                <div class="drop-zone border rounded shadow-sm d-flex align-items-center justify-content-center text-muted text-center" data-index="<?= $i ?>">
                    <small>Drop Image</small>
                    <input type="file" accept="image/*" class="d-none" name="portfolio[<?= $i ?>]">
                </div>
            </div>
        <?php endfor; ?>
    </div>
</div>