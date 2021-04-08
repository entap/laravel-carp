<?php
namespace Entap\Laravel\Carp;

use Illuminate\Contracts\Routing\Registrar as Router;

class RouteRegistrar
{
    /**
     * The router implementation.
     *
     * @var \Illuminate\Contracts\Routing\Registrar
     */
    protected $router;

    /**
     * Create a new route registrar instance.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     * @return void
     */
    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->router->get('/packages/{package:name}/releases/latest', [
            'uses' => 'LatestReleaseController@show',
            'as' => 'carp.releases.latest',
        ]);

        $this->router->get('/packages/{package:name}/releases/{releaseName}', [
            'uses' => 'ReleaseController@show',
            'as' => 'carp.releases.show',
        ]);
    }
}
