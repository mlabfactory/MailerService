<?php
namespace Mlab\Mailer\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class SecurityMiddleware implements MiddlewareInterface
{
    private string $apiSecret;

    public function __construct()
    {
        // Carica il segreto dall'env
        $this->apiSecret = env('API_SECRET') ?: '';
    }

    public function process(Request $request, Handler $handler): ResponseInterface
    {
        $headerSecret = $request->getHeaderLine('x-api-secret');
        die;
        if ($headerSecret !== $this->apiSecret || empty($this->apiSecret)) {
            $response = new Response();
            $response->getBody()->write('Forbidden: Invalid API secret.');
            return $response->withStatus(403);
        }
        return $handler->handle($request);
    }
}