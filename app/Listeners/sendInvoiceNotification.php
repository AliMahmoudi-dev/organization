<?php

namespace App\Listeners;

use App\Events\InvoiceStatusChanged;
use Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class sendInvoiceNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(InvoiceStatusChanged $event): void
    {
        $mailable = $this->mailableFactory($event->status);

        if (!empty($event->message)) {
            $mailable->setMessage($event->message);
        };

        Mail::to($event->invoice->user)->send($mailable);
    }

    private function mailableFactory($status)
    {
        $className = 'App\Mail\\' . $this->kebabCaseToCamelCase($status);

        if (class_exists($className)) {
            return new $className();
        };

        throw new Exception("Mailable \"$className\" not found");
    }

    private function kebabCaseToCamelCase($kebabCase)
    {
        $camelCase = '';

        foreach (explode('-', $kebabCase) as $slice) {
            $camelCase .= ucfirst($slice);
        };

        return $camelCase;
    }
}
