<?php
/**
 *
 */
namespace LumiteUserAccounts\Traits;

trait Settings 
{
	/**
	 * When the plugin is activated.
	 * 
	 * @return void
	 */
	public function settingsActivate()
	{
		if(!hasSetting('user-request'))
		{
			createSetting('user-request',
			[
				'notify' => false,
				'value' => 'uid',
			], false);
		}
	}

	/**
	 * When the plugin is deactivated.
	 * 
	 * @return void
	 */
	public function settingsDeactivate()
	{
		if(hasSetting('user-request'))
		{
			deleteSetting('user-request', false);
		}
	}

	/**
	 * When the plugin is initalised.
	 * 
	 * @return void
	 */
	public function settingsInit()
	{
		if(!hasAdminMenuChild('settings', 'views'))
		{
			addAdminMenuChild('settings', 'views', __(PLUGIN_NAMESPACE.'::settings/views.title'),
			[
				'order' => 60,
				'permission' => null,
			]);
		}

		$path = 'settings/views';

		if(!hasAdminView($path) && isAdminView($path))
		{
			addAdminView($path, 'Views', 'plugin::LumiteUserAccounts.resources.views.settings.views',
			[
				//
			],
			[
				//
			]);
		}
	}
}