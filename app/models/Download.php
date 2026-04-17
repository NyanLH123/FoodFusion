<?php

declare(strict_types=1);

class Download extends Model
{
    protected string $table      = 'downloads';
    protected string $primaryKey = 'resourceId';

    // Log or update a download record
    public function logDownload(int $resourceId, int $userId): void
    {
        $this->query(
            'INSERT INTO downloads (resourceId, userId, downloaded, downloaded_at)
             VALUES (:resourceId, :userId, 1, NOW())
             ON DUPLICATE KEY UPDATE downloaded = 1, downloaded_at = NOW()',
            ['resourceId' => $resourceId, 'userId' => $userId]
        );
    }
}
