<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Model\Service\JobParseService;

class JobParseCommand extends Command
{

    protected static $defaultName = 'app:job:parse';

    /**
     * @var JobParseService
     */
    private $jobParseService;

    /**
     * Default constructor
     *
     * @param JobParseService $jobParseService
     */
    public function __construct(JobParseService $jobParseService)
    {
        parent::__construct(self::$defaultName);
        $this->setDescription('Parse new jobs from sources');
        $this->jobParseService = $jobParseService;
    }

    /**
     * {@inheritdoc}
     * @see Command::execute()
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->jobParseService->parse();
            return self::SUCCESS;
        } catch (\Exception $ex) {
            $output->writeln($ex->getMessage());
            return self::FAILURE;
        }
    }
}