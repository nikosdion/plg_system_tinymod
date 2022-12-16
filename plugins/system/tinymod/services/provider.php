<?php
/*
 *  @package   TinyMod
 *  @copyright Copyright (c)2022 Nicholas K. Dionysopoulos
 *  @license   GNU General Public License version 3, or later
 */

defined('_JEXEC') || die;

use Dionysopoulos\Plugin\System\TinyMod\Extension\TinyModPlugin;
use Joomla\CMS\Extension\MVCComponent;
use Joomla\CMS\Extension\PluginInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use Joomla\Event\DispatcherInterface;

return new class implements ServiceProviderInterface {
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 *
	 * @since   1.0.0
	 */
	public function register(Container $container)
	{
		/** @var MVCComponent $component */
		$container->set(
			PluginInterface::class,
			function (Container $container) {
				$config  = (array) PluginHelper::getPlugin('system', 'tinymod');
				$subject = $container->get(DispatcherInterface::class);
				$plugin  = new TinyModPlugin($subject, $config);

				$plugin->setApplication(Factory::getApplication());

				return $plugin;
			}
		);
	}
};

