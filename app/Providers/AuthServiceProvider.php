<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Garastavoklis;
use App\Policies\GarastavoklisPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Garastavoklis::class => GarastavoklisPolicy::class,
        // Pievieno arī citas Policy, ja vajag
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        // Ja vajag, te vari pievienot custom Gate definīcijas
    }
}
