<div class="card">
	<div class="header">
		<h1>{{ __(PLUGIN_NAMESPACE.'::settings/views.title') }}</h1>
	</div>
	<form method="POST" action="views">
		@csrf
		<div class="body">
			<!-- developer-mode -->
			<div class="md:flex md:items-center">
				<div class="md:mr-2 md:w-1/3 lg:w-1/4">
					<label for="user-request">
						{{ __(PLUGIN_NAMESPACE.'::settings/views.form.user-request.title') }}
					</label>
					<div class="text-gray-600 text-xs">
						{{ __(PLUGIN_NAMESPACE.'::settings/views.form.user-request.description') }}
					</div>
				</div>
				<div class="md:flex-grow">
					<input name="user-request" type="text" value="{{ getSettingValue('user-request') }}" />
				</div>
			</div>

			{!! runHook('view:settings-views') !!}
		</div>
		<div class="footer justify-end">
			<button class="bg-green-500 button text-white">
				{{ __(PLUGIN_NAMESPACE.'::settings/views.form.submit') }}
			</button>
		</div>
	</form>
</div>