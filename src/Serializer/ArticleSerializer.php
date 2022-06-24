<?php

namespace App\Serializer;

use App\Entity\Article;
use App\Service\Formatter\ApplyFormatters;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ArticleSerializer implements ContextAwareNormalizerInterface
{
    public function __construct(
        private ObjectNormalizer $normalizer,
        private ApplyFormatters $applyFormatters
    ) {
    }

    public function normalize($article, string $format = null, array $context = []): array|string|int|float|bool|null
    {
        $data = $this->normalizer->normalize($article, $format, $context);
        if (isset($data['image'])) {
            $data['image'] = 'https://s3/' . $data['image'];
        }
        if (isset($data['body'])) {
            $data['body'] = ($this->applyFormatters)($data['body']);
        }
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof Article;
    }
}
