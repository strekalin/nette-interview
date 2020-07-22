<?php
namespace App\Model\Service;

use App\Model\Service\JobParseStrategy\JobParseStrategyInterface;
use App\Model\Service\JobParseStrategy\JobParseStrategyException;
use Nette\SmartObject;

class JobParseService
{
    use SmartObject;
    
    /**
     * @var JobParseStrategyInterface[]
     */
    private $parserStrategies;
    
    /**
     * Default constructor
     * 
     * @param JobParseStrategyInterface[] $parserStrategies
     */
    public function __construct($parserStrategies)
    {
        $this->parserStrategies = $parserStrategies;
    }
    
    /**
     * Parse latest jobs
     * @throws JobParseStrategyException
     */
    public function parse(): void
    {
        foreach ($this->parserStrategies as $parserStrategy) {
            $parserStrategy->parse();
        }
    }
}