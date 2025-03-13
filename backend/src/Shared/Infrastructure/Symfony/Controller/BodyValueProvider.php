<?php

namespace Core\Shared\Infrastructure\Symfony\Controller;
use Core\Shared\Domain\PrimitiveExtractor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class BodyValueProvider implements ValueResolverInterface
{
    private const ARGUMENT_NAME = 'body';

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return $argument->getType() === PrimitiveExtractor::class
            && $argument->getName() === self::ARGUMENT_NAME;
    }

    /** @return iterable<int, PrimitiveExtractor> */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (!$this->supports($request, $argument)) {
            return;
        }

        $body = json_decode($request->getContent(), true);
        if(!is_array($body)) {
            throw new \RuntimeException('The body of the request is not JSON or cannot be obtained');
        }

        yield new PrimitiveExtractor($body);
    }
}
