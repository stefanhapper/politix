<?php

require_once __DIR__.'/../app/bootstrap.php.cache';
require_once __DIR__.'/../app/AppKernel.php';

/* cache turned on */
require_once __DIR__.'/../app/AppCache.php';

use Symfony\Component\HttpFoundation\Request;

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();

/* yes, cache turned on */
$kernel = new AppCache($kernel);

$kernel->handle(Request::createFromGlobals())->send();
