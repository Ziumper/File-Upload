<?php

namespace App\Service;

use App\Dto\UploadEntryDto;

interface UploadEntryServiceInterface {
    public function uploadEntry(UploadEntryDto $dto): bool;
}