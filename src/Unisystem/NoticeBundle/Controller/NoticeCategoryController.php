<?php

namespace Unisystem\NoticeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\NoticeBundle\Entity\NoticeCategory;
use Unisystem\NoticeBundle\Form\NoticeCategoryType;

/**
 * NoticeCategory controller.
 *
 */
class NoticeCategoryController extends Controller
{
    /**
     * Lists all NoticeCategory entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $noticeCategories = $em->getRepository('UnisystemNoticeBundle:NoticeCategory')->findBy(array(), array($sort => $direction));
        else $noticeCategories = $em->getRepository('UnisystemNoticeBundle:NoticeCategory')->findAll();
        $paginator = $this->get('knp_paginator');
        $noticeCategories = $paginator->paginate($noticeCategories, $request->query->getInt('page', 1), 25);

        return $this->render('noticecategory/index.html.twig', array(
            'noticeCategories' => $noticeCategories,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new NoticeCategory entity.
     *
     */
    public function newAction(Request $request)
    {
        $noticeCategory = new NoticeCategory();
        $form = $this->createForm('Unisystem\NoticeBundle\Form\NoticeCategoryType', $noticeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noticeCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'noticeCategory.created' );    

            return $this->redirectToRoute('notice_category_show', array('id' => $noticeCategory->getId()));
        }

        return $this->render('noticecategory/new.html.twig', array(
            'noticeCategory' => $noticeCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a NoticeCategory entity.
     *
     */
    public function showAction(NoticeCategory $noticeCategory)
    {
        $deleteForm = $this->createDeleteForm($noticeCategory);

        return $this->render('noticecategory/show.html.twig', array(
            'noticeCategory' => $noticeCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing NoticeCategory entity.
     *
     */
    public function editAction(Request $request, NoticeCategory $noticeCategory)
    {
        $deleteForm = $this->createDeleteForm($noticeCategory);
        $editForm = $this->createForm('Unisystem\NoticeBundle\Form\NoticeCategoryType', $noticeCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($noticeCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'noticeCategory.edited' );    

            return $this->redirectToRoute('notice_category_edit', array('id' => $noticeCategory->getId()));
        }

        return $this->render('noticecategory/edit.html.twig', array(
            'noticeCategory' => $noticeCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a NoticeCategory entity.
     *
     */
    public function deleteAction(Request $request, NoticeCategory $noticeCategory)
    {
        $form = $this->createDeleteForm($noticeCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($noticeCategory);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'noticeCategory.deleted' );    
        }

        return $this->redirectToRoute('notice_category_index');
    }

    /**
     * Creates a form to delete a NoticeCategory entity.
     *
     * @param NoticeCategory $noticeCategory The NoticeCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(NoticeCategory $noticeCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_category_delete', array('id' => $noticeCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
