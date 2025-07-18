<?php declare(strict_types=1);
namespace Mlab\Mailer\Http\Controller;

use Mlab\Mailer\Facade\Mailer;
use Mlab\Mailer\Http\Controller\Controller;
use Mlab\Mailer\Views\Mails\ContactView;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class SendMailController extends Controller {

    public function sendEmail(Request $request, Response $response): Response {

        $body = $request->getParsedBody();

        if (!isset($body['to'], $body['subject'], $body['message'], $body['name'])) {
            return response(['error' => 'Missing required fields: to, subject, message, name'], 400);
        }

        $to = $body['to'];
        $subject = $body['subject'];
        $message = $body['message'];
        $username = $body['name'];

        $view = new ContactView();
        $view->setData([
            'name' => $username,
            'email' => $to,
            'message' => $message
        ]);

        try {
        Mailer::sendEmail(env('MAIL_ADMIN_ADDRESS'), $subject, $view);
        } catch (\Exception $e) {
            return response(['error' => 'Failed to send email: ' . $e->getMessage()], 500);
        }

        return response(['message' => 'Email sent successfully'], 200);
    }
    
}