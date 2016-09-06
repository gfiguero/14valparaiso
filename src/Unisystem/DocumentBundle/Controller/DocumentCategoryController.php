<?php

namespace Unisystem\DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\DocumentBundle\Entity\DocumentCategory;
use Unisystem\DocumentBundle\Form\DocumentCategoryType;

/**
 * DocumentCategory controller.
 *
 */
class DocumentCategoryController extends Controller
{
    /**
     * Lists all DocumentCategory entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $documentCategories = $em->getRepository('UnisystemDocumentBundle:DocumentCategory')->findBy(array(), array($sort => $direction));
        else $documentCategories = $em->getRepository('UnisystemDocumentBundle:DocumentCategory')->findAll();
        $paginator = $this->get('knp_paginator');
        $documentCategories = $paginator->paginate($documentCategories, $request->query->getInt('page', 1), 25);

        return $this->render('documentcategory/index.html.twig', array(
            'documentCategories' => $documentCategories,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new DocumentCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $documentCategory = new DocumentCategory();
        $form = $this->createForm('Unisystem\DocumentBundle\Form\DocumentCategoryType', $documentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($documentCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'documentCategory.created' );    

            return $this->redirectToRoute('document_category_show', array('id' => $documentCategory->getId()));
        }

        return $this->render('documentcategory/new.html.twig', array(
            'documentCategory' => $documentCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a DocumentCategory entity.
     *
     */
    public function showAction(DocumentCategory $documentCategory)
    {
        $deleteForm = $this->createDeleteForm($documentCategory);

        return $this->render('documentcategory/show.html.twig', array(
            'documentCategory' => $documentCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing DocumentCategory entity.
     *
     */
    public function editAction(Request $request, DocumentCategory $documentCategory)
    {
        $deleteForm = $this->createDeleteForm($documentCategory);
        $editForm = $this->createForm('Unisystem\DocumentBundle\Form\DocumentCategoryType', $documentCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($documentCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'documentCategory.edited' );    

            return $this->redirectToRoute('document_category_edit', array('id' => $documentCategory->getId()));
        }

        return $this->render('documentcategory/edit.html.twig', array(
            'documentCategory' => $documentCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a DocumentCategory entity.
     *
     */
    public function deleteAction(Request $request, DocumentCategory $documentCategory)
    {
        $form = $this->createDeleteForm($documentCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($documentCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'documentCategory.deleted' );    
        }

        return $this->redirectToRoute('document_category_index');
    }

    /**
     * Creates a form to delete a DocumentCategory entity.
     *
     * @param DocumentCategory $documentCategory The DocumentCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DocumentCategory $documentCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_category_delete', array('id' => $documentCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
