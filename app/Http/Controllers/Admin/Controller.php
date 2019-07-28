<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as ParentController;
use Log;

abstract class Controller extends ParentController
{
    protected $logger;

    protected function getLogger()
    {
        if (!$this->logger) {
            $this->logger = Log::channel('admin');
        }

        return $this->logger;
    }
}
