<?php

namespace Unisystem\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\PageBundle\Entity\PagePhotography;
use Unisystem\PageBundle\Form\PagePhotographyType;

/**
 * PagePhotography controller.
 *
 */
class PagePhotographyController extends Controller
{
    /**
     * Lists all PagePhotography entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $pagePhotographies = $em->getRepository('UnisystemPageBundle:PagePhotography')->findBy(array(), array($sort => $direction));
        else $pagePhotographies = $em->getRepository('UnisystemPageBundle:PagePhotography')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagePhotographies = $paginator->paginate($pagePhotographies, $request->query->getInt('page', 1), 25);

        return $this->render('pagephotography/index.html.twig', array(
            'pagePhotographies' => $pagePhotographies,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new PagePhotography entity.
     *
     */
    public function newAction(Request $request)
    {
        $pagePhotography = new PagePhotography();
        $form = $this->createForm('Unisystem\PageBundle\Form\PagePhotographyType', $pagePhotography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagePhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pagePhotography.created' );    

            return $this->redirectToRoute('page_photography_show', array('id' => $pagePhotography->getId()));
        }

        return $this->render('pagephotography/new.html.twig', array(
            'pagePhotography' => $pagePhotography,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PagePhotography entity.
     *
     */
    public function showAction(PagePhotography $pagePhotography)
    {
        $deleteForm = $this->createDeleteForm($pagePhotography);

        return $this->render('pagephotography/show.html.twig', array(
            'pagePhotography' => $pagePhotography,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing PagePhotography entity.
     *
     */
    public function editAction(Request $request, PagePhotography $pagePhotography)
    {
        $deleteForm = $this->createDeleteForm($pagePhotography);
        $editForm = $this->createForm('Unisystem\PageBundle\Form\PagePhotographyType', $pagePhotography);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($pagePhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'pagePhotography.edited' );    

            return $this->redirectToRoute('page_photography_edit', array('id' => $pagePhotography->getId()));
        }

        return $this->render('pagephotography/edit.html.twig', array(
            'pagePhotography' => $pagePhotography,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a PagePhotography entity.
     *
     */
    public function deleteAction(Request $request, PagePhotography $pagePhotography)
    {
        $form = $this->createDeleteForm($pagePhotography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pagePhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'pagePhotography.deleted' );    
        }

        return $this->redirectToRoute('page_photography_index');
    }

    /**
     * Creates a form to delete a PagePhotography entity.
     *
     * @param PagePhotography $pagePhotography The PagePhotography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PagePhotography $pagePhotography)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_photography_delete', array('id' => $pagePhotography->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
