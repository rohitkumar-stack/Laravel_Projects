<?php
namespace App\Models;

use App\Observers\UserObserver;
use Orchestra\Tenanti\Tenantor;
use Illuminate\Notifications\Notifiable;
use Orchestra\Tenanti\Contracts\TenantProvider;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organisation extends Authenticatable implements TenantProvider
{
    use Notifiable;

    /**
     * Convert to tenantor.
     * 
     * @return \Orchestra\Tenanti\Tenantor
     */
    public function asTenantor(): Tenantor
    {
        return Tenantor::fromEloquent('organisation', $this);
    }

    /**
     * Make a tenantor.
     *
     * @return \Orchestra\Tenanti\Tenantor
     */
    public static function makeTenantor($key, $connection = null): Tenantor
    {
        return Tenantor::make(
            'organisation', $key, $connection ?: (new static())->getConnectionName()
        );
    }

    /**
     * The "booting" method of the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::observe(new UserObserver);
    }
}
