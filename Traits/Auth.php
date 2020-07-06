<?php
/**
 *
 */
namespace LumiteUserAccounts\Traits;

trait Auth 
{
	/**
	 * When the plugin is activated.
	 * 
	 * @return void
	 */
	public function authActivate()
	{
		if(!hasFormAction('user-register'))
		{
			addFormAction('user-register',
			[
				'input' => false,
				'locked' => true,
				'title' => 'Allow a user to create an account.'
			]);
		}

		if(!hasFormAction('user-login'))
		{
			addFormAction('user-login',
			[
				'input' => false,
				'locked' => true,
				'title' => 'Login a user to their account.'
			]);
		}

		if(!hasForm('register'))
		{
			$actions = [];
			$actions[] =
			[
				'deletable' => false,
				'slug' => 'user-register',
			];

			$fields = [];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Email Address',
				'name' => 'email_address',
				'type' => 'email',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Password',
				'name' => 'password',
				'type' => 'password',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Confirm Password',
				'name' => 'password_confirmation',
				'type' => 'password',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Username',
				'name' => 'username',
				'type' => 'text',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Date of Birth',
				'name' => 'date_of_birth',
				'type' => 'date',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Register',
				'name' => 'submit',
				'type' => 'submit',
			];

			createForm('Register',
			[
				'actions' => $actions,
				'deletable' => false,
				'fields' => $fields,
				'slug' => 'register'
			]);
		}

		if(!hasForm('login'))
		{
			$actions = [];
			$actions[] =
			[
				'deletable' => false,
				'slug' => 'user-login',
			];

			$fields = [];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Email Address',
				'name' => 'email_address',
				'type' => 'email',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Password',
				'name' => 'password',
				'type' => 'password',
			];
			$fields[] =
			[
				'deletable' => false,
				'label' => 'Login',
				'name' => 'submit',
				'type' => 'submit',
			];

			createForm('Login',
			[
				'actions' => $actions,
				'deletable' => false,
				'fields' => $fields,
				'slug' => 'login'
			]);
		}

		if(!hasPage('/register'))
		{
			createPage('Register', '<p>[form=register]</p>',
			[
				'slug' => '/register',
				'template' => null
			], false);
		}

		if(!hasPage('/login'))
		{
			createPage('Login', '<p>[form=login]</p>',
			[
				'slug' => '/login',
				'template' => null
			], false);
		}

		if(!hasPage('/user'))
		{
			createPage('User', '<p>[user=uid]</p>',
			[
				'deletable' => false,
				'slug' => '/user',
				'template' => null
			], false);
		}
	}

	/**
	 * When the plugin is deactivated.
	 * 
	 * @return void
	 */
	public function authDeactivate()
	{
		if(hasFormAction('user-register'))
		{
			deleteFormAction('user-register');
		}

		if(hasFormAction('user-login'))
		{
			deleteFormAction('user-login');
		}

		if(hasForm('register'))
		{
			deleteForm('register', false, true);
		}

		if(hasForm('login'))
		{
			deleteForm('login', false, true);
		}
	}

	/**
	 * When the plugin is initalised.
	 * 
	 * @return void
	 */
	public function authInit()
	{
		addPageAction('/user', function()
		{
			$elem = null;
			$attr = getSettingValue('user-request');

			if(request()->has($attr))
			{
				$elem = request()->input($attr);
			} else
			{
				if(auth()->check())
				{
					$elem = auth()->user()->$attr;
				}
			}

			$user = \Models\User::where($attr, '=', $elem)->first();

			if(!$user)
			{
				return redirect()->back();
			}

			return ['user' => $user];
		});

		addParseableElement('user', function(string $attribute)
		{
			$uid = null;

			if(request()->has('user'))
			{
				$uid = request()->input('user');
			} else
			{
				if(auth()->check())
				{
					$uid = auth()->user()->uid;
				}
			}

			$user = \Models\User::where('uid', '=', $uid)->first();

			if(!$user)
			{
				return;
			}

			return $user->$attribute;
		});
	}
}