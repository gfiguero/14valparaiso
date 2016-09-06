<?php

namespace Unisystem\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\PageBundle\Entity\PageProcess;
use Unisystem\PageBundle\Form\PageProcessType;

/**
 * PageProcess controller.
 *
 */
class PageProcessController extends Controller
{
    /**
     * Lists all PageProcess entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $pageProcesses = $em->getRepository('UnisystemPageBundle:PageProcess')->findBy(array(), array($sort => $direction));
        else $pageProcesses = $em->getRepository('UnisystemPageBundle:PageProcess')->findAll();
        $paginator = $this->get('knp_paginator');
        $pageProcesses = $paginator->paginate($pageProcesses, $request->query->getInt('page', 1), 25);

        return $this->render('pageprocess/index.html.twig', array(
            'pageProcesses' => $pageProcesses,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new PageProcess entity.
     *
     */
    public function newAction(Request $request)
    {
        $pageProcess = new PageProcess();
        $form = $this->createForm('Unisystem\PageBundle\Form\PageProcessType', $pageProcess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageProcess);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pageProcess.created' );    

            return $this->redirectToRoute('page_process_show', array('id' => $pageProcess->getId()));
        }

        return $this->render('pageprocess/new.html.twig', array(
            'pageProcess' => $pageProcess,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PageProcess entity.
     *
     */
    public function showAction(PageProcess $pageProcess)
    {
        $deleteForm = $this->createDeleteForm($pageProcess);

        return $this->render('pageprocess/show.html.twig', array(
            'pageProcess' => $pageProcess,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PageProcess entity.
     *
     */
    public function editAction(Request $request, PageProcess $pageProcess)
    {
        $deleteForm = $this->createDeleteForm($pageProcess);
        $editForm = $this->createForm('Unisystem\PageBundle\Form\PageProcessType', $pageProcess);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageProcess);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pageProcess.edited' );    

            return $this->redirectToRoute('page_process_edit', array('id' => $pageProcess->getId()));
        }

        return $this->render('pageprocess/edit.html.twig', array(
            'pageProcess' => $pageProcess,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PageProcess entity.
     *
     */
    public function deleteAction(Request $request, PageProcess $pageProcess)
    {
        $form = $this->createDeleteForm($pageProcess);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pageProcess);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'pageProcess.deleted' );    
        }

        return $this->redirectToRoute('page_process_index');
    }

    /**
     * Creates a form to delete a PageProcess entity.
     *
     * @param PageProcess $pageProcess The PageProcess entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PageProcess $pageProcess)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_process_delete', array('id' => $pageProcess->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
