<?php

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2016 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Bundle\JoseFramework\DependencyInjection\Source;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\DependencyInjection\ContainerBuilder;

interface SourceInterface
{
    /**
     * @return string
     */
    public function name(): string;

    /**
     * @param string           $name
     * @param array            $config
     * @param ContainerBuilder $container
     */
    public function createService(string $name, array $config, ContainerBuilder $container);

    /**
     * @param ArrayNodeDefinition $node
     */
    public function getNodeDefinition(ArrayNodeDefinition $node);

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     *
     * @return null|array
     */
    public function prepend(ContainerBuilder $container, array $config): ?array;
}
