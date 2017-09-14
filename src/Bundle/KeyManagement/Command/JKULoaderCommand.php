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

namespace Jose\Bundle\KeyManagement\Command;

use Jose\Component\Console\Command\AbstractGeneratorCommand;
use Jose\Component\KeyManagement\JKUFactory;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

final class JKULoaderCommand extends AbstractGeneratorCommand implements ContainerAwareInterface
{
    /**
     * @var ContainerInterface|null
     */
    private $container;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('keyset:load:jku')
            ->setDescription('Loads a key set from an url.')
            ->setHelp('This command will try to get a key set from an URL. The distant key set is a JWKSet.')
            ->addArgument('url', InputArgument::REQUIRED, 'The URL')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var JKUFactory $jkuFactory */
        $jkuFactory = $this->getContainer()->get(JKUFactory::class);
        $url = $input->getArgument('url');

        $result = $jkuFactory->loadFromUrl($url);
        $this->prepareOutput($input, $output, json_encode($result));
    }

    /**
     * @return ContainerInterface
     *
     * @throws \LogicException
     */
    protected function getContainer(): ContainerInterface
    {
        if (null === $this->container) {
            $application = $this->getApplication();
            if (null === $application) {
                throw new \LogicException('The container cannot be retrieved as the application instance is not yet set.');
            }

            $this->container = $application->getKernel()->getContainer();
        }

        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}