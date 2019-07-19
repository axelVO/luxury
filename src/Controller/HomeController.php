<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Entity\JobOffer;
use App\Entity\Candidature;
use App\Entity\JobCategory;
use App\Entity\Client;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Persistence\ObjectManager;



class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
        else {
           $user = $user->getId();
        }
        $jobs = $this->getDoctrine()
        ->getRepository(JobOffer::class)
        ->findAll();

        return $this->render('home/index.html.twig', [
            'alljobs'=>$jobs,
            'user'=>$user,
        ]);
    }
     /**
     * @Route("/contact", name="contact")
     */
    public function contact(TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
        else {
            $user = $user->getId();
         }
        return $this->render('other/contact.html.twig', [
            'user'=>$user,
            
           
        ]);
    }
       /**
     * @Route("/company", name="company")
     */
    public function company(TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
        else {
            $user = $user->getId();
         }
        return $this->render('other/company.html.twig', [
            'user'=>$user,
            
            
        ]);
    }

     /**
     * @Route("/profile/{id}", name="profile")
     */
    public function profile(TokenStorageInterface $tokenStorage, int $id)
    {
        $i = 0;
        $numval = 0;
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $users = 0;
        }
        else {
            $users = $user->getId();
         }
        foreach ($user as $key) {
            if ($key == NULL) {
                $i++;
            }
            else {
                $i++;
                $numVal++;
            }
            if ($numval == 0) {
                $pourcentage = 0;
            }
            else {
               $pourcentage = $i * ($numVal/100); 
            }
            
            
        }
        return $this->render('auth/profile.html.twig', [
            'user'=>$users,
            'userInfo'=>$user,
            'pourcentage'=>$pourcentage

            
            
        ]);
    }
      /**
     * @Route("/admin", name="admin")
     */
    public function admin(TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();

        if(!$this->adminCheckpoint($user)) {
            return $this->redirectToRoute('home');
        }
        

        $users = new User;

        $jobs = $this->getDoctrine()
        ->getRepository(JobOffer::class)
        ->findAll();

        $candi = $this->getDoctrine()
        ->getRepository(Candidature::class)
        ->findAll();

        $client = $this->getDoctrine()
        ->getRepository(Client::class)
        ->findAll();
        
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();
         
        $jobCategory = $this->getDoctrine()
        ->getRepository(JobCategory::class)
        ->findAll();
        return $this->render('admin/index.html.twig', [
            'users'=>$user,
            'candis'=>$candi,
            'clients'=>$client,
            'jobs'=>$jobs,
            'jobCategorys'=>$jobCategory,

        ]);
    }
      /**
     * @Route("/admin/{id}", name="adminUser")
     */
    public function userAdmin(TokenStorageInterface $tokenStorage,string $id)
    {
        $user = $tokenStorage->getToken()->getUser();

        if(!$this->adminCheckpoint($user)) {
            return $this->redirectToRoute('home');
        }
        $users = new User;
       

 
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->find($id);
    
        return $this->render('admin/userAdmin.html.twig', [
            'user'=>$user,


        ]);
    }
    /**
     * @Route("/admin/{id}/add", name="adminUserAdd" ,methods={"GET", "POST"})
     */
    public function userAdminAdd(string $id, ObjectManager $objectManager,Request $request ,TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();

        if(!$this->adminCheckpoint($user)) {
            return $this->redirectToRoute('home');
        }

        $user = $objectManager->getRepository(User::class)->find($id);
        $path = $request->query;
       
        $user->setEmail($path->get('email'));
        $user->setGender($path->get('gender'));
        $user->setFirstName($path->get('firstName'));
        $user->setLastName($path->get('lastName'));
        $user->setPhoneNumber($path->get('phoneNumber'));
        $user->setProfilePicture($path->get('profilePicture'));
        $user->setCurrentLocation($path->get('currentLocation'));
        $user->setAddress($path->get('address'));
        $user->setCountry($path->get('country'));
        $user->setNationality($path->get('nationality'));
        $user->setPassport($path->get('passport'));
        $user->setResume($path->get('resume'));
        $user->setExperience($path->get('experience'));
        $user->setDescription($path->get('description'));
        $user->setNote($path->get('note'));
        $user->setJobCategory($path->get('jobsCategory'));
        $user->setUpdatedAt(new \DateTime());


        
        $objectManager->persist($user);
        $objectManager->flush();
        return $this->redirectToRoute('home');
        
    }
              /**
     * @Route("/jobs", name="jobs")
     */
    public function jobs(TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
        else {
            $user = $user->getId();
         }

        $jobs = $this->getDoctrine()
        ->getRepository(JobOffer::class)
        ->findAll();

        $job = new JobOffer;
        
        return $this->render('jobs/index.html.twig', [
            'alljobs'=>$jobs,
            'user'=>$user,

        ]);
    }
              /**
     * @Route("/about", name="about")
     */
    public function about(TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
        else {
            $user = $user->getId();
         }
        return $this->render('other/company.html.twig', [
            'user'=>$user,
            
        ]);
    }
              /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        
        return $this->render('home/index.html.twig', [
            
        ]);
    }
                  /**
     * @Route("/jobs/{id}", name="jobsShow", methods={"GET", "POST"})
     */
    public function showJobs(Request $request ,string $id,TokenStorageInterface $tokenStorage)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
        else {
            $user = $user->getId();
         }
     
        $jobs = $this->getDoctrine()
        ->getRepository(JobOffer::class)
        ->findAll();

      
        $max = 0;

        foreach ($jobs as $key) {
            $max++;
        
        }
        
      if ($id > $max) {
        return $this->redirectToRoute('jobsShow', array('id' => $max));
            
        } 
        $job = $this->getDoctrine()
        ->getRepository(JobOffer::class)
        ->find($id);
        $candi = $this->getDoctrine()
        ->getRepository(Candidature::class)
        ->find($id);
        if ($candi != NULL) {
            
        
        $userCandi = $candi->getUser();
        $jobCandi = $candi->getJobOffer();

        
        if ($userCandi->getId() == $user->getId() && $jobCandi->getId() == $job->getId() ) {
            $jobscandi = 'true';
        }
        else{
            $jobscandi = 'false';

        }
}
else {
    $jobscandi = 'false';
}
        return $this->render('jobs/show.html.twig', [
            "job"=>$job,
            "user"=>$user,
            "candi"=>$jobscandi,
            "jobNum"=>$max
        ]);
    }
                      /**
     * @Route("/jobs/{id}/add", name="addJobsAtUser", methods={"GET", "POST"})
     */
    public function addJobsAtUser(Request $request ,string $id, TokenStorageInterface $tokenStorage,ObjectManager $objectManager)
    {
        $user = $tokenStorage->getToken()->getUser();
        if (!$this->userCheckpoint($user)) {
            $user = 0;
        }
     
        $job = $this->getDoctrine()
        ->getRepository(JobOffer::class)
        ->find($id);

        $candi = new Candidature;
        $candi->setJobOffer($job);
        $candi->setUser($user);

        $objectManager->persist($candi);
        $objectManager->flush();

        return $this->redirectToRoute('jobsShow', array('id' => $id));
    }

    private function adminCheckpoint($user) 
    {
        if(!is_object($user)) {
            return false;
        }

        foreach ($user->getRoles() as $key) {
            if ($key == 'ROLE_ADMIN') {
                $admin = true;
            }
            else {
                $admin = false;
            }
        }
        if ($admin != true) {
            return false;
        }

        return true;
    }
    private function userCheckpoint($user) 
    {
        if(!is_object($user)) {
            return false;
        }
        return true;
    }
}
