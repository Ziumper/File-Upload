<?php

namespace App\Dto;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class UploadEntryDto {

    public function __construct(
        #[Assert\NotBlank(message:"Field name is blank")]
        public readonly string $name,
        #[Assert\NotBlank(message:"Field surname is blank")]
        public readonly string $surname,
        #[Assert\File(maxSize:"2M",  extensions: ['jpg','png','gif','jpeg'])]
        public readonly ?UploadedFile $file = null
    ) {
    }
}