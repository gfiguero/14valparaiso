<?php

namespace Unisystem\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\ProductBundle\Entity\ProductPhotography;
use Unisystem\ProductBundle\Form\ProductPhotographyType;

/**
 * ProductPhotography controller.
 *
 */
class ProductPhotographyController extends Controller
{
    /**
     * Lists all ProductPhotography entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $productPhotographies = $em->getRepository('UnisystemProductBundle:ProductPhotography')->findBy(array(), array($sort => $direction));
        else $productPhotographies = $em->getRepository('UnisystemProductBundle:ProductPhotography')->findAll();
        $paginator = $this->get('knp_paginator');
        $productPhotographies = $paginator->paginate($productPhotographies, $request->query->getInt('page', 1), 25);

        return $this->render('productphotography/index.html.twig', array(
            'productPhotographies' => $productPhotographies,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new ProductPhotography entity.
     *
     */
    public function newAction(Request $request)
    {
        $productPhotography = new ProductPhotography();
        $form = $this->createForm('Unisystem\ProductBundle\Form\ProductPhotographyType', $productPhotography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productPhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'productPhotography.created' );    

            return $this->redirectToRoute('product_photography_show', array('id' => $productPhotography->getId()));
        }

        return $this->render('productphotography/new.html.twig', array(
            'productPhotography' => $productPhotography,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductPhotography entity.
     *
     */
    public function showAction(ProductPhotography $productPhotography)
    {
        $deleteForm = $this->createDeleteForm($productPhotography);

        return $this->render('productphotography/show.html.twig', array(
            'productPhotography' => $productPhotography,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ProductPhotography entity.
     *
     */
    public function editAction(Request $request, ProductPhotography $productPhotography)
    {
        $deleteForm = $this->createDeleteForm($productPhotography);
        $editForm = $this->createForm('Unisystem\ProductBundle\Form\ProductPhotographyType', $productPhotography);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productPhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'productPhotography.edited' );    

            return $this->redirectToRoute('product_photography_edit', array('id' => $productPhotography->getId()));
        }

        return $this->render('productphotography/edit.html.twig', array(
            'productPhotography' => $productPhotography,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ProductPhotography entity.
     *
     */
    public function deleteAction(Request $request, ProductPhotography $productPhotography)
    {
        $form = $this->createDeleteForm($productPhotography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productPhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'productPhotography.deleted' );    
        }

        return $this->redirectToRoute('product_photography_index');
    }

    /**
     * Creates a form to delete a ProductPhotography entity.
     *
     * @param ProductPhotography $productPhotography The ProductPhotography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductPhotography $productPhotography)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_photography_delete', array('id' => $productPhotography->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
