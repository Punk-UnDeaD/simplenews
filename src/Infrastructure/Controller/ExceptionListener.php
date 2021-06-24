<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Infrastructure\ReadModel\ReadModelNotFoundException;
use App\Infrastructure\Repository\EntityNotFoundException;
use App\Infrastructure\UseCase\ValidationException;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

#[AutoconfigureTag('kernel.event_listener', ['event' => 'kernel.exception', 'priority' => 5000])]
class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof AccessDeniedException) {
            $event->setResponse(
                new JsonResponse('', 401, ['WWW-Authenticate' => 'Basic rеаlm="Страница аутентификации"'])
            );

            return;
        }

        if ('json' === $event->getRequest()->getRequestFormat()) {
            $data = ['status' => 'error', 'message' => $exception->getMessage()];
            $headers = ['Content-type' => 'application/json'];
            switch (true) {
                case $exception instanceof ReadModelNotFoundException:
                case $exception instanceof EntityNotFoundException:
                    $code = 404;
                    break;
                case $exception instanceof ValidationException:
                    $code = 400;
                    $data['message'] = 'Validation error.';
                    $violations = $exception->getViolations();
                    foreach ($violations as $violation) {
                        $data['errors'][] = [
                            'propertyPath' => $violation->getPropertyPath(),
                            'message'      => $violation->getMessageTemplate(),
                            'parameters'   => $violation->getParameters(),
                        ];
                    }
                    break;
                case $exception instanceof HttpException:
                    $code = $exception->getStatusCode();
                    $headers = $exception->getHeaders();
                    break;
                default:
                    //$data['message'] = 'Application unavailable.';
                    $code = 500;
            }
            $event->setResponse(new JsonResponse($data, $code, $headers));
        }
    }
}
