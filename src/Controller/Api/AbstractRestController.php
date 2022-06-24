<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;

class AbstractRestController extends AbstractFOSRestController
{
    protected function createView(mixed $data, array $groups, int $statusCode = 200): View
    {
        $view = View::create($data, $statusCode);
        $view->getContext()->setGroups(array_merge(['api_response'], $groups));
        return $view;
    }
}
