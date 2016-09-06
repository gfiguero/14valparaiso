<?php

namespace Unisystem\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\ProductBundle\Entity\ProductProperty;
use Unisystem\ProductBundle\Form\ProductPropertyType;

/**
 * ProductProperty controller.
 *
 */
class ProductPropertyController extends Controller
{
    /**
     * Lists all ProductProperty entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $productProperties = $em->getRepository('UnisystemProductBundle:ProductProperty')->findBy(array(), array($sort => $direction));
        else $productProperties = $em->getRepository('UnisystemProductBundle:ProductProperty')->findAll();
        $paginator = $this->get('knp_paginator');
        $productProperties = $paginator->paginate($productProperties, $request->query->getInt('page', 1), 25);

        return $this->render('productproperty/index.html.twig', array(
            'productProperties' => $productProperties,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new ProductProperty entity.
     *
     */
    public function newAction(Request $request)
    {
        $productProperty = new ProductProperty();
        $form = $this->createForm('Unisystem\ProductBundle\Form\ProductPropertyType', $productProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productProperty);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'productProperty.created' );    

            return $this->redirectToRoute('product_property_show', array('id' => $productProperty->getId()));
        }

        return $this->render('productproperty/new.html.twig', array(
            'productProperty' => $productProperty,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductProperty entity.
     *
     */
    public function showAction(ProductProperty $productProperty)
    {
        $deleteForm = $this->createDeleteForm($productProperty);

        return $this->render('productproperty/show.html.twig', array(
            'productProperty' => $productProperty,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ProductProperty entity.
     *
     */
    public function editAction(Request $request, ProductProperty $productProperty)
    {
        $deleteForm = $this->createDeleteForm($productProperty);
        $editForm = $this->createForm('Unisystem\ProductBundle\Form\ProductPropertyType', $productProperty);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productProperty);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'productProperty.edited' );    

            return $this->redirectToRoute('product_property_edit', array('id' => $productProperty->getId()));
        }

        return $this->render('productproperty/edit.html.twig', array(
            'productProperty' => $productProperty,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ProductProperty entity.
     *
     */
    public function deleteAction(Request $request, ProductProperty $productProperty)
    {
        $form = $this->createDeleteForm($productProperty);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productProperty);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'productProperty.deleted' );    
        }

        return $this->redirectToRoute('product_property_index');
    }

    /**
     * Creates a form to delete a ProductProperty entity.
     *
     * @param ProductProperty $productProperty The ProductProperty entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductProperty $productProperty)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_property_delete', array('id' => $productProperty->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
