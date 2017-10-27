<?php

namespace WCS\CoavBundle\Controller;

use WCS\CoavBundle\Entity\Resevation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Resevation controller.
 *
 */
class ResevationController extends Controller
{
    /**
     * Lists all resevation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $resevations = $em->getRepository('WCSCoavBundle:Resevation')->findAll();

        return $this->render('resevation/index.html.twig', array(
            'resevations' => $resevations,
        ));
    }

    /**
     * Creates a new resevation entity.
     *
     */
    public function newAction(Request $request)
    {
        $resevation = new Resevation();
        $form = $this->createForm('WCS\CoavBundle\Form\ResevationType', $resevation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($resevation);
            $em->flush();

            return $this->redirectToRoute('resevation_show', array('id' => $resevation->getId()));
        }

        return $this->render('resevation/new.html.twig', array(
            'resevation' => $resevation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a resevation entity.
     *
     */
    public function showAction(Resevation $resevation)
    {
        $deleteForm = $this->createDeleteForm($resevation);

        return $this->render('resevation/show.html.twig', array(
            'resevation' => $resevation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing resevation entity.
     *
     */
    public function editAction(Request $request, Resevation $resevation)
    {
        $deleteForm = $this->createDeleteForm($resevation);
        $editForm = $this->createForm('WCS\CoavBundle\Form\ResevationType', $resevation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('resevation_edit', array('id' => $resevation->getId()));
        }

        return $this->render('resevation/edit.html.twig', array(
            'resevation' => $resevation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a resevation entity.
     *
     */
    public function deleteAction(Request $request, Resevation $resevation)
    {
        $form = $this->createDeleteForm($resevation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($resevation);
            $em->flush();
        }

        return $this->redirectToRoute('resevation_index');
    }

    /**
     * Creates a form to delete a resevation entity.
     *
     * @param Resevation $resevation The resevation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Resevation $resevation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('resevation_delete', array('id' => $resevation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
