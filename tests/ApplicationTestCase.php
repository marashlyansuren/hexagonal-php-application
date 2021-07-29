<?php

namespace App\Tests;

use App\Common\Uuid;
use PHPUnit\Framework\TestCase;

class ApplicationTestCase extends TestCase
{
    protected function getUuid(): Uuid
    {
        return new Uuid(\Symfony\Component\Uid\Uuid::v4());
    }

    protected function getCurrentDateTimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable("now");
    }
}