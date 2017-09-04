<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Bundle\JoseFramework\Routing;

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

final class JWKSetLoader implements LoaderInterface
{
    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * JWKSetLoader Constructor.
     */
    public function __construct()
    {
        $this->routes = new RouteCollection();
    }

    /**
     * @param string $pattern
     * @param string $name
     */
    public function add(string $pattern, string $name)
    {
        $controller_id = sprintf('jose.controller.%s', $name);

        $defaults =['_controller' => $controller_id];
        $route = new Route($pattern, $defaults);
        $this->routes->add(sprintf('jwkset_%s', $name), $route);
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $type = null)
    {
        return $this->routes;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($resource, $type = null)
    {
        return 'jwkset' === $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getResolver()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setResolver(LoaderResolverInterface $resolver)
    {
    }
}
