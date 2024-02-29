<?php

namespace App\Resolver;

use App\Dto\UploadEntryDto;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Exception\ValidationFailedException;

class UploadEntryValueResolver implements ValueResolverInterface
{
    public function __construct(private readonly ValidatorInterface $validator,
    ) {}

    public function resolve(Request $request, ArgumentMetadata $argument): iterable 
    {
        $file = $request->files->get("file");
        $entry = new UploadEntryDto($request->get("name"),$request->get("surname"), $file); 
        $violations = $this->validator->validateProperty($entry,"name");
        $violations->addAll($this->validator->validateProperty($entry,"surname"));

        $violations->addAll($this->validator->validateProperty($entry,"file"));
        
        if (\count($violations)) {
            throw new HttpException(422, implode("\n", array_map(static fn ($e) => $e->getMessage(), iterator_to_array($violations))), new ValidationFailedException($entry, $violations));
        }
        return [$entry];
    }
}