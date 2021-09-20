<?php

declare(strict_types=1);

/*
 * This file is part of the EnumerBundle package.
 *
 * (c) MarfaTech <https://marfa-tech.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MarfaTech\Bundle\EnumerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use MarfaTech\Bundle\EnumerBundle\DependencyInjection\MarfatechEnumerExtension;
use MarfaTech\Bundle\EnumerBundle\Enum\EnumInterface;
use MarfaTech\Bundle\EnumerBundle\Registry\EnumRegistryService;
use MarfaTech\Component\Enumer\EnumRegistry;
use function array_unique;
use function get_declared_classes;
use function is_subclass_of;

class EnumRegistryCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(EnumRegistryService::class)) {
            return;
        }

        $sourceClasses = $this->getSourceClassList($container);

        $enumList = [];
        $enumRegistry = new EnumRegistry();

        foreach ($sourceClasses as $className) {
            $enumRegistry->addEnum($className);

            $enumList[$className] = [
                EnumRegistry::TYPE_ORIGINAL => $enumRegistry->getEnum($className, EnumRegistry::TYPE_ORIGINAL),
                EnumRegistry::TYPE_COMBINE => $enumRegistry->getEnum($className, EnumRegistry::TYPE_COMBINE),
                EnumRegistry::TYPE_COMBINE_NORMALIZE => $enumRegistry->getEnum(
                    $className,
                    EnumRegistry::TYPE_COMBINE_NORMALIZE
                ),
            ];
        }

        $container
            ->getDefinition(EnumRegistryService::class)
            ->replaceArgument(0, $enumList)
        ;
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return array
     */
    private function getSourceClassList(ContainerBuilder $container): array
    {
        $sourceClasses = $container->getParameter(MarfatechEnumerExtension::PARAMETER_SOURCE_CLASSES);

        $finder = $this->getFinder($container);

        foreach ($finder as $splFileInfo) {
            include_once($splFileInfo->getPathname());
        }

        $declaredClassList = get_declared_classes();

        foreach ($declaredClassList as $className) {
            if (!is_subclass_of($className, EnumInterface::class)) {
                continue;
            }

            $sourceClasses[] = $className;
        }

        return array_unique($sourceClasses);
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return Finder
     */
    private function getFinder(ContainerBuilder $container): Finder
    {
        $sourceList = $container->getParameter(MarfatechEnumerExtension::PARAMETER_SOURCES);
        $container->getParameterBag()->remove(MarfatechEnumerExtension::PARAMETER_SOURCES);

        $projectDir = $container->getParameter('kernel.project_dir');

        $finder = new Finder();
        $finder->files()->name('*.php');

        foreach ($sourceList as $directoryOrFile) {
            $finder->in($projectDir . DIRECTORY_SEPARATOR . $directoryOrFile);
        }

        return $finder;
    }
}
