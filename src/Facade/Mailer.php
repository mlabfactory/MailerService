<?php
namespace Mlab\Mailer\Facade;

class Mailer extends \Illuminate\Support\Facades\Facade
{
    /**
     * @static sendEmail(string|array $emailTo, string $subject, \MLAB\SdkMailer\View\ViewInterface $view)
     */
    /**
     * Get the registered name of the component.
     *
     * @return string
     * @see \MLAB\SdkMailer\Service\EmailService
     */
    protected static function getFacadeAccessor()
    {
        return 'mailer'; // This should match the key used in the Facade application setup
    }
}