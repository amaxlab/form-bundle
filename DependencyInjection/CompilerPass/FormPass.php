<?php

/**
 * Created by PhpStorm.
 * User: Игорь
 * Date: 26.08.14
 * Time: 11:42.
 */
namespace Amaxlab\Bundle\FormBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class FormPass.
 */
class FormPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $resources = $container->getParameter('twig.form.resources');
        $resources[] = 'AmaxlabFormBundle:Form:bootstrap_fields.html.twig';
        $container->setParameter('twig.form.resources', $resources);
    }
}
