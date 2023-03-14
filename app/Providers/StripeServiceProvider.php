<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;


class StripeServiceProvider extends ServiceProvider
{
  public function register()
  {
    $this->app->singleton(StripeClient::class, function() {
      return new StripeClient(config('stripe.secret_key'));
    });
  }
}