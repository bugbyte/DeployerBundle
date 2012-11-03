<?php

namespace Bugbyte\DeployerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeployCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		parent::configure();

		$this
			->setName('bb:deploy')
            ->setDescription('Deploys the project to a remote server')
			->addArgument('action', InputArgument::REQUIRED, 'update,rollback,cleanup')
			->addArgument('target', InputArgument::REQUIRED, 'stage,prod');
	}

    /**
     * Executes the current command.
     *
     * @param InputInterface  $input  An InputInterface instance
     * @param OutputInterface $output An OutputInterface instance
     *
     * @throws \Exception
     * @return integer 0 if everything went fine, or an error code
     */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		// your code here.
		$action = $input->getArgument('action');

        if (!in_array($action, array('deploy', 'rollback', 'cleanup')))
            throw new \Exception("Unknown action '$action'. Action must be one of deploy,rollback,cleanup");

        $target = $input->getArgument('target');

        $config = $this->getContainer()->getParameter('targets');

        if (!isset($config[$target]))
            throw new \Exception("No configuration for target '$target' found !");

        $deployer = new \Deploy(array(
            'project_name' => $config[$target]['project_name'],
            'basedir' => dirname(dirname(dirname(dirname(dirname(__FILE__))))),
            'remote_host' => $config[$target]['remote_host'],
            'remote_dir' => $config[$target]['remote_dir'],
            'remote_user' => $config[$target]['remote_user'],
            'rsync_excludes' => $config[$target]['rsync_excludes'],
	        'data_dirs' => $config[$target]['data_dirs'],
            'database_dirs' => $config[$target]['database_dirs'],
            'database_name' => $config[$target]['database_name'],
            'database_user' => $config[$target]['database_user'],
            'target' => $target,
            'database-patcher' => $config[$target]['database_patcher'],
            'datadir-patcher' => $config[$target]['datadir_patcher'],
            'apc_deploy_version_template' => $config[$target]['apc_deploy_version_template'],
            'apc_deploy_version_path' => $config[$target]['apc_deploy_version_path'],
            'apc_deploy_setrev_url' => $config[$target]['apc_deploy_setrev_url'],
        ));

        $deployer->$action();
	}
}