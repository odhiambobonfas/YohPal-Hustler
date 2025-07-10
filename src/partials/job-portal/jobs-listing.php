<?php include "partials/job-portal/generic-topbar.php" ?>

<div class="card bg-transparent border-0 mb-4">
    <!-- Card Header -->
    <div class="card-header bg-white d-flex align-items-center justify-content-between border-0">
        <div class="d-flex bg-transparent d-flex align-items-center justify-content-between">
            <button class="btn btn-md btn-link me-2 text-nowrap backBtn" id="backBtn">
                <i class="bi bi-arrow-left"></i>
            </button>
            <ul class="nav nav-tabs border-0 subcategory-scroll d-flex overflow-auto flex-nowrap">
                <?php
                $index = 0;
                foreach ($viewableSubCategories as $category): ?>
                    <li class="nav-item tab <?= $index++ === 0 ? 'active' : '' ?> text-dark text-nowrap sub-category-tab nav-tab-<?= htmlspecialchars(str_replace(' ', '-', $category['id'])) ?>">
                        <?= htmlspecialchars($category['name']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <!-- Card Body -->
    <div class="card-body p-0 m-0 g-0 mt-3">
        <ul class="list-group bg-transparent mb-2">
            <?php foreach ($viewableSubCategories as $category): ?>
                <li class="list-group-item p-0 border-0 mb-3">
                    <!-- Subcategory header with collapse toggle -->
                    <button class="btn btn-link text-decoration-none w-100 text-start d-flex justify-content-between align-items-center p-3" data-bs-toggle="collapse"
                        data-bs-target="#subcat-<?= htmlspecialchars(str_replace(' ', '-', $category['id'])) ?>">
                        <div class="d-flex align-items-center justify-content-center">
                            <span class="subcat-symbol d-flex align-items-center justify-content-center me-2">
                                <i class="<?= htmlspecialchars($category['icon']) ?> actual-icon m-0"></i>
                            </span>
                            <strong class="text-dark"><?= htmlspecialchars($category['name']) ?></strong>
                        </div>

                        <div class="col-2 d-flex justify-content-around align-items-center text-dark">
                            <span class="job-roles-count"><?= count($category['jobs']) ?> Job Roles</span>
                            <i class="fas fa-chevron-down collapse-icon"></i>
                        </div>
                    </button>

                    <!-- Jobs list (collapsible) -->
                    <div class="collapse dropdown-content" id="subcat-<?= htmlspecialchars(str_replace(' ', '-', $category['id'])) ?>">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($category['jobs'] as $job): ?>
                                <li data-id="<?= htmlspecialchars(isset($job['id']) ? $job['id'] : strtolower($job['name'])) ?>" class="list-group-item job-list-group bg-transparent d-flex align-items-center ps-5 py-2">
                                    <span class="subcat-symbol d-flex align-items-center justify-content-center me-2">
                                        <i class="<?= htmlspecialchars($job['icon']) ?> actual-icon m-0"></i>
                                    </span>
                                    <span class="text-dark"><?= htmlspecialchars($job['name']) ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>