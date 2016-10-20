<?php
/**
 * Created by PhpStorm.
 * User: srapin
 * Date: 25.09.16
 * Time: 15:40
 */

namespace App\Http\Controllers;

use App\User;
use App\Notifications\InvoicePaid;
use Laravel\Cashier\Http\Controllers\WebhookController as CashierController;

class WebhookController extends CashierController
{

    /**
     * @param $payload
     * @return Response
     */
    public function handleInvoicePaymentSucceeded($payload)
    {
        $user = $this->getUserByStripeId($payload['data']['object']['customer']);
        $user->notify(new InvoicePaid($user));

        return new Response('Webhook Handled', 200);
    }
}