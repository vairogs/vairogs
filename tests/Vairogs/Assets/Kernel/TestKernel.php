<?php declare(strict_types = 1);

/*
 * This file is part of the Vairogs package.
 *
 * (c) Dāvis Zālītis (k0d3r1s) <davis@vairogs.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vairogs\Assets\Kernel;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel;
use Vairogs\Bundle\VairogsBundle;

class TestKernel extends Kernel
{
    use MicroKernelTrait;

    public function registerBundles(): iterable
    {
        return [
            new VairogsBundle(),
        ];
    }

    public function registerContainerConfiguration(
        LoaderInterface $loader,
    ): void {
    }

    protected function configureContainer(
        ContainerBuilder $container,
        LoaderInterface $loader,
    ): void {
        $container->setParameter('kernel.secret', 'test');

        $container->loadFromExtension('framework', [
            'test' => true,
        ]);
    }
}
