<?php

namespace Amaxlab\Bundle\FormBundle;

use Amaxlab\Bundle\FormBundle\DependencyInjection\CompilerPass\FormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class AmaxlabFormBundle.
 */
class AmaxlabFormBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new FormPass());
    }
}
