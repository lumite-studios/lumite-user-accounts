<?php
/**
 *
 */
namespace LumiteUserAccounts;

use Lumite\Haunt\Plugin\BasePlugin;
use LumiteUserAccounts\Traits\Auth;
use LumiteUserAccounts\Traits\Settings;

class Plugin extends BasePlugin 
{
	use Auth;
	use Settings;

	/**
	 * Create a new plugin instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		if(!defined('PLUGIN_NAMESPACE'))
		{
			define('PLUGIN_NAMESPACE', basename(__DIR__));
		}

		if(!defined('PLUGIN_DIRECTORY'))
		{
			define('PLUGIN_DIRECTORY', dirname(__FILE__));
		}
	}

	/**
	 * Activate the plugin.
	 * 
	 * @return void
	 */
	public function activate()
	{
		$this->authActivate();
		$this->settingsActivate();

		return;
	}

	/**
	 * Deactivate the plugin.
	 * 
	 * @return void
	 */
	public function deactivate()
	{
		$this->authDeactivate();
		$this->settingsDeactivate();

		return;
	}

	/**
	 * Initialise the plugin.
	 * 
	 * @return void
	 */
	public function init()
	{
		addPluginTranslations(PLUGIN_NAMESPACE, PLUGIN_DIRECTORY.'/resources/lang');
		
		$this->authInit();
		$this->settingsInit();

		return;
	}
}