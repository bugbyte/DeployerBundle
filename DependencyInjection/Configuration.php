<?php

namespace Bugbyte\DeployerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('bugbyte_deployer');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->arrayNode('prod')
                    ->children()
                        ->scalarNode('project_name')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('database_patcher')->defaultValue('vendor/bugbyte/bugbyte/deployer/database-patcher.php')->end()
                        ->scalarNode('datadir_patcher')->defaultValue('vendor/bugbyte/bugbyte/deployer/datadir-patcher.php')->end()
                        ->arrayNode('target_specific_files')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('remote_host')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('remote_dir')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('remote_user')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('rsync_excludes')->end()
                        ->arrayNode('data_dirs')
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('database_dirs')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('database_name')->end()
                        ->scalarNode('database_user')->end()
                        ->scalarNode('apc_deploy_version_template')->defaultValue('vendor/bugbyte/deployer/apc/deploy_version_template.php')->end()
                        ->scalarNode('apc_deploy_version_path')->end()
                        ->scalarNode('apc_deploy_setrev_url')->end()
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }
}
