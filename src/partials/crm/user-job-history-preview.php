<?php

/* TODO(968651491c00): Forgot to move sorting to api this is covers for it*/
$sorted = $data;
usort($sorted, function($a, $b) {
    $aTime = $a['createdAt']['_seconds'] ?? 0;
    $bTime = $b['createdAt']['_seconds'] ?? 0;
    return $bTime - $aTime; // Descending order (newest first)
});

$histories = array_slice($sorted ?? [], 0, 5);


function getStatusClass(string $status): string {
    return match(strtolower($status)) {
        'completed' => 'bg-success',
        'open'   => 'bg-warning text-dark',
        'cancelled' => 'bg-danger',
        default     => 'bg-light text-dark',
    };
}

$maxDescLen = 25;
?>

<table class="table table-striped table-hover" id="job-history-preview">
    <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Created At</th>
            <th>Start Date</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($histories)): ?>
            <tr>
                <td colspan="4" style="text-align: center;">No job requests available</td>
            </tr>
        <?php else: ?>
            <?php foreach ($histories as $job): ?>
                <tr>
                    <td><?= htmlspecialchars($job['name']) ?></td>
                    <td>
                        <?=
                        strlen($job['description']) > $maxDescLen
                        ? htmlspecialchars(substr($job["description"],0, $maxDescLen)."...")
                        : htmlspecialchars($job["description"])
                        ?>
                    </td>

                    <td>
                        <?php
                        $timestamp = $job['createdAt']['_seconds'] ?? null;
                        echo $timestamp
                            ? date('d M, Y', $timestamp)
                            : '—';
                        ?>
                    </td>
                    <td>
                        <?php
                        $timestamp = $job['startTime']['_seconds'] ?? null;
                        echo $timestamp
                            ? date('d M, Y', $timestamp)
                            : '—';
                        ?>
                    </td>
                    <td>
                        <span class="badge <?= getStatusClass($job["status"]) ?> rounded-pill">
                            <?= htmlspecialchars($job['status']) ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>
