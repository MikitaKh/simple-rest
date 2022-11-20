<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Controller\InfoController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\POST;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:take_articles_db',
    description: 'Add a short description for your command',
)]
class TakeArticlesDbCommand extends Command
{   


    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
        $this->setName('app:take_articles_db');
        $this->setDescription('Taking data ');
        $this->setHelp('Command allow us take data from ..');
    }
    
    public function __construct(private ManagerRegistry $doctrine) {
                 
        parent::__construct();
    }
   

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        $output->writeln([
            'Taking data...',
            '============',
            '',
        ]);

        // get remote data from external API
        $requestArticle = file_get_contents('https://jsonplaceholder.typicode.com/posts');
        $responseArticle = json_decode($requestArticle, true);

        $requestUsers=file_get_contents('https://jsonplaceholder.typicode.com/users');
        $responseUsers = json_decode($requestUsers, true);
        
        foreach ($responseArticle as  $elemArticle) {
            $post = new Post();
            $post->setTitle($elemArticle['title']);
            $post->setArticle($elemArticle['body']);
           
            foreach($responseUsers as $elemUser){

            if($elemArticle['userId']==$elemUser['id']){
            $post->setName($elemUser['name']);
            }
           }
    
            $entityManager=$this->doctrine->getManager();
            $entityManager->persist($post);
        }
        $entityManager->flush();

        $io->success('Data has been added succsesfully.');

        return Command::SUCCESS;
    }
}
