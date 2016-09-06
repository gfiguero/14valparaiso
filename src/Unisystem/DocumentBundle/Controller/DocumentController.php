<?php

namespace Unisystem\DocumentBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\DocumentBundle\Entity\Document;
use Unisystem\DocumentBundle\Form\DocumentType;

/**
 * Document controller.
 *
 */
class DocumentController extends Controller
{
    /**
     * Lists all Document entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $documents = $em->getRepository('UnisystemDocumentBundle:Document')->findBy(array(), array($sort => $direction));
        else $documents = $em->getRepository('UnisystemDocumentBundle:Document')->findAll();
        $paginator = $this->get('knp_paginator');
        $documents = $paginator->paginate($documents, $request->query->getInt('page', 1), 25);

        return $this->render('document/index.html.twig', array(
            'documents' => $documents,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Document entity.
     *
     */
    public function newAction(Request $request)
    {
        $document = new Document();
        $form = $this->createForm('Unisystem\DocumentBundle\Form\DocumentType', $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'document.created' );    

            return $this->redirectToRoute('document_show', array('id' => $document->getId()));
        }

        return $this->render('document/new.html.twig', array(
            'document' => $document,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Document entity.
     *
     */
    public function showAction(Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);

        return $this->render('document/show.html.twig', array(
            'document' => $document,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Document entity.
     *
     */
    public function editAction(Request $request, Document $document)
    {
        $deleteForm = $this->createDeleteForm($document);
        $editForm = $this->createForm('Unisystem\DocumentBundle\Form\DocumentType', $document);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($document);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'document.edited' );    

            return $this->redirectToRoute('document_edit', array('id' => $document->getId()));
        }

        return $this->render('document/edit.html.twig', array(
            'document' => $document,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Document entity.
     *
     */
    public function deleteAction(Request $request, Document $document)
    {
        $form = $this->createDeleteForm($document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($document);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'document.deleted' );    
        }

        return $this->redirectToRoute('document_index');
    }

    /**
     * Creates a form to delete a Document entity.
     *
     * @param Document $document The Document entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Document $document)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('document_delete', array('id' => $document->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
