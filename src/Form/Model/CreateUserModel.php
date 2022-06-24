<?php

namespace App\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserModel
{
    #[Assert\Email()]
    public ?string $email;

    public function __construct(
        ?string $email = null,
        public ?string $password = null
    ) {
        $this->email = $email;
    }
}
