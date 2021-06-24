<?php

declare(strict_types=1);

namespace App\SimpleNews\Console;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as CliCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Contracts\Service\Attribute\Required;
use App\SimpleNews\UseCase\Create;

#[AsCommand(
    name: 'simpleNews:story:createMock',
    description: 'Create mock',
)]
class CreateMock extends CliCommand
{
    #[Required]
    public MessageBusInterface $bus;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $this->bus->dispatch(
            new Create\Command(
                'Some news title - '.mt_rand(1000, 9999),
                'some author - '.mt_rand(1000, 9999),
                'some text - '.mt_rand(1000, 9999),
            )
        );

        $io->success('Story created');

        return self::SUCCESS;
    }
}