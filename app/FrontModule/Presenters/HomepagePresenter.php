<?php
declare(strict_types=1);
namespace App\FrontModule\Presenters;

use App\Model\Repository\JobRepository;

final class HomepagePresenter extends BasePresenter
{
    private const ITEMS_PER_PAGE = 15;
    
    /**
     * @var JobRepository
     */
    private $jobRepository;
    
    /**
     * DI JobRepository
     * 
     * @param JobRepository $jobRepository
     */
    public function injectJobRepository(JobRepository $jobRepository): void
    {
        $this->jobRepository = $jobRepository;
    }
    
    /**
     * Display all jobs action
     */
    public function actionDefault() :void
    {
        //TODO Strekalin. Implement elasticsearch here
        $this->template->jobs = $this->jobRepository->findBy([], ['updated' => 'DESC'], self::ITEMS_PER_PAGE);
    }
    
    /**
     * Display job detail action
     * 
     * @param int $id
     */
    public function actionDetail($id) :void
    {
        if (!$id) {
            $this->flashMessage('id is required', 'danger');
            $this->redirect('default');
        }
        
        $job = $this->jobRepository->findOneBy(['id' => $id]);
        if ($job === null) {
            $this->flashMessage('Job not found', 'danger');
            $this->redirect('default');
        }
        
        $this->template->job = $job;
    }
}