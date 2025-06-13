<?php

namespace UltiwebTechnologies\VersionToast\Console;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
	protected $signature = 'version-toast:install';
	protected $description = 'Publish version-toast assets and show installation instructions.';

	public function handle()
	{
		// Publish assets
		$this->call('vendor:publish', [
			'--tag' => 'version-toast',
			'--force' => true,
		]);

		// Installation reminder
		$this->info('Version-toast assets published!');
		$this->line('Add the following include just before </body> in your main layout:');
		$this->line("    @include('vendor.version-toast.toast')");
		$this->line('');
		$this->line('Ensure you have:');
		$this->line('  <script src="/vendor/version-toast/js/version-toast.js"></script>');
	}
}
