<?php

namespace Spatie\ShortSchedule\Commands;

use Illuminate\Console\Command;
use React\EventLoop\Factory;
use Spatie\ShortSchedule\ShortSchedule;

class ShortScheduleRunCommand extends Command
{
    protected $signature = 'short-schedule:run {--lifetime= : The lifetime in seconds of worker} {--pidfile= : pid file}';

    protected $description = 'Run the short scheduled commands';

    public function handle()
    {
        $loop = Factory::create();

        $pid_file = $this->option('pidfile');
        if(!empty($pid_file)){
            file_put_contents($pid_file, posix_getpid());
        }

        (new ShortSchedule($loop))->registerCommands()->run($this->option('lifetime'));
    }
}
