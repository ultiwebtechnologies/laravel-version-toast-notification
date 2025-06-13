<?php

namespace UltiwebTechnologies\VersionToast;

use Illuminate\Support\ServiceProvider;

class VersionToastServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Publish config, views, and JS stub
		$this->publishes([
			__DIR__ . '/../config/version-toast.php' => config_path('version-toast.php'),
			__DIR__ . '/../resources/views'         => resource_path('views/vendor/version-toast'),
			__DIR__ . '/../resources/js'            => public_path('vendor/version-toast/js'),
		], 'version-toast');

		// Merge default config
		$this->mergeConfigFrom(
			__DIR__ . '/../config/version-toast.php',
			'version-toast'
		);
	}

	public function register()
	{
		if ($this->app->runningInConsole()) {
			$this->commands([
				Console\InstallCommand::class,
			]);
		}
	}
}
