<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RefreshCommand extends Command
{

    protected function configure()
    {
        $this
            ->setName('rss:refresh')
            ->setDescription('Refresh all feeds')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $feedController = new FeedController();
        $results = $feedController->refreshAllFeedsByCommand();

        for ($i = 0; $i < count($results); ++$i) {
            $type = '';
            if ($results[$i]['status'] !== 200) {
                $type = 'info';
            } else {
                $type = 'error';
            }
            $text = "<".$type.">[".$results[$i]['feed']."] ".$results[$i]['message']."</".$type.">";
            $output->writeln($text);
        }
    }
}
