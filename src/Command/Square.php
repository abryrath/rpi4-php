<?php

namespace App\Command;

use PiPHP\GPIO\GPIO;
use PiPHP\GPIO\Pin\PinInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PiPHP\GPIO\Pin\InputPinInterface;

class Square extends Command
{
    /** @var GPIO|null */
    protected $gpio;

    protected static $defaultName = 'square';

    public function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->gpio = new GPIO();
    }

    public function configure(): void
    {
        $this
            ->setDescription('Generate a square wave');

    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $pinNumber = 21;
        $pin = $this->gpio->getOutputPin($pinNumber);
        $freqHz = 20;
        $sleepTimeMs = 1000.0/$freqHz;
        $val = PinInterface::VALUE_HIGH;
        while(true) {
            $pin->setValue($val);
            $val = $val === PinInterface::VALUE_HIGH ? PinInterface::VALUE_LOW : PinInterface::VALUE_HIGH;
            usleep((int)$sleepTimeMs);
        }
        return Command::SUCCESS;
    }
}
