<?php
/*
 *  @package   TinyMod
 *  @copyright Copyright (c)2022-2023 Nicholas K. Dionysopoulos
 *  @license   GNU General Public License version 3, or later
 */

/**
 * @package     Dionysopoulos\Plugin\System\TinyMod\Extension
 * @subpackage
 *
 * @copyright   A copyright
 * @license     A "Slug" license name e.g. GPL2
 */

namespace Dionysopoulos\Plugin\System\TinyMod\Extension;

defined('_JEXEC') || die;

use Joomla\CMS\Document\HtmlDocument;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Event\Event;
use Joomla\Event\SubscriberInterface;
use JsonException;

class TinyModPlugin extends CMSPlugin implements SubscriberInterface
{

	/**
	 * Returns an array of events this subscriber will listen to.
	 *
	 * @return  array
	 *
	 * @since   1.0.0
	 */
	public static function getSubscribedEvents(): array
	{
		return [
			'onBeforeRender' => 'onBeforeRender',
		];
	}

	/**
	 * Runs before Joomla renders the HTML document.
	 *
	 * @param   Event  $event
	 *
	 *
	 * @since version
	 */
	public function onBeforeRender(Event $event): void
	{
		// Only applies to front- and backend, when we are going to output an HTML document
		if (
			!(
				$this->getApplication()->isClient('site')
				|| $this->getApplication()->isClient('administrator')
			)
			|| !($this->getApplication()->getDocument() instanceof HtmlDocument)
		)
		{
			return;
		}

		// Make sure TinyMCE is loaded on the page
		$opts = $this->getApplication()->getDocument()->getScriptOptions('plg_editor_tinymce');

		if (empty($opts) || !is_array($opts))
		{
			return;
		}

		// Load the new options from the plugin's configuration
		$optionsJson = trim($this->params->get('tinymce_options', '') ?? '');

		if (empty($optionsJson))
		{
			return;
		}

		try
		{
			$newOptions = @json_decode($optionsJson, true) ?: null;
		}
		catch (JsonException $e)
		{
			$newOptions = null;
		}

		if (empty($newOptions) || !is_array($newOptions))
		{
			return;
		}

		// Merge the new options into the existing default TinyMCE options
		$this
			->getApplication()
			->getDocument()
			->addScriptOptions(
				'plg_editor_tinymce',
				['tinyMCE' => ['default' => $newOptions]],
				true
			);
	}
}