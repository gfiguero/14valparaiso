<?php

namespace Unisystem\NoticeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\NoticeBundle\Entity\NoticePhotography;
use Unisystem\NoticeBundle\Form\NoticePhotographyType;

/**
 * NoticePhotography controller.
 *
 */
class NoticePhotographyController extends Controller
{
    /**
     * Lists all NoticePhotography entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $noticePhotographies = $em->getRepository('UnisystemNoticeBundle:NoticePhotography')->findBy(array(), array($sort => $direction));
        else $noticePhotographies = $em->getRepository('UnisystemNoticeBundle:NoticePhotography')->findAll();
        $paginator = $this->get('knp_paginator');
        $noticePhotographies = $paginator->paginate($noticePhotographies, $request->query->getInt('page', 1), 25);

        return $this->render('noticephotography/index.html.twig', array(
            'noticePhotographies' => $noticePhotographies,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new NoticePhotography entity.
     *
     */
    public function newAction(Request $request)
    {
        $noticePhotography = new NoticePhotography();
        $form = $this->createForm('Unisystem\NoticeBundle\Form\NoticePhotographyType', $noticePhotography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noticePhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'noticePhotography.created' );    

            return $this->redirectToRoute('notice_photography_show', array('id' => $noticePhotography->getId()));
        }

        return $this->render('noticephotography/new.html.twig', array(
            'noticePhotography' => $noticePhotography,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a NoticePhotography entity.
     *
     */
    public function showAction(NoticePhotography $noticePhotography)
    {
        $deleteForm = $this->createDeleteForm($noticePhotography);

        return $this->render('noticephotography/show.html.twig', array(
            'noticePhotography' => $noticePhotography,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing NoticePhotography entity.
     *
     */
    public function editAction(Request $request, NoticePhotography $noticePhotography)
    {
        $deleteForm = $this->createDeleteForm($noticePhotography);
        $editForm = $this->createForm('Unisystem\NoticeBundle\Form\NoticePhotographyType', $noticePhotography);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noticePhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'noticePhotography.edited' );    

            return $this->redirectToRoute('notice_photography_edit', array('id' => $noticePhotography->getId()));
        }

        return $this->render('noticephotography/edit.html.twig', array(
            'noticePhotography' => $noticePhotography,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a NoticePhotography entity.
     *
     */
    public function deleteAction(Request $request, NoticePhotography $noticePhotography)
    {
        $form = $this->createDeleteForm($noticePhotography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($noticePhotography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'noticePhotography.deleted' );    
        }

        return $this->redirectToRoute('notice_photography_index');
    }

    /**
     * Creates a form to delete a NoticePhotography entity.
     *
     * @param NoticePhotography $noticePhotography The NoticePhotography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NoticePhotography $noticePhotography)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_photography_delete', array('id' => $noticePhotography->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
