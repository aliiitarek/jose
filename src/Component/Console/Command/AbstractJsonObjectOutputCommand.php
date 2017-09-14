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

namespace Jose\Component\Console\Command;

use Jose\Component\Core\Converter\JsonConverterInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractJsonObjectOutputCommand extends Command
{
    /**
     * @var JsonConverterInterface
     */
    protected $jsonConverter;

    /**
     * AbstractGeneratorCommand constructor.
     *
     * @param JsonConverterInterface $jsonConverter
     * @param string|null            $name
     */
    public function __construct(JsonConverterInterface $jsonConverter, string $name = null)
    {
        $this->jsonConverter = $jsonConverter;
        parent::__construct($name);
    }

    /**
     * Configures the current command.
     */
    protected function configure()
    {
        $this
            ->setDefinition(
                new InputDefinition([
                    new InputOption('out', 'o', InputOption::VALUE_OPTIONAL, 'File where to save the key. Must be a valid and writable file name.'),
                ])
            )
        ;
    }

    /**
     * @param InputInterface    $input
     * @param OutputInterface   $output
     * @param \JsonSerializable $json
     */
    protected function prepareOutput(InputInterface $input, OutputInterface $output, \JsonSerializable $json)
    {
        $json = $this->jsonConverter->encode($json);
        $file = $input->getOption('out');
        if (null !== $file) {
            file_put_contents($file, $json, LOCK_EX);
        } else {
            $output->write($json);
        }
    }
}