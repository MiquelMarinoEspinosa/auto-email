<?php

namespace AutoEmail\Bounces\UserInterface\Command;

use Pheanstalk\Pheanstalk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BounceParserCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('bounces:bounce-parser')
            ->setDescription('Parse the email to build a bounce job')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientConnection = new Pheanstalk('172.18.0.3');
        $job = $clientConnection->reserveFromTube('bounces-emails', 0);
        if (false !== $job) {
            $clientConnection->delete($job);
            $clientConnection->useTube('bounces');
            $clientConnection->put($job->getData());
        }
        $connection = $clientConnection->getConnection();
        $connection->disconnect();
    }
}
