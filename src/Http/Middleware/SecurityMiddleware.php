<?php
namespace Mlab\Mailer\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class SecurityMiddleware implements MiddlewareInterface
{
    private array $whitelist;

    public function __construct()
    {
        // Load whitelist from env, comma separated
        $whitelist = env('IP_WHITELIST') ?: '';
        $this->whitelist = array_map('trim', explode(',', $whitelist));
    }

    public function process(Request $request, Handler $handler): ResponseInterface
    {
        $ip = $request->getServerParams()['REMOTE_ADDR'] ?? '';

        if (!in_array($ip, $this->whitelist, true)) {
            $response = new Response();
            $response->getBody()->write('Forbidden: IP not allowed.');
            return $response->withStatus(403);
        }

        return $handler->handle($request);
    }
}