<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\AdminModule;
use Unisystem\AdminBundle\Form\AdminModuleType;

/**
 * AdminModule controller.
 *
 */
class AdminModuleController extends Controller
{
    /**
     * Lists all AdminModule entities.
     *
     */
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $adminModules = $em->getRepository('UnisystemAdminBundle:AdminModule')->findBy(array(), array($sort => $direction));
        else $adminModules = $em->getRepository('UnisystemAdminBundle:AdminModule')->findAll();
        $paginator = $this->get('knp_paginator');
        $adminModules = $paginator->paginate($adminModules, $request->query->getInt('page', 1), 25);

        return $this->render('adminmodule/index.html.twig', array(
            'adminModules' => $adminModules,
            'direction' => $direction,
            'sort' => $sort,
        ));
    }

    /**
     * Creates a new AdminModule entity.
     *
     */
    public function newAction(Request $request)
    {
        $adminModule = new AdminModule();
        $form = $this->createForm('Unisystem\AdminBundle\Form\AdminModuleType', $adminModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adminModule);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'adminModule.created' );    

            return $this->redirectToRoute('admin_module_show', array('id' => $adminModule->getId()));
        }

        return $this->render('adminmodule/new.html.twig', array(
            'adminModule' => $adminModule,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AdminModule entity.
     *
     */
    public function showAction(AdminModule $adminModule)
    {
        $deleteForm = $this->createDeleteForm($adminModule);

        return $this->render('adminmodule/show.html.twig', array(
            'adminModule' => $adminModule,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AdminModule entity.
     *
     */
    public function editAction(Request $request, AdminModule $adminModule)
    {
        $deleteForm = $this->createDeleteForm($adminModule);
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\AdminModuleType', $adminModule);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($adminModule);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'adminModule.edited' );    

            return $this->redirectToRoute('admin_module_edit', array('id' => $adminModule->getId()));
        }

        return $this->render('adminmodule/edit.html.twig', array(
            'adminModule' => $adminModule,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a AdminModule entity.
     *
     */
    public function deleteAction(Request $request, AdminModule $adminModule)
    {
        $form = $this->createDeleteForm($adminModule);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adminModule);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'adminModule.deleted' );    
        }

        return $this->redirectToRoute('admin_module_index');
    }

    /**
     * Creates a form to delete a AdminModule entity.
     *
     * @param AdminModule $adminModule The AdminModule entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AdminModule $adminModule)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_module_delete', array('id' => $adminModule->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
