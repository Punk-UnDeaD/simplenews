<?php

declare(strict_types=1);

namespace App\SimpleNews\Console;

use App\SimpleNews\UseCase\Delete\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as CliCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;

#[AsCommand(
    name: 'simpleNews:story:delete',
    description: 'Delete story',
)]
class Delete extends CliCommand
{
    #[Required]
    public MessageBusInterface $bus;

    protected function configure()
    {
        $this->addArgument('id', InputArgument::REQUIRED, '');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $id = (int)$input->getArgument('id');
        $this->bus->dispatch(new Command($id));

        $io->success('Story deleted');

        return self::SUCCESS;
    }
}
