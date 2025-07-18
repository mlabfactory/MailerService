<?php

namespace Mlab\Test;

use Slim\Http\Interfaces\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Mlab\Mailer\Http\Controller\SendMailController;

class EmailMessageTest extends BaseCase
{

    public function test_send_email_contact()
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $payload = [
            'to' => 'test@example.com',
            'subject' => 'Test Email',
            'message' => 'This is a test email',
            'string_to_check' => ['This is a test email'],
            'user_name' => 'Test User'
        ];

        $request->method('getParsedBody')->willReturn($payload);
        $controller = new SendMailController();

        /** @var \Psr\Http\Message\ServerRequestInterface $request */
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $result = $controller->sendEmail($request, $response);

        $this->assertEquals(200, $result->getStatusCode());

        // Give MailHog time to receive the email
        sleep(1);

        $this->invokeMailhog($payload);
    }
}
