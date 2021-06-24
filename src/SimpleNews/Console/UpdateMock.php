<?php

declare(strict_types=1);

namespace App\SimpleNews\Console;

use App\SimpleNews\UseCase\Update\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as CliCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;
use App\SimpleNews\UseCase\Update ;

#[AsCommand(
    name: 'simpleNews:story:updateMock',
    description: 'Update mock',
)]
class UpdateMock extends CliCommand
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
        $this->bus->dispatch(
            new Command(
                $id,
                'Some news title - '.mt_rand(1000, 9999),
                'some author - '.mt_rand(1000, 9999),
                'some text - '.mt_rand(1000, 9999),
            )
        );

        $io->success('Story updated');

        return self::SUCCESS;
    }
}