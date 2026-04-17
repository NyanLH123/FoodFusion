<?php

declare(strict_types=1);

class Resource extends Model
{
    protected string $table      = 'resources';
    protected string $primaryKey = 'resourceId';

    // Culinary resources: pdf, video, image
    public function culinary(): array
    {
        return $this->query(
            "SELECT * FROM resources WHERE type IN ('pdf','video','image') ORDER BY uploaded_at DESC"
        )->fetchAll();
    }

    // Educational resources: infographic, video
    public function educational(): array
    {
        return $this->query(
            "SELECT * FROM resources WHERE type IN ('infographic','video') ORDER BY uploaded_at DESC"
        )->fetchAll();
    }
}
