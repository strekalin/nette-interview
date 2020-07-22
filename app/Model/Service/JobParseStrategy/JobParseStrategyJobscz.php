<?php
namespace App\Model\Service\JobParseStrategy;

use App\Model\Entity\Location;
use App\Model\Entity\Job;
use App\Model\Entity\Company;
use App\Model\Repository\CompanyRepository;
use App\Model\Repository\JobRepository;
use App\Model\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use League\HTMLToMarkdown\HtmlConverter;
use App\Model\Entity\JobDescription;
use Nette\SmartObject;

class JobParseStrategyJobscz implements JobParseStrategyInterface
{
    use SmartObject;
    
    /**
     * @var string
     */
    private $entryUrl = 'https://www.jobs.cz/prace/php-vyvojar/';
    
    /**
     * @var string[]
     */
    private $headers = [
        'User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US) AppleWebKit/534.20 (KHTML, like Gecko) Chrome/11.0.672.2 Safari/534.20',
        'Accept-Language: en-GB,en;q=0.5',
        'Connection: keep-alive',
        'Pragma: no-cache',
        'Cache-Control: no-cache'
    ];
    
    /**
     * @var CompanyRepository
     */
    private $companyRepository;
    
    /**
     * @var JobRepository
     */
    private $jobRepository;
    
    /**
     * @var LocationRepository
     */
    private $locationRepository;
    
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, CompanyRepository $companyRepository, 
        JobRepository $jobRepository, LocationRepository $locationRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->jobRepository = $jobRepository;
        $this->locationRepository = $locationRepository;
        $this->entityManager = $entityManager;
    }
    
    /**
     * {@inheritDoc}
     * @see JobParseStrategyInterface::parse()
     */
    public function parse(): array
    {
        $result = [];
        $xpath = $this->getXpath($this->entryUrl);
        foreach($xpath->query("//div[contains(concat(' ', @class, ' '), ' search-list__main-info ')]") as $node) {
            $header = $xpath->query("h3/a", $node)->item(0);
            if ($header) {
                $url = $header->getAttribute('href');
                $header = trim($header->textContent);
                $company = $xpath->query("div[contains(concat(' ', @class, ' '), ' search-list__main-info__company ')]", $node)->item(0);
                if ($company) {
                    $companyName = trim($company->textContent);
                    $address = $xpath->query("div[contains(concat(' ', @class, ' '), ' search-list__main-info__address ')]/span[2]", $node)->item(0);
                    if ($address) {
                        $address = trim($address->textContent);
                        $externalId = 'jobscz_' . sha1($url);
                        
                        if ($this->jobRepository->findOneBy(['extId' => $externalId]) === null 
                            && $advertisement = $this->parseAdvertisement($url)) {

                            $company = $this->companyRepository->findOneBy(['name' => $companyName]);
                            if ($company === null) {
                                $company = new Company($companyName);
                                $this->entityManager->persist($company);
                            }
                            
                            $location = $this->locationRepository->findOneBy(['address' => $address]);
                            if ($location === null) {
                                $location = new Location($address);
                                $this->entityManager->persist($location);
                            }
                            
                            $job = new Job($header, $externalId, $company, $location,
                                new JobDescription($advertisement));
                            
                            $this->entityManager->persist($job);
                            $this->entityManager->flush();
                            $result[] = $job;
                        }
                    }
                }
            }
        }
        
        return $result;
    }
    
    /**
     * Parse Advertisement
     * 
     * @param string $url
     * @throws JobParseStrategyException
     * @return string
     */
    private function parseAdvertisement($url): ?string
    {
        $xpath = $this->getXpath($url);
        $node = $xpath->query("//div[contains(concat(' ', @class, ' '), ' jobad__body ')]")->item(0);
        if ($node) {
            $result = '';
            foreach($node->childNodes as $child) {
                $result .= $child->ownerDocument->saveXML($child);
            }
            $converter = new HtmlConverter(['strip_tags' => true]);
            return $converter->convert(trim($result));
        }
        return null;
    }
    
    /**
     * Parse html to Xpath object
     *
     * @param string $url
     * @return \DOMXpath
     */
    private function getXpath(string $url): \DOMXpath {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_COOKIEFILE, '');
        
        $html = curl_exec($ch);
        if ($html === false) {
            throw new JobParseStrategyException('Unable download content: ' . curl_error($ch));
        }
        curl_close($ch);
        
        libxml_use_internal_errors(true);
        $doc = new \DOMDocument();
        $doc->loadHTML($html);
        $xpath = new \DOMXpath($doc);
        libxml_clear_errors();
        
        return $xpath;
    }
}