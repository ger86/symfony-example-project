<?php

declare(strict_types=1);

namespace App\Model\Article;

use Exception;

final class ErrorCreatingArticle extends Exception
{

    public function __construct(string $message)
    {
        parent::__construct(
            sprintf($message)
        );
    }
}
