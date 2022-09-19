<?php

namespace Laravue\Commands\Deploy;

use Composer\Console\Application;
use Composer\Util\Platform;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;

class ComposerUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'composer:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Composer update';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $application = new Application();
        $application->setAutoExit(false);
        $application->setCatchExceptions(false);
        $args = ['command' => 'update'];
        if (app()->isProduction()) {
            $this->components->warn('Running Composer update in production mode...');
            $args['--optimize-autoloader'] = true;
            $args['--no-dev'] = true;
            Platform::putEnv('COMPOSER_ALLOW_SUPERUSER', '1');
        } else {
            $this->components->info('Running Composer update...');
        }
        $input = new ArrayInput($args);

        try {
            $application->run($input);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        return SymfonyCommand::SUCCESS;
    }
}