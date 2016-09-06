<?php

namespace Unisystem\ProcessBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\ProcessBundle\Entity\Stage;
use Unisystem\ProcessBundle\Form\StageType;

class StageController extends Controller
{
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $stages = $em->getRepository('UnisystemProcessBundle:Stage')->findBy(array(), array($sort => $direction));
        else $stages = $em->getRepository('UnisystemProcessBundle:Stage')->findAll();
        $paginator = $this->get('knp_paginator');
        $stages = $paginator->paginate($stages, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $stage = new Stage();
        $newForm = $this->createForm('Unisystem\ProcessBundle\Form\StageType', $stage, array(
            'action' => $this->generateUrl('stage_new'),
        ))->createView();

        foreach ($stages as $key => $stage) {
            $editForms[] = $this->createForm('Unisystem\ProcessBundle\Form\StageType', $stage, array(
                'action' => $this->generateUrl('stage_edit', array('id' => $stage->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($stage, array(
                'action' => $this->generateUrl('stage_delete', array('id' => $stage->getId())),                
            ))->createView();
        }

        return $this->render('stage/index.html.twig', array(
            'stages' => $stages,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Stage entity.
     *
     */
    public function newAction(Request $request)
    {
        $stage = new Stage();
        $form = $this->createForm('Unisystem\ProcessBundle\Form\StageType', $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'stage.new.flash' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('stage/new.html.twig', array(
            'stage' => $stage,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Stage entity.
     *
     */
    public function showAction(Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);

        return $this->render('stage/show.html.twig', array(
            'stage' => $stage,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Stage entity.
     *
     */
    public function editAction(Request $request, Stage $stage)
    {
        $deleteForm = $this->createDeleteForm($stage);
        $editForm = $this->createForm('Unisystem\ProcessBundle\Form\StageType', $stage);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'stage.edit.flash' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('stage/edit.html.twig', array(
            'stage' => $stage,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Stage entity.
     *
     */
    public function deleteAction(Request $request, Stage $stage)
    {
        $form = $this->createDeleteForm($stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stage);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'stage.delete.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Stage entity.
     *
     * @param Stage $stage The Stage entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Stage $stage)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('stage_delete', array('id' => $stage->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
