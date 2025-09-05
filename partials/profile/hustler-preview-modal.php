<?php $hustler = auth()->hustler(); ?>
<div class="modal fade" id="hustlerPreviewModal" tabindex="-1" aria-labelledby="hustlerPreviewModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Public Preview</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body p-3">
        <div class="card border-0 w-100">
          <!-- Header -->
          <div
            class="card-header text-center border-bottom position-relative text-white p-0 rounded-2 overflow-hidden"
            style="background-image: url('<?= $hustler->uploads['images'][1] ?? '' ?>');
                   background-size: cover; background-position: center;
                   height: 15vh;">
            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>

            <div class="position-relative py-3" style="z-index: 2;">
              <img src="<?= $hustler->uploads['images'][0] ?? '' ?>"
                   class="rounded-circle border border-white mb-2"
                   style="width: 60px; height: 60px; object-fit: cover;" alt="Profile Picture">
              <h6 class="mb-0 fw-bold"><?= htmlspecialchars($hustler->displayName ?? 'N/A') ?></h6>
              <small><?= htmlspecialchars($hustler->primarySkill ?? 'N/A') ?></small>
            </div>
          </div>

          <!-- Body -->
          <div class="card-body">
            <div class="mb-2 text-muted"><strong>Rate</strong></div>
            <div class="text-dark mb-3">
              <?= htmlspecialchars($hustler->pricing ?? 'N/A') ?>
              <span class="small">(<?= htmlspecialchars($hustler->pricingType ?? 'N/A') ?>)</span>
            </div>

            <?php if (!empty($hustler->skillRatings)): ?>
              <div class="mb-2">
                <div class="fw-semibold text-dark small mb-2">Ratings</div>
                <div class="d-flex flex-wrap gap-2">
                  <?php foreach ($hustler->skillRatings as $skill => $rating): ?>
                    <div class="px-2 py-1 text-center small text-muted" style="min-width: 80px;">
                      <div class="fw-semibold text-capitalize"><?= htmlspecialchars($skill) ?></div>
                      <div class="text-warning"><?= str_repeat('⭐', (int) $rating) ?></div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
