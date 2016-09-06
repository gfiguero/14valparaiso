<?php

namespace Unisystem\NoticeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\NoticeBundle\Entity\Notice;
use Unisystem\NoticeBundle\Form\NoticeType;

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
        if($sort) $notices = $em->getRepository('UnisystemNoticeBundle:Notice')->findBy(array(), array($sort => $direction));
        else $notices = $em->getRepository('UnisystemNoticeBundle:Notice')->findAll();
        $paginator = $this->get('knp_paginator');
        $notices = $paginator->paginate($notices, $request->query->getInt('page', 1), 25);

        return $this->render('notice/index.html.twig', array(
            'notices' => $notices,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new Notice entity.
     *
     */
    public function newAction(Request $request)
    {
        $notice = new Notice();
        $form = $this->createForm('Unisystem\NoticeBundle\Form\NoticeType', $notice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'notice.created' );    

            return $this->redirectToRoute('notice_show', array('id' => $notice->getId()));
        }

        return $this->render('notice/new.html.twig', array(
            'notice' => $notice,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Notice entity.
     *
     */
    public function showAction(Notice $notice)
    {
        $deleteForm = $this->createDeleteForm($notice);

        return $this->render('notice/show.html.twig', array(
            'notice' => $notice,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Notice entity.
     *
     */
    public function editAction(Request $request, Notice $notice)
    {
        $deleteForm = $this->createDeleteForm($notice);
        $editForm = $this->createForm('Unisystem\NoticeBundle\Form\NoticeType', $notice);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($notice);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'notice.edited' );    

            return $this->redirectToRoute('notice_edit', array('id' => $notice->getId()));
        }

        return $this->render('notice/edit.html.twig', array(
            'notice' => $notice,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
            $request->getSession()->getFlashBag()->add( 'danger', 'notice.deleted' );    
        }

        return $this->redirectToRoute('notice_index');
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
