<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Collections\ArrayCollection;

use Unisystem\AdminBundle\Entity\Notice;
use Unisystem\AdminBundle\Form\NoticeType;

/**
 * Notice controller.
 *
 */
class NoticeController extends Controller
{
    /**
     * Lists all Notice entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        $notices = $em->getRepository('UnisystemAdminBundle:Notice')->getAdminList($sort, $direction);
        $paginator = $this->get('knp_paginator');
        $notices = $paginator->paginate($notices, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $notice = new Notice();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\NoticeType', $notice, array(
            'action' => $this->generateUrl('notice_new'),
        ))->createView();

        foreach ($notices as $key => $notice) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\NoticeType', $notice, array(
                'action' => $this->generateUrl('notice_edit', array('id' => $notice->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($notice, array(
                'action' => $this->generateUrl('notice_delete', array('id' => $notice->getId())),                
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:notice.html.twig', array(
            'notices' => $notices,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));

    }

    /**
     * Creates a new Notice entity.
     *
     */
    public function newAction(Request $request)
    {

        $notice = new Notice();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\NoticeType', $notice);
        $newForm->handleRequest($request);

        if ($newForm->isSubmitted() && $newForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'notice.new.flash' );    
            return $this->redirect($this->generateUrl('notice_index'));

        }

        return $this->render('UnisystemAdminBundle:Notice:new.html.twig', array(
            'newForm' => $newForm->createView(),
        ));

    }

    /**
     * Displays a form to edit an existing Notice entity.
     *
     */
    public function editAction(Request $request, Notice $notice)
    {

        $deleteForm = $this->createDeleteForm($notice);
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\NoticeType', $notice);

        $originalPhotographies = new ArrayCollection();
        foreach ($notice->getPhotographies() as $photography) {
            $originalPhotographies->add($photography);
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $newPhotographies = $notice->getPhotographies();
            foreach ($originalPhotographies as $originalPhotography) {
                if (false === $newPhotographies->contains($originalPhotography)) {
                    $em->remove($originalPhotography);
                }
            }

            $em->persist($notice);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'notice.edit.flash' );    
            return $this->redirect($this->generateUrl('notice_index'));

        }

        return $this->render('UnisystemAdminBundle:Notice:edit.html.twig', array(
            'editForm' => $editForm->createView(),
        ));

    }

    /**
     * Deletes a Notice entity.
     *
     */
    public function deleteAction(Request $request, Notice $notice)
    {
        $form = $this->createDeleteForm($notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($notice);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'notice.delete.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Notice entity.
     *
     * @param Notice $notice The Notice entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Notice $notice)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_delete', array('id' => $notice->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
