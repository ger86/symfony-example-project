<?php

namespace App\Command;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateInitialCategoriesCommand extends Command
{
    protected static $defaultName = 'app:category:create-initial-categories';

    public function __construct(
        private CategoryRepository $categoryRepository
    ) {
        parent::__construct();
    }


    protected function configure(): void
    {
        $this
            ->addArgument(
                'count',
                InputArgument::REQUIRED,
                'How many categories are going to be created'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = $input->getArgument('count');

        for ($i = 0; $i < $count; $i++) {
            $category = new Category(sprintf('name-%d', $i));
            $this->categoryRepository->save($category, false);
        }
        $this->categoryRepository->save($category);
        $output->writeln('Mi primer comando');
        return Command::SUCCESS;
    }
}
