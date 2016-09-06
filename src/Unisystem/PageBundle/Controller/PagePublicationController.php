<?php

namespace Unisystem\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\PageBundle\Entity\PagePublication;
use Unisystem\PageBundle\Form\PagePublicationType;

/**
 * PagePublication controller.
 *
 */
class PagePublicationController extends Controller
{
    /**
     * Lists all PagePublication entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $pagePublications = $em->getRepository('UnisystemPageBundle:PagePublication')->findBy(array(), array($sort => $direction));
        else $pagePublications = $em->getRepository('UnisystemPageBundle:PagePublication')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagePublications = $paginator->paginate($pagePublications, $request->query->getInt('page', 1), 25);

        return $this->render('pagepublication/index.html.twig', array(
            'pagePublications' => $pagePublications,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new PagePublication entity.
     *
     */
    public function newAction(Request $request)
    {
        $pagePublication = new PagePublication();
        $form = $this->createForm('Unisystem\PageBundle\Form\PagePublicationType', $pagePublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagePublication);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pagePublication.created' );    

            return $this->redirectToRoute('page_publication_show', array('id' => $pagePublication->getId()));
        }

        return $this->render('pagepublication/new.html.twig', array(
            'pagePublication' => $pagePublication,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PagePublication entity.
     *
     */
    public function showAction(PagePublication $pagePublication)
    {
        $deleteForm = $this->createDeleteForm($pagePublication);

        return $this->render('pagepublication/show.html.twig', array(
            'pagePublication' => $pagePublication,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PagePublication entity.
     *
     */
    public function editAction(Request $request, PagePublication $pagePublication)
    {
        $deleteForm = $this->createDeleteForm($pagePublication);
        $editForm = $this->createForm('Unisystem\PageBundle\Form\PagePublicationType', $pagePublication);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagePublication);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pagePublication.edited' );    

            return $this->redirectToRoute('page_publication_edit', array('id' => $pagePublication->getId()));
        }

        return $this->render('pagepublication/edit.html.twig', array(
            'pagePublication' => $pagePublication,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PagePublication entity.
     *
     */
    public function deleteAction(Request $request, PagePublication $pagePublication)
    {
        $form = $this->createDeleteForm($pagePublication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pagePublication);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'pagePublication.deleted' );    
        }

        return $this->redirectToRoute('page_publication_index');
    }

    /**
     * Creates a form to delete a PagePublication entity.
     *
     * @param PagePublication $pagePublication The PagePublication entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PagePublication $pagePublication)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_publication_delete', array('id' => $pagePublication->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
