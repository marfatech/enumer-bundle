<?php

declare(strict_types=1);

namespace Wakeapp\Bundle\EnumerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Throwable;
use Wakeapp\Bundle\EnumerBundle\DependencyInjection\WakeappEnumerExtension;
use Wakeapp\Bundle\EnumerBundle\Enum\EnumInterface;
use Wakeapp\Bundle\EnumerBundle\Registry\EnumRegistryService;
use Wakeapp\Component\Enumer\EnumRegistry;
use function get_declared_classes;

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

        $finder = $this->getFinder($container);

        foreach ($finder as $splFileInfo) {
            try {
                include_once($splFileInfo->getPathname());
            } catch (Throwable $e) {
                continue;
            }
        }

        $enumList = [];
        $enumRegistry = new EnumRegistry();

        $declaredClassList = get_declared_classes();

        foreach ($declaredClassList as $className) {
            try {
                if (is_subclass_of($className, EnumInterface::class)) {
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
            } catch (Throwable $e) {
                continue;
            }
        }

        $container
            ->getDefinition(EnumRegistryService::class)
            ->replaceArgument(0, $enumList)
        ;
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return Finder
     */
    private function getFinder(ContainerBuilder $container): Finder
    {
        $sourceList = $container->getParameter(WakeappEnumerExtension::PARAMETER_SOURCES);
        $container->getParameterBag()->remove(WakeappEnumerExtension::PARAMETER_SOURCES);

        $projectDir = $container->getParameter('kernel.project_dir');

        $finder = new Finder();
        $finder->files()->name('*.php');

        foreach ($sourceList as $directoryOrFile) {
            $finder->in($projectDir . DIRECTORY_SEPARATOR . $directoryOrFile);
        }

        return $finder;
    }
}
