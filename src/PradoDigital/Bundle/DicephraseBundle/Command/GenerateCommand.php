<?php

namespace PradoDigital\Bundle\DicephraseBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use PradoDigital\Bundle\DicephraseBundle\Diceware\PassphraseMakerInterface;
use PradoDigital\Bundle\DicephraseBundle\Diceware\Passphrase;

class GenerateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dicephrase:generate')
            ->setDescription('Generate a passphrase')
            ->addOption('length', 'l', InputOption::VALUE_REQUIRED, 'Sets the length of the passphrase.', PassphraseMakerInterface::DICEWARE_RECOMMENDED_LENGTH)
            ->addOption('separator', null, InputOption::VALUE_OPTIONAL, 'Changes the separator.', Passphrase::DICEWARE_DEFAULT_SEPARATOR)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $logger = $this->getContainer()->get('logger');
        $diceware = $this->getContainer()->get('prado_digital.dicephrase.diceware');

        $length = $input->getOption('length');
        $separator = $input->getOption('separator');

        $passphrase = $diceware->generatePassphrase($length);
        $passphrase->setSeparator($separator);

        $output->writeln('<info>'.$passphrase.'</info>');
    }
}
