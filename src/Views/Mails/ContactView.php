<?php
namespace Mlab\Mailer\Views\Mails;

use MLAB\SdkMailer\View\Mail;
use MLAB\SdkMailer\View\Render\View;

final class ContactView extends Mail {

    const PATH = __DIR__ . '/../../../resources/Templates/';

    public function __construct()
    {
        parent::__construct(self::PATH);
        $this->setTemplate('contact.twig');
    }

    public function setData($data): View
    {
        if(!$this->validateData($data)) {
            throw new \InvalidArgumentException('Invalid data provided for contact view.');
        }
        
        $this->data = $data;
        return $this;
    }

    private function validateData(array $data): bool
    {
        return isset($data['name'], $data['email'], $data['message']) &&
               filter_var($data['email'], FILTER_VALIDATE_EMAIL) &&
               !empty($data['message']);
    }

}