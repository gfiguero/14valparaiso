<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\Resource;
use Unisystem\AdminBundle\Form\ResourceType;

class ResourceController extends Controller
{
    public function indexAction(Request $request)
    {
        $sort = $request->query->get('sort');
        $direction = $request->query->get('direction');
        $em = $this->getDoctrine()->getManager();
        if($sort) $resources = $em->getRepository('UnisystemAdminBundle:Resource')->findBy(array(), array($sort => $direction));
        else $resources = $em->getRepository('UnisystemAdminBundle:Resource')->findAll();
        $paginator = $this->get('knp_paginator');
        $resources = $paginator->paginate($resources, $request->query->getInt('page', 1), 24);

        $deleteForms = array();
        $editForms = array();
        $resource = new Resource();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\ResourceType', $resource, array(
            'action' => $this->generateUrl('resource_new'),
        ))->createView();

        foreach ($resources as $key => $resource) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\ResourceType', $resource, array(
                'action' => $this->generateUrl('resource_edit', array('id' => $resource->getId())),
            ))->createView();
            $deleteForms[] = $this->createDeleteForm($resource, array(
                'action' => $this->generateUrl('resource_delete', array('id' => $resource->getId())),
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:resource.html.twig', array(
            'resources' => $resources,
            'direction' => $direction,
            'sort' => $sort,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new Resource entity.
     *
     */
    public function newAction(Request $request)
    {
        $resource = new Resource();
        $form = $this->createForm('Unisystem\AdminBundle\Form\ResourceType', $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resource);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'resource.new.flash' );

        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Displays a form to edit an existing Resource entity.
     *
     */
    public function editAction(Request $request, Resource $resource)
    {
        $deleteForm = $this->createDeleteForm($resource);
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\ResourceType', $resource);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resource);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'resource.edit.flash' );

            return $this->redirect($request->headers->get('referer'));
        }

        return $this->render('resource/edit.html.twig', array(
            'resource' => $resource,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Resource entity.
     *
     */
    public function deleteAction(Request $request, Resource $resource)
    {
        $form = $this->createDeleteForm($resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resource);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'resource.delete.flash' );
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a Resource entity.
     *
     * @param Resource $resource The Resource entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Resource $resource)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resource_delete', array('id' => $resource->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
