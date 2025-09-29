<div class="mb-3">
    <label for="primary_skillset" class="form-label fw-bold">Skill Set:</label>
    <select class="form-control searchSelect primary-skill-set" name="primary_skillset" id="primary_skillset">
        <?= isset($skillsetDropdownOptions) ? $skillsetDropdownOptions : null ?>
    </select>
</div>
<div class="mb-3">
    <label for="priceUnit" class="form-label fw-bold">Price Unit:</label>
    <select class="form-control searchSelect price-unit" name="priceUnit" id="priceUnit">
        <?= isset($pricingUnitsDropdownOptions) ? $pricingUnitsDropdownOptions : null ?>
    </select>
</div>
<div class="mb-3">
    <label for="price" class="form-label">Charges</label>
    <div class="input-group">
        <button class="btn btn-outline-gray"><?= $default_currency ?? 'Ksh. ' ?></button>
        <input type="number" class="form-control chargeAmount" name="chargeAmount" id="chargeAmount" value="0">
    </div>
</div>
<div class="mb-3">
    <label class="form-label fw-bold d-block">Rate Yourself:</label>

    <div class="rating-group d-flex justify-content-between align-items-center">
        <div class="rating-label">
            <label class="title fw-bold">Timelines</label>
        </div>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="checkbox" id="timelines_<?= $i ?>" name="timeliness" value="<?= $i ?>">
                <label for="timelines_<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>
    </div>

    <div class="rating-group d-flex justify-content-between align-items-center">
        <div class="rating-label">
            <label class="title fw-bold">Competence</label>
        </div>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="checkbox" id="competence_<?= $i ?>" name="competence" value="<?= $i ?>">
                <label for="competence_<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>
    </div>

    <div class="rating-group d-flex justify-content-between align-items-center">
        <div class="rating-label">
            <label class="title fw-bold">Communication</label>
        </div>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="checkbox" id="communication_<?= $i ?>" name="communication" value="<?= $i ?>">
                <label for="communication_<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>
    </div>

    <div class="rating-group d-flex justify-content-between align-items-center">
        <div class="rating-label">
            <label class="title fw-bold">Reliability</label>
        </div>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="checkbox" id="reliability_<?= $i ?>" name="reliability" value="<?= $i ?>">
                <label for="reliability_<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>
    </div>

    <div class="rating-group d-flex justify-content-between align-items-center">
        <div class="rating-label">
            <label class="title fw-bold">Problem Solving</label>
        </div>
        <div class="star-rating">
            <?php for ($i = 5; $i >= 1; $i--): ?>
                <input type="checkbox" id="problem_solving_<?= $i ?>" name="problem_solving" value="<?= $i ?>">
                <label for="problem_solving_<?= $i ?>">★</label>
            <?php endfor; ?>
        </div>
    </div>
</div>
