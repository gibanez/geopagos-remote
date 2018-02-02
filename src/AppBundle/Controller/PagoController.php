<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pago;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pago controller.
 *
 * @Route("pago")
 */
class PagoController extends Controller
{
    /**
     * Lists all pago entities.
     *
     * @Route("/", name="pago_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pagos = $em->getRepository('AppBundle:Pago')->findAll();

        return $this->render('pago/index.html.twig', array(
            'pagos' => $pagos,
        ));
    }

    /**
     * Creates a new pago entity.
     *
     * @Route("/new", name="pago_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $pago = new Pago();
        $form = $this->createForm('AppBundle\Form\PagoType', $pago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();

            foreach ($pago->getUsuarios() as $user)
            {
                $pago->addUsuario($user);
            }

            $em->persist($pago);
            $em->flush();

            return $this->redirectToRoute('pago_show', array('codigoPago' => $pago->getCodigopago()));
        }

        return $this->render('pago/new.html.twig', array(
            'pago' => $pago,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a pago entity.
     *
     * @Route("/{codigoPago}", name="pago_show")
     * @Method("GET")
     */
    public function showAction(Pago $pago)
    {
        $deleteForm = $this->createDeleteForm($pago);

        return $this->render('pago/show.html.twig', array(
            'pago' => $pago,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pago entity.
     *
     * @Route("/{codigoPago}/edit", name="pago_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Pago $pago)
    {
        $users = $this->cloneCollection($pago);
        $deleteForm = $this->createDeleteForm($pago);
        $editForm = $this->createForm('AppBundle\Form\PagoType', $pago);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $usersEdit = $this->cloneCollection($pago);
            $this->deleteUsuarios($users, $pago);

            foreach ($usersEdit as $user)
            {
                $pago->addUsuario($user);
            }
            $em->flush();

            return $this->redirectToRoute('pago_edit', array('codigoPago' => $pago->getCodigopago()));
        }

        return $this->render('pago/edit.html.twig', array(
            'pago' => $pago,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    private function deleteUsuarios($collection, Pago $pago)
    {
        foreach ($collection as $user)
        {
            $pago->removeUsuario($user);
        }
    }

    private function cloneCollection(Pago $pago)
    {
        $collection = new ArrayCollection();
        $users = $pago->getUsuarios();
        foreach ($users as $user)
        {
            $collection->add($user);
        }
        return $collection;
    }

    /**
     * Deletes a pago entity.
     *
     * @Route("/{codigoPago}", name="pago_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Pago $pago)
    {
        $form = $this->createDeleteForm($pago);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {



            $em = $this->getDoctrine()->getManager();
            $em->remove($pago);
            $em->flush();
        }

        return $this->redirectToRoute('pago_index');
    }

    /**
     * Creates a form to delete a pago entity.
     *
     * @param Pago $pago The pago entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pago $pago)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pago_delete', array('codigoPago' => $pago->getCodigopago())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
