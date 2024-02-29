<?php

namespace App\Dto;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

class UploadEntryDto {

    public function __construct(
        #[Assert\NotBlank]
        public readonly string $name,
        #[Assert\NotBlank]
        public readonly string $surname,
        #[Assert\File(maxSize:"2M",  extensions: ['jpg','png','gif','jpeg'])]
        public readonly ?File $file = null
    ) {
    }
}