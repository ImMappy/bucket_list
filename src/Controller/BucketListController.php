<?php

namespace App\Controller;

use App\Entity\BucketList;
use App\Form\BucketListType;
use App\Repository\BucketListRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\Translation\t;

class BucketListController extends AbstractController
{
    protected $slugger;
    /**
     * @Route("/", name="bucket_list.index")
     */
    public function index(BucketListRepository $repository): Response
    {
        $bucketListAll = $repository->findAll();
        return $this->render('pages/bucket_list/index.html.twig', [
            'bucketListAll' => $bucketListAll
        ]);
    }

    /**
     * @Route("/bucket_list/nouvelleTache", name="bucket_list.new")
     */
    public function newTask(Request $request, EntityManagerInterface $manager): Response
    {
        $bucketList = new BucketList();
        $form = $this->createForm(BucketListType::class, $bucketList);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bucketList = $form->getData();
            $manager->persist($bucketList);
            $manager->flush();
            $this->addFlash('success', 'Tâche ajoutée');
            return $this->redirectToRoute('bucket_list.index');
        }
        return $this->render('pages/bucket_list/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/bucket_list/edit{id}", name="bucket_list.edit")
     */
    public function editTask(BucketList $bucketList, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(BucketListType::class, $bucketList);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $bucketList = $form->getData();
            $manager->persist($bucketList);
            $manager->flush();
            $this->addFlash('success', 'Tâche modifiée');

            return $this->redirectToRoute('bucket_list.index');
        }
        return $this->render('pages/bucket_list/edit.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @param BucketList $bucketList
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/bucket_list/delete{id}",name="bucket_list.delete")
     */
    public function deleteTask(BucketList $bucketList, Request $request, EntityManagerInterface $manager): Response
    {
        if (!$bucketList) {
            $this->addFlash('success', 'Tâche suprimée');
        }
        $form = $this->createForm(BucketListType::class, $bucketList);
        $form->handleRequest($request);
        $manager->remove($bucketList);
        $manager->flush();

        return $this->redirectToRoute('bucket_list.index');

    }

    /**
     * @Route("/bucket_list/detail{id}", name="bucket_list.detail")
     */
    public function detail(BucketList $bucketListId,BucketListRepository $repository): Response
    {

        $bucketList = $repository->find($bucketListId);


        return $this->render('pages/bucket_list/detail.html.twig', [
            'bucketList'=>$bucketList
        ]);
    }

}
