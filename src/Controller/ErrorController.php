<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ErrorController extends AbstractController
{
    #[Route('/error', name: 'error')]
    public function __invoke(Request $request, Throwable $exception): JsonResponse
    {
        if ($request->get('message') && $request->get('statusCode')) {
            $message = $request->get('message');
            $statusCode = (int) $request->get('statusCode');
        } else {
            if ($exception instanceof HttpExceptionInterface) {
                $statusCode = $exception->getStatusCode();
                $message = $exception->getMessage();
            } else {
                $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                $message = 'An unexpected error occurred';
            }
        }

        return new JsonResponse([
            'error' => true,
            'message' => $message,
            'status' => $statusCode
        ], $statusCode);
    }
}
