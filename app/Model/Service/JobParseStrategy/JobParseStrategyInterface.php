<?php
namespace App\Model\Service\JobParseStrategy;

use App\Model\Entity\Job;

interface JobParseStrategyInterface
{
    /**
     * Parse latest jobs
     * @return Job[]
     * @throws JobParseStrategyException
     */
    public function parse(): array;
}