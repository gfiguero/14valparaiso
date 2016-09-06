<?php

namespace Unisystem\ProductBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\ProductBundle\Entity\ProductCategory;
use Unisystem\ProductBundle\Form\ProductCategoryType;

/**
 * ProductCategory controller.
 *
 */
class ProductCategoryController extends Controller
{
    /**
     * Lists all ProductCategory entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $productCategories = $em->getRepository('UnisystemProductBundle:ProductCategory')->findBy(array(), array($sort => $direction));
        else $productCategories = $em->getRepository('UnisystemProductBundle:ProductCategory')->findAll();
        $paginator = $this->get('knp_paginator');
        $productCategories = $paginator->paginate($productCategories, $request->query->getInt('page', 1), 25);

        return $this->render('productcategory/index.html.twig', array(
            'productCategories' => $productCategories,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new ProductCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $productCategory = new ProductCategory();
        $form = $this->createForm('Unisystem\ProductBundle\Form\ProductCategoryType', $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'productCategory.created' );    

            return $this->redirectToRoute('product_category_show', array('id' => $productCategory->getId()));
        }

        return $this->render('productcategory/new.html.twig', array(
            'productCategory' => $productCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductCategory entity.
     *
     */
    public function showAction(ProductCategory $productCategory)
    {
        $deleteForm = $this->createDeleteForm($productCategory);

        return $this->render('productcategory/show.html.twig', array(
            'productCategory' => $productCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing ProductCategory entity.
     *
     */
    public function editAction(Request $request, ProductCategory $productCategory)
    {
        $deleteForm = $this->createDeleteForm($productCategory);
        $editForm = $this->createForm('Unisystem\ProductBundle\Form\ProductCategoryType', $productCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($productCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'productCategory.edited' );    

            return $this->redirectToRoute('product_category_edit', array('id' => $productCategory->getId()));
        }

        return $this->render('productcategory/edit.html.twig', array(
            'productCategory' => $productCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a ProductCategory entity.
     *
     */
    public function deleteAction(Request $request, ProductCategory $productCategory)
    {
        $form = $this->createDeleteForm($productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($productCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'productCategory.deleted' );    
        }

        return $this->redirectToRoute('product_category_index');
    }

    /**
     * Creates a form to delete a ProductCategory entity.
     *
     * @param ProductCategory $productCategory The ProductCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCategory $productCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_category_delete', array('id' => $productCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
