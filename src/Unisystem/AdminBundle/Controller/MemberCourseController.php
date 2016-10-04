<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\MemberCourse;
use Unisystem\AdminBundle\Form\MemberCourseType;

/**
 * MemberCourse controller.
 *
 */
class MemberCourseController extends Controller
{
    /**
     * Lists all MemberCourse entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $memberCourses = $em->getRepository('UnisystemAdminBundle:MemberCourse')->findBy(array(), array($sort => $direction));
        else $memberCourses = $em->getRepository('UnisystemAdminBundle:MemberCourse')->findAll();
        $paginator = $this->get('knp_paginator');
        $memberCourses = $paginator->paginate($memberCourses, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $memberCourse = new MemberCourse();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\MemberCourseType', $memberCourse, array(
            'action' => $this->generateUrl('member_course_new'),
        ))->createView();

        foreach ($memberCourses as $key => $memberCourse) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\MemberCourseType', $memberCourse, array(
                'action' => $this->generateUrl('member_course_edit', array('id' => $memberCourse->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($memberCourse, array(
                'action' => $this->generateUrl('member_course_delete', array('id' => $memberCourse->getId())),                
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:member.course.html.twig', array(
            'memberCourses' => $memberCourses,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new MemberCourse entity.
     *
     */
    public function newAction(Request $request)
    {
        $memberCourse = new MemberCourse();
        $form = $this->createForm('Unisystem\AdminBundle\Form\MemberCourseType', $memberCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberCourse);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'membercourse.flash.created' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('UnisystemAdminBundle:MemberCourse:new.html.twig', array(
            'memberCourse' => $memberCourse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MemberCourse entity.
     *
     */
    public function showAction(MemberCourse $memberCourse)
    {
        $deleteForm = $this->createDeleteForm($memberCourse);

        return $this->render('UnisystemAdminBundle:MemberCourse:show.html.twig', array(
            'memberCourse' => $memberCourse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MemberCourse entity.
     *
     */
    public function editAction(Request $request, MemberCourse $memberCourse)
    {
        $deleteForm = $this->createDeleteForm($memberCourse);
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\MemberCourseType', $memberCourse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberCourse);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'membercourse.flash.edited' );

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('UnisystemAdminBundle:MemberCourse:edit.html.twig', array(
            'memberCourse' => $memberCourse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MemberCourse entity.
     *
     */
    public function deleteAction(Request $request, MemberCourse $memberCourse)
    {
        $form = $this->createDeleteForm($memberCourse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($memberCourse);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'membercourse.flash.deleted' );
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a MemberCourse entity.
     *
     * @param MemberCourse $memberCourse The MemberCourse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MemberCourse $memberCourse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('member_course_delete', array('id' => $memberCourse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
