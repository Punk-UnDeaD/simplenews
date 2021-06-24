<?php

declare(strict_types=1);

namespace App\SimpleNews\Console;

use App\SimpleNews\ReadModel\StoryFetcher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as CliCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'simpleNews:story:inspect',
    description: 'inspect story',
)]
class Inspect extends CliCommand
{
    #[Required]
    public StoryFetcher $fetcher;

    protected function configure()
    {
        $this->addArgument('id', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $id = (int)$input->getArgument('id');

        $story = $this->fetcher->get($id);

        $io->writeln(json_encode($story, JSON_PRETTY_PRINT));

        return self::SUCCESS;
    }
}
