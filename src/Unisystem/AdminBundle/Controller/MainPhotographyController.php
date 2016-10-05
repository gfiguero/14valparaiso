<?php

namespace Unisystem\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Unisystem\AdminBundle\Entity\MainPhotography;
use Unisystem\AdminBundle\Form\MainPhotographyType;

class MainPhotographyController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $photographies = $em->getRepository('UnisystemAdminBundle:MainPhotography')->findAll();

        $deleteForms = array();
        $editForms = array();
        $photography = new MainPhotography();
        $newForm = $this->createForm('Unisystem\AdminBundle\Form\MainPhotographyType', $photography, array(
            'action' => $this->generateUrl('main_photography_new'),
        ))->createView();

        foreach ($photographies as $key => $photography) {
            $editForms[] = $this->createForm('Unisystem\AdminBundle\Form\MainPhotographyType', $photography, array(
                'action' => $this->generateUrl('main_photography_edit', array('id' => $photography->getId())),                
            ))->remove('file')->createView();
            $deleteForms[] = $this->createDeleteForm($photography, array(
                'action' => $this->generateUrl('main_photography_delete', array('id' => $photography->getId())),                
            ))->createView();
        }

        return $this->render('UnisystemAdminBundle:Module:main.photography.html.twig', array(
            'photographies' => $photographies,
            'newForm' => $newForm,
            'editForms' => $editForms,
            'deleteForms' => $deleteForms,
        ));
    }

    /**
     * Creates a new MainPhotography entity.
     *
     */
    public function newAction(Request $request)
    {
        $photography = new MainPhotography();
        $form = $this->createForm('Unisystem\AdminBundle\Form\MainPhotographyType', $photography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'main.photography.new.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));

    }

    /**
     * Displays a form to edit an existing MainPhotography entity.
     *
     */
    public function editAction(Request $request, MainPhotography $photography)
    {
        $editForm = $this->createForm('Unisystem\AdminBundle\Form\MainPhotographyType', $photography);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($photography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'success', 'main.photography.edit.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Deletes a MainPhotography entity.
     *
     */
    public function deleteAction(Request $request, MainPhotography $photography)
    {
        $form = $this->createDeleteForm($photography);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photography);
            $em->flush();
            $request->getSession()->getFlashBag()->add( 'danger', 'main.photography.delete.flash' );    
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * Creates a form to delete a MainPhotography entity.
     *
     * @param MainPhotography $photography The MainPhotography entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MainPhotography $photography)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('main_photography_delete', array('id' => $photography->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
