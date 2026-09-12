<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $testStorage = '/tmp/project_tkj_storage';
        if (! is_dir($testStorage)) {
            @mkdir($testStorage, 0777, true);
        }
        $this->app->useStoragePath($testStorage);
    }
}
