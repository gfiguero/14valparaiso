<?php

namespace Unisystem\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\PageBundle\Entity\PageService;
use Unisystem\PageBundle\Form\PageServiceType;

/**
 * PageService controller.
 *
 */
class PageServiceController extends Controller
{
    /**
     * Lists all PageService entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $pageServices = $em->getRepository('UnisystemPageBundle:PageService')->findBy(array(), array($sort => $direction));
        else $pageServices = $em->getRepository('UnisystemPageBundle:PageService')->findAll();
        $paginator = $this->get('knp_paginator');
        $pageServices = $paginator->paginate($pageServices, $request->query->getInt('page', 1), 25);

        return $this->render('pageservice/index.html.twig', array(
            'pageServices' => $pageServices,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new PageService entity.
     *
     */
    public function newAction(Request $request)
    {
        $pageService = new PageService();
        $form = $this->createForm('Unisystem\PageBundle\Form\PageServiceType', $pageService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageService);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pageService.created' );    

            return $this->redirectToRoute('page_service_show', array('id' => $pageService->getId()));
        }

        return $this->render('pageservice/new.html.twig', array(
            'pageService' => $pageService,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PageService entity.
     *
     */
    public function showAction(PageService $pageService)
    {
        $deleteForm = $this->createDeleteForm($pageService);

        return $this->render('pageservice/show.html.twig', array(
            'pageService' => $pageService,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PageService entity.
     *
     */
    public function editAction(Request $request, PageService $pageService)
    {
        $deleteForm = $this->createDeleteForm($pageService);
        $editForm = $this->createForm('Unisystem\PageBundle\Form\PageServiceType', $pageService);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pageService);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pageService.edited' );    

            return $this->redirectToRoute('page_service_edit', array('id' => $pageService->getId()));
        }

        return $this->render('pageservice/edit.html.twig', array(
            'pageService' => $pageService,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PageService entity.
     *
     */
    public function deleteAction(Request $request, PageService $pageService)
    {
        $form = $this->createDeleteForm($pageService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pageService);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'pageService.deleted' );    
        }

        return $this->redirectToRoute('page_service_index');
    }

    /**
     * Creates a form to delete a PageService entity.
     *
     * @param PageService $pageService The PageService entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PageService $pageService)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_service_delete', array('id' => $pageService->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
