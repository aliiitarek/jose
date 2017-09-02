<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\Checker;

final class HeaderCheckerManagerFactory
{
    /**
     * @var HeaderCheckerInterface[]
     */
    private $checkers = [];

    /**
     * @param string[] $aliases
     *
     * @return HeaderCheckerManager
     */
    public function create(array $aliases): HeaderCheckerManager
    {
        $checkers = [];
        foreach ($aliases as $alias) {
            if (array_key_exists($alias, $this->checkers)) {
                $checkers[] = $this->checkers[$alias];
            } else {
                throw new \InvalidArgumentException(sprintf('The header checker with the alias "%s" is not supported.', $alias));
            }
        }

        return HeaderCheckerManager::create($checkers);
    }

    /**
     * @param string                 $alias
     * @param HeaderCheckerInterface $checker
     *
     * @return HeaderCheckerManagerFactory
     */
    public function add(string $alias, HeaderCheckerInterface $checker): HeaderCheckerManagerFactory
    {
        if (array_key_exists($alias, $this->checkers)) {
            throw new \InvalidArgumentException(sprintf('The alias "%s" already exists.', $alias));
        }
        $this->checkers[$alias] = $checker;

        return $this;
    }

    /**
     * @return string[]
     */
    public function aliases(): array
    {
        return array_keys($this->checkers);
    }
}