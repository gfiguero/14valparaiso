<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\MemberRole;
use Unisystem\AdminBundle\Form\MemberRoleType;

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
        if($sort) $memberRoles = $em->getRepository('UnisystemAdminBundle:MemberRole')->findBy(array(), array($sort => $direction));
        else $memberRoles = $em->getRepository('UnisystemAdminBundle:MemberRole')->findAll();
        $paginator = $this->get('knp_paginator');
        $memberRoles = $paginator->paginate($memberRoles, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $memberRole = new MemberRole();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\MemberRoleType', $memberRole, array(
            'action' => $this->generateUrl('member_role_new'),
        ))->createView();

        foreach ($memberRoles as $key => $memberRole) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\MemberRoleType', $memberRole, array(
                'action' => $this->generateUrl('member_role_edit', array('id' => $memberRole->getId())),                
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($memberRole, array(
                'action' => $this->generateUrl('member_role_delete', array('id' => $memberRole->getId())),                
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:member.role.html.twig', array(
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
        $form = $this->createForm('Unisystem\AdminBundle\Form\MemberRoleType', $memberRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberRole);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'memberRole.created' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('UnisystemAdminBundle:MemberRole:new.html.twig', array(
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

        return $this->render('UnisystemAdminBundle:MemberRole:show.html.twig', array(
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
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\MemberRoleType', $memberRole);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($memberRole);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'memberRole.edited' );    

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('UnisystemAdminBundle:MemberRole:edit.html.twig', array(
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
