<?php

namespace App\Dto;

class ReturnUploadEntryDto {
    
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly string $fileName
    ) {}
    
}
