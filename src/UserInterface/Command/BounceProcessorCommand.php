<?php

namespace AutoEmail\Bounces\UserInterface\Command;

use Pheanstalk\Connection;
use Pheanstalk\Pheanstalk;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BounceProcessorCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('bounces:bounce-processor')
            ->setDescription('Parse the email to build a bounce job')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientConnection = new Pheanstalk('172.18.0.3');
        $job = $clientConnection->reserveFromTube('bounces', 0);
        if (false !== $job) {
            $clientConnection->delete($job);
            $content = gzuncompress(base64_decode($job->getData()));
            $servername = '172.18.0.4';
            $username = 'notifications';
            $password = 'test';
            $dataBase = 'notifications';

            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dataBase);

            // Check connection
            if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
            }
            echo 'Connected successfully\n';

            $sql = "INSERT INTO bounces (content) VALUES ('". $content ."')";
            mysqli_query($conn, $sql);

            mysqli_close($conn);
        }
        /** @var Connection $connection */
        $connection = $clientConnection->getConnection();
        $connection->disconnect();
    }
}
