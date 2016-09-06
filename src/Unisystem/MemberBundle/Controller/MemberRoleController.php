<?php

namespace Unisystem\MemberBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\MemberBundle\Entity\MemberRole;
use Unisystem\MemberBundle\Form\MemberRoleType;

/**
 * MemberRole controller.
 *
 */
class MemberRoleController extends Controller
{
    /**
     * Lists all MemberRole entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $memberRoles = $em->getRepository('UnisystemMemberBundle:MemberRole')->findBy(array(), array($sort => $direction));
        else $memberRoles = $em->getRepository('UnisystemMemberBundle:MemberRole')->findAll();
        $paginator = $this->get('knp_paginator');
        $memberRoles = $paginator->paginate($memberRoles, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $memberRole = new MemberRole();
        $newForm = $this->createForm('Unisystem\MemberBundle\Form\MemberRoleType', $memberRole, array(
            'action' => $this->generateUrl('member_role_new'),
        ))->createView();

        foreach ($memberRoles as $key => $memberRole) {
            $editForms[] = $this->createForm('Unisystem\MemberBundle\Form\MemberRoleType', $memberRole, array(
                'action' => $this->generateUrl('member_role_edit', array('id' => $memberRole->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($memberRole, array(
                'action' => $this->generateUrl('member_role_delete', array('id' => $memberRole->getId())),                
            ))->createView();
        }

        return $this->render('memberrole/index.html.twig', array(
            'memberRoles' => $memberRoles,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new MemberRole entity.
     *
     */
    public function newAction(Request $request)
    {
        $memberRole = new MemberRole();
        $form = $this->createForm('Unisystem\MemberBundle\Form\MemberRoleType', $memberRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberRole);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'memberRole.created' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('memberrole/new.html.twig', array(
            'memberRole' => $memberRole,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MemberRole entity.
     *
     */
    public function showAction(MemberRole $memberRole)
    {
        $deleteForm = $this->createDeleteForm($memberRole);

        return $this->render('memberrole/show.html.twig', array(
            'memberRole' => $memberRole,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MemberRole entity.
     *
     */
    public function editAction(Request $request, MemberRole $memberRole)
    {
        $deleteForm = $this->createDeleteForm($memberRole);
        $editForm = $this->createForm('Unisystem\MemberBundle\Form\MemberRoleType', $memberRole);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberRole);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'memberRole.edited' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('memberrole/edit.html.twig', array(
            'memberRole' => $memberRole,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a MemberRole entity.
     *
     */
    public function deleteAction(Request $request, MemberRole $memberRole)
    {
        $form = $this->createDeleteForm($memberRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($memberRole);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'memberRole.deleted' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a MemberRole entity.
     *
     * @param MemberRole $memberRole The MemberRole entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MemberRole $memberRole)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('member_role_delete', array('id' => $memberRole->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
