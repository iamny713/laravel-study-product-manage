<?php

namespace App\Listeners;

use App\Events\ProductCreatedEvent;

class ProductCreatedEventHandler
{
    public function handle(ProductCreatedEvent $event)
    {
        $product = $event->getProduct();

        \Log::debug('ProductCreatedEvent', [
            'productId' => $product->id,
            'productName' => $product->name,
        ]);
    }
}
