<?php

declare(strict_types=1);

namespace App\Model\Article;

use Exception;

final class ArticleNotFound extends Exception
{

    public function __construct(int $id)
    {
        parent::__construct(
            sprintf('The article <%d> does not exist', $id)
        );
    }
}
