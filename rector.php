<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->sets([
        \Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_100,
        \Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_74,
    ]);
};
