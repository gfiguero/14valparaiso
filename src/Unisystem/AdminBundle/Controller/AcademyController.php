<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\Academy;
use Unisystem\AdminBundle\Form\AcademyType;

class AcademyController extends Controller
{
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($request->get('_route') == 'academy_future') $academies = $em->getRepository('UnisystemAdminBundle:Academy')->getFutureList($sort, $direction);
        if($request->get('_route') == 'academy_past') $academies = $em->getRepository('UnisystemAdminBundle:Academy')->getPastList($sort, $direction);
        $paginator = $this->get('knp_paginator');
        $academies = $paginator->paginate($academies, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $academy = new Academy();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\AcademyType', $academy, array(
            'action' => $this->generateUrl('academy_new'),
        ))->createView();

        foreach ($academies as $key => $academy) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\AcademyType', $academy, array(
                'action' => $this->generateUrl('academy_edit', array('id' => $academy->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($academy, array(
                'action' => $this->generateUrl('academy_delete', array('id' => $academy->getId())),                
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:academy.html.twig', array(
            'academies' => $academies,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Academy entity.
     *
     */
    public function newAction(Request $request)
    {
        $academy = new Academy();
        $form = $this->createForm('Unisystem\AdminBundle\Form\AcademyType', $academy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($academy);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'academy.new.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * Finds and displays a Academy entity.
     *
     */
    public function showAction(Academy $academy)
    {
        $deleteForm = $this->createDeleteForm($academy);

        return $this->render('academy/show.html.twig', array(
            'academy' => $academy,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Academy entity.
     *
     */
    public function editAction(Request $request, Academy $academy)
    {
        $deleteForm = $this->createDeleteForm($academy);
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\AcademyType', $academy);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($academy);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'academy.edit.flash' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('academy/edit.html.twig', array(
            'academy' => $academy,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Academy entity.
     *
     */
    public function deleteAction(Request $request, Academy $academy)
    {
        $form = $this->createDeleteForm($academy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($academy);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'academy.delete.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Academy entity.
     *
     * @param Academy $academy The Academy entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Academy $academy)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('academy_delete', array('id' => $academy->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
