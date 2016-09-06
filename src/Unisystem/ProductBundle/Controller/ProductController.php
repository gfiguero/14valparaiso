<?php

namespace Unisystem\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\ProductBundle\Entity\Product;
use Unisystem\ProductBundle\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $products = $em->getRepository('UnisystemProductBundle:Product')->findBy(array(), array($sort => $direction));
        else $products = $em->getRepository('UnisystemProductBundle:Product')->findAll();
        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate($products, $request->query->getInt('page', 1), 25);

        return $this->render('product/index.html.twig', array(
            'products' => $products,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Product entity.
     *
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm('Unisystem\ProductBundle\Form\ProductType', $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'product.created' );    

            return $this->redirectToRoute('product_show', array('id' => $product->getId()));
        }

        return $this->render('product/new.html.twig', array(
            'product' => $product,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction(Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('product/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction(Request $request, Product $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('Unisystem\ProductBundle\Form\ProductType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'product.edited' );    

            return $this->redirectToRoute('product_edit', array('id' => $product->getId()));
        }

        return $this->render('product/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, Product $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'product.deleted' );    
        }

        return $this->redirectToRoute('product_index');
    }

    /**
     * Creates a form to delete a Product entity.
     *
     * @param Product $product The Product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Product $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
