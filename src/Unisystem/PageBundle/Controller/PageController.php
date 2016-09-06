<?php

namespace Unisystem\PageBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\PageBundle\Entity\Page;
use Unisystem\PageBundle\Form\PageType;

/**
 * Page controller.
 *
 */
class PageController extends Controller
{
    /**
     * Lists all Page entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $pages = $em->getRepository('UnisystemPageBundle:Page')->findBy(array(), array($sort => $direction));
        else $pages = $em->getRepository('UnisystemPageBundle:Page')->findAll();
        $paginator = $this->get('knp_paginator');
        $pages = $paginator->paginate($pages, $request->query->getInt('page', 1), 25);

        return $this->render('page/index.html.twig', array(
            'pages' => $pages,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Page entity.
     *
     */
    public function newAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm('Unisystem\PageBundle\Form\PageType', $page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'page.created' );    

            return $this->redirectToRoute('page_show', array('id' => $page->getId()));
        }

        return $this->render('page/new.html.twig', array(
            'page' => $page,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Page entity.
     *
     */
    public function showAction(Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);

        return $this->render('page/show.html.twig', array(
            'page' => $page,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Page entity.
     *
     */
    public function editAction(Request $request, Page $page)
    {
        $deleteForm = $this->createDeleteForm($page);
        $editForm = $this->createForm('Unisystem\PageBundle\Form\PageType', $page);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($page);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'page.edited' );    

            return $this->redirectToRoute('page_edit', array('id' => $page->getId()));
        }

        return $this->render('page/edit.html.twig', array(
            'page' => $page,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Page entity.
     *
     */
    public function deleteAction(Request $request, Page $page)
    {
        $form = $this->createDeleteForm($page);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($page);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'page.deleted' );    
        }

        return $this->redirectToRoute('page_index');
    }

    /**
     * Creates a form to delete a Page entity.
     *
     * @param Page $page The Page entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Page $page)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('page_delete', array('id' => $page->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
