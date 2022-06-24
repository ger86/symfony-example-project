<?php

namespace App\Controller\Api;

use App\Form\Model\CreateUserModel;
use App\Form\Type\CreateUserFormType;
use App\Service\User\CreateUser;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations\{Post};

class UserController extends AbstractRestController
{
    #[Post(path: '/api/users')]
    public function post(CreateUser $createUser, Request $request): View
    {
        $model = new CreateUserModel();
        $form = $this->createForm(CreateUserFormType::class, $model);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = ($createUser)(
                $model->email,
                $model->password
            );
            return $this->createView($user, ['api_response'], Response::HTTP_CREATED);
        }
        return $this->createView($form, [], Response::HTTP_BAD_REQUEST);
    }
}
