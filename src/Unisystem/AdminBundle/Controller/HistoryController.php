<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\History;
use Unisystem\AdminBundle\Form\HistoryType;

class HistoryController extends Controller
{
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        $histories = $em->getRepository('UnisystemAdminBundle:History')->getAdminList($sort, $direction);
        $paginator = $this->get('knp_paginator');
        $histories = $paginator->paginate($histories, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $history = new History();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\HistoryType', $history, array(
            'action' => $this->generateUrl('history_new'),
        ))->createView();

        foreach ($histories as $key => $history) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\HistoryType', $history, array(
                'action' => $this->generateUrl('history_edit', array('id' => $history->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($history, array(
                'action' => $this->generateUrl('history_delete', array('id' => $history->getId())),                
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:history.html.twig', array(
            'histories' => $histories,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new History entity.
     *
     */
    public function newAction(Request $request)
    {
        $history = new History();
        $form = $this->createForm('Unisystem\AdminBundle\Form\HistoryType', $history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($history);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'history.new.flash' );    

        }

        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * Finds and displays a History entity.
     *
     */
    public function showAction(History $history)
    {
        $deleteForm = $this->createDeleteForm($history);

        return $this->render('history/show.html.twig', array(
            'history' => $history,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing History entity.
     *
     */
    public function editAction(Request $request, History $history)
    {
        $deleteForm = $this->createDeleteForm($history);
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\HistoryType', $history);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($history);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'history.edit.flash' );    

        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Deletes a History entity.
     *
     */
    public function deleteAction(Request $request, History $history)
    {
        $form = $this->createDeleteForm($history);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($history);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'history.delete.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a History entity.
     *
     * @param History $history The History entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(History $history)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('history_delete', array('id' => $history->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
