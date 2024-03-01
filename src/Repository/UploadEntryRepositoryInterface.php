<?php

namespace App\Repository;

use App\Entity\UploadEntry;

interface UploadEntryRepositoryInterface  {
    public function save(UploadEntry $uploadEntry): bool;
    /**
     * 
     * @return UploadEntry[] 
     */
    public function fetchAll(): array;
}