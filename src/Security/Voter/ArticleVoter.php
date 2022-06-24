<?php

namespace App\Security\Voter;

use App\Entity\Article;
use App\Entity\Patient\Clarification\Clarification;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ArticleVoter extends Voter
{
    public const EDIT = 'app.article.edit';
    public const DELETE = 'app.article.delete';

    protected function supports(string $attribute, $subject): bool
    {
        return $subject instanceof Article;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        if ($attribute === self::DELETE) {
            $user = $token->getUser();
            if (!$user instanceof User) {
                return false;
            }
            return $user->isAdmin();
        }
        if ($attribute === self::EDIT) {
            $user = $token->getUser();
            return $user !== null;
        }

        throw new \LogicException('This code should not be reached!');
    }
}
