<div class="card bg-transparent border-0 mb-4">
    <!-- Card Header -->
    <div class="card-header bg-white d-flex align-items-center justify-content-between border-0">
        <div class="d-flex bg-light d-flex align-items-center justify-content-between">
            <button class="btn btn-sm btn-outline-danger me-2 text-nowrap">
                <i class="bi bi-arrow-left"></i> Back
            </button>
            <div class="subcategory-scroll d-flex overflow-auto flex-nowrap">
                <?php foreach ($viewableSubCategories as $category): ?>
                    <button class="btn btn-outline-danger btn-sm text-dark me-2 text-nowrap"><?= $category['name'] ?></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Card Body -->
    <div class="card-body g-0">
        <ul class="list-group bg-transparent mb-3">
            <?php foreach ($viewableSubCategories as $category): ?>
                <li class="list-group-item p-0 border-0 mb-3">
                    <!-- Subcategory header with collapse toggle -->
                    <button class="btn btn-link text-decoration-none w-100 text-start d-flex justify-content-between align-items-center p-3" data-bs-toggle="collapse"
                        data-bs-target="#subcat-<?= htmlspecialchars(str_replace(' ', '-', $category['name'])) ?>">
                        <div>
                            <i class="<?= htmlspecialchars($category['icon']) ?> me-2"></i>
                            <strong><?= htmlspecialchars($category['name']) ?></strong>
                        </div>

                        <div class="col-2 d-flex justify-content-around align-items-center">
                            <span class="job-roles-count"><?= count($category['jobs']) ?> Job Roles</span>
                            <i class="fas fa-chevron-down collapse-icon"></i>
                        </div>
                    </button>

                    <!-- Jobs list (collapsible) -->
                    <div class="collapse" id="subcat-<?= htmlspecialchars(str_replace(' ', '-', $category['name'])) ?>">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($category['jobs'] as $job): ?>
                                <li class="list-group-item d-flex align-items-center ps-5 py-2">
                                    <i class="<?= htmlspecialchars($job['icon']) ?> text-muted me-3"></i>
                                    <?= htmlspecialchars($job['name']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div> 