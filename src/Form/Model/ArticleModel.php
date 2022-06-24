<?php

namespace App\Form\Model;

use App\Entity\Category;
use App\Validator\Constraints\TitleHasB;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleModel
{
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'The title must be at least {{ limit }} characters long',
        maxMessage: 'The title cannot be longer than {{ limit }} characters',
    )]
    #[TitleHasB()]
    public ?string $title;

    public function __construct(
        ?string $title = null,
        public ?string $body = null,
        public ?bool $isPublished = null,
        public ?Category $category = null,
        public ?bool $aggreeTerms = null
    ) {
        $this->title = $title;
    }
}
