<?php

declare(strict_types=1);

namespace PHPUnit\Architecture\Filters;

use PHPUnit\Architecture\Contracts\FilterContract;
use PHPUnit\Architecture\Elements\ObjectDescription;

final class NamespaceStartFilter implements FilterContract
{
    public array $starts;

    /**
     * @param string[]|string $starts
     */
    public function __construct($starts)
    {
        $starts = is_array($starts) ? $starts : [$starts];

        $this->starts = array_map(static function (string $line): array {
            return [$line, strlen($line)];
        }, $starts);
    }

    public function check(ObjectDescription $objectDescription): bool
    {
        foreach ($this->starts as list($line, $length)) {
            /** @var int $length */
            if (substr($objectDescription->name, 0, $length) === $line) {
                return true;
            }
        }

        return false;
    }
}
