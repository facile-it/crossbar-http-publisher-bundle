<?php
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        return [new Symfony\Bundle\FrameworkBundle\FrameworkBundle(), new Facile\CrossbarHTTPPublisherBundle\FacileCrossbarHTTPPublisherBundle()];
    }

    public function registerContainerConfiguration(LoaderInterface $loader): void
    {
        $loader->load(__DIR__.'/config.yml');
    }
}
