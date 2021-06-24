<?php

declare(strict_types=1);

namespace App\Infrastructure\Psalm;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use Psalm\Codebase;
use Psalm\FileSource;
use Psalm\Plugin\Hook\AfterClassLikeVisitInterface;
use Psalm\Storage\ClassLikeStorage;
use Symfony\Contracts\Service\Attribute\Required;

class RequiredPropertyHandler implements AfterClassLikeVisitInterface
{
    public static function afterClassLikeVisit(
        ClassLike $stmt,
        ClassLikeStorage $storage,
        FileSource $statements_source,
        Codebase $codebase,
        array &$file_replacements = []
    ) {
        if (!$stmt instanceof Class_) {
            return;
        }
        $reflection = null;
        foreach ($storage->properties as $name => $property) {
            if (!empty($storage->initialized_properties[$name])) {
                continue;
            }
            foreach ($property->attributes as $attribute) {
                if (Required::class === $attribute->fq_class_name) {
                    $storage->initialized_properties[$name] = true;
                    continue 2;
                }
            }
        }
    }
}
