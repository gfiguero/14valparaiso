<?php

namespace Unisystem\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\MemberBundle\Entity\Member;
use Unisystem\MemberBundle\Form\MemberType;

/**
 * Member controller.
 *
 */
class MemberController extends Controller
{
    /**
     * Lists all Member entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $members = $em->getRepository('UnisystemMemberBundle:Member')->findBy(array(), array($sort => $direction));
        else $members = $em->getRepository('UnisystemMemberBundle:Member')->findAll();
        $paginator = $this->get('knp_paginator');
        $members = $paginator->paginate($members, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $member = new Member();
        $member->setBirthDate(new \DateTime('1990-01-01'));
        $member->setAdmissionDate(new \DateTime('1990-01-01'));
        $newForm = $this->createForm('Unisystem\MemberBundle\Form\MemberType', $member, array(
            'action' => $this->generateUrl('member_new'),
        ))->createView();

        foreach ($members as $key => $member) {
            $editForms[] = $this->createForm('Unisystem\MemberBundle\Form\MemberType', $member, array(
                'action' => $this->generateUrl('member_edit', array('id' => $member->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($member, array(
                'action' => $this->generateUrl('member_delete', array('id' => $member->getId())),                
            ))->createView();
        }

        return $this->render('member/index.html.twig', array(
            'members' => $members,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Member entity.
     *
     */
    public function newAction(Request $request)
    {
        $member = new Member();
        $form = $this->createForm('Unisystem\MemberBundle\Form\MemberType', $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'member.created' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('member/new.html.twig', array(
            'member' => $member,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Member entity.
     *
     */
    public function showAction(Member $member)
    {
        $deleteForm = $this->createDeleteForm($member);

        return $this->render('member/show.html.twig', array(
            'member' => $member,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Member entity.
     *
     */
    public function editAction(Request $request, Member $member)
    {
        $deleteForm = $this->createDeleteForm($member);
        $editForm = $this->createForm('Unisystem\MemberBundle\Form\MemberType', $member);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($member);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'member.edited' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('member/edit.html.twig', array(
            'member' => $member,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Member entity.
     *
     */
    public function deleteAction(Request $request, Member $member)
    {
        $form = $this->createDeleteForm($member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($member);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'member.deleted' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Member entity.
     *
     * @param Member $member The Member entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Member $member)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('member_delete', array('id' => $member->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
