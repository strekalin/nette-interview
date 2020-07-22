<?php
declare(strict_types=1);

namespace Tests\Model\Service\JobParseStrategy;

use App\Model\Service\JobParseStrategy\JobParseStrategyJobscz;
use PHPUnit\Framework\TestCase;
use Nette\DI\Container;
use Doctrine\ORM\EntityManager;

class JobParseStrategyJobsczTest extends TestCase
{
    /**
     * @var string
     */
    private $tmpfname;
    
    /**
     * @var Container
     */
    private $container;

    /**
     * This method is called before each test.
     */
    protected function setUp(): void 
    {
        $this->container = \App\Bootstrap::boot()->createContainer();
        $this->tmpfname = tempnam(sys_get_temp_dir(), "tests_");
    }
    
    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        @unlink($this->tmpfname);
    }
    
    public function testParse() 
    {
        $url = 'file://' . $this->tmpfname;
        $companyName = 'Header_Text';
        $address = 'address';
        $body = 'body';
        $title = 'title';
        
        file_put_contents($this->tmpfname, '
        <html>
        <body>
        <div class="search-list__main-info">
        <h3><a href="'.$url.'">'.$title.'</a></h3>
        <div class="search-list__main-info__company">'.$companyName.'</div>
        <div class="search-list__main-info__address">
            <span></span>
            <span>'.$address.'</span>
        </div>
        </div>
        <div class="jobad__body">'.$body.'</div>
        </body>
        </html>
        ');
        
        $mockEntityManager = $this->getMockBuilder(EntityManager::class)
            ->setMethods(['persist', 'flush'])
            ->disableOriginalConstructor()
            ->getMock();
        

        $parser = $this->container->createInstance(JobParseStrategyJobscz::class, [
            $mockEntityManager
        ]);
        
        
        $reflection = new \ReflectionClass($parser);
        $property = $reflection->getProperty('entryUrl');
        $property->setAccessible(true);
        $property->setValue($parser, 'file://' . $this->tmpfname);
        
        
        $job = $parser->parse();
        
        $this->assertEquals(count($job), 1, "Incorrect amount of parset jobs");
        $job = $job[0];
        $this->assertEquals($job->getTitle(), $title, "Incorrect title parsed");
        $this->assertNotNull($job->getDescription(), 'Incorrect ad parsed (not found)');
        $this->assertEquals($job->getDescription()->getAd(), $body, "Incorrect ad parsed");
        $this->assertNotNull($job->getCompany(), 'Incorrect company parsed (not found)');
        $this->assertEquals($job->getCompany()->getName(), $companyName, "Incorrect company name parsed");
        $this->assertNotNull($job->getLocation(), 'Incorrect location parsed (not found)');
        $this->assertEquals($job->getLocation()->getAddress(), $address, "Incorrect address name parsed");
    }
}
