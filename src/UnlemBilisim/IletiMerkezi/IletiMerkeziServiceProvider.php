<?php
/**
 * Created by PhpStorm.
 * User: orhangazibasli
 * Date: 23.03.2017
 * Time: 19:31
 */
namespace UnlemBilisim\IletiMerkezi;

use Illuminate\Support\ServiceProvider;

class IletiMerkeziServiceProvider extends ServiceProvider{
    public function boot()
    {
        $this->app->when(IletiMerkeziChannel::class)
            ->needs('$username')
            ->give(config('services.iletimerkezi.username'));
        $this->app->when(IletiMerkeziChannel::class)
            ->needs('$password')
            ->give(config('services.iletimerkezi.password'));
        $this->app->when(IletiMerkeziChannel::class)
            ->needs('$endpoint')
            ->give(config('services.iletimerkezi.endpoint'));
        $this->app->when(IletiMerkeziChannel::class)
            ->needs('$title')
            ->give(config('services.iletimerkezi.title'));
    }
}