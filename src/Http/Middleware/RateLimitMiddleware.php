<?php
namespace Mlab\Mailer\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class RateLimitMiddleware implements MiddlewareInterface
{
    private $limit;
    private $window;
    private $storage;

    public function __construct(int $limit = 100, int $window = 60)
    {
        $this->limit = $limit; // max requests
        $this->window = $window; // seconds
        $this->storage = []; // simple in-memory storage
    }

    public function process(Request $request, Handler $handler): ResponseInterface
    {
        $ip = $request->getServerParams()['REMOTE_ADDR'] ?? 'unknown';
        $now = time();

        if (!isset($this->storage[$ip])) {
            $this->storage[$ip] = [
                'count' => 1,
                'start' => $now
            ];
        } else {
            $data = $this->storage[$ip];
            if ($now - $data['start'] > $this->window) {
                $this->storage[$ip] = [
                    'count' => 1,
                    'start' => $now
                ];
            } else {
                $this->storage[$ip]['count']++;
            }
        }

        if ($this->storage[$ip]['count'] > $this->limit) {
            $response = new Response();
            $response = $response->withStatus(429);
            $response->getBody()->write('Rate limit exceeded');
            return $response;
        }

        return $handler->handle($request);
    }
}