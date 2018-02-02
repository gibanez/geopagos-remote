<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use AppBundle\Form\UsuarioFavoritoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usuario controller.
 *
 * @Route("usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all usuario entities.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();

        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios
        ));
    }

    /**
     * Creates a new usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($usuario);
            $em->flush();

            return $this->redirectToRoute('usuario_show', array('codigoUsuario' => $usuario->getCodigousuario()));
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a usuario entity.
     *
     * @Route("/{codigoUsuario}", name="usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/{codigoUsuario}/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuarioFavoritoType', $usuario);
        $editForm->handleRequest($request);
        $editForm->remove('clave');

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_edit', array('codigoUsuario' => $usuario->getCodigousuario()));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a usuario entity.
     *
     * @Route("/{codigoUsuario}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('codigoUsuario' => $usuario->getCodigousuario())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Finds and displays a usuario entity.
     *
     * @Route("/{codigoUsuario}/pagos", name="usuario_pago")
     * @Method("GET")
     */
    public function listPagosAction(Usuario $usuario)
    {
        return $this->render('usuario/pagos.html.twig', array(
            'usuario' => $usuario
        ));
    }

    /**
     * Finds and displays a usuario entity.
     *
     * @Route("/{codigoUsuario}/favortios", name="usuario_favoritos")
     * @Method("GET")
     */
    public function listFavoritosAction(Usuario $usuario)
    {
        return $this->render('usuario/favoritos.html.twig', array(
            'usuario' => $usuario
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/{codigoUsuario}/favorito/nuevo", name="usuario_favorito_nuevo")
     * @Method({"GET", "POST"})
     */
    public function addFavoriteAction(Request $request, Usuario $usuario)
    {


        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm(UsuarioFavoritoType::class, new Usuario());
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted())
        {

            $favorito = $this->getFavorite($request, $editForm);
            $usuario->addFavorito($favorito);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usuario_favoritos', array('codigoUsuario' => $usuario->getCodigousuario()));
        }

        return $this->render('usuario/favoritos_nuevo.html.twig', array(
            'usuario' => $usuario,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/{codigoUsuario}/favorito/remove/{favorito}", name="usuario_favorito_remove")
     * @Method({"GET", "POST"})
     */
    public function removeFavoriteAction(Request $request, Usuario $usuario, Usuario $favorito)
    {

        $this->addFlash(
            'notice',
            'Your changes were saved!'
        );
        $usuario->removeFavorito($favorito);
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('usuario_favoritos', array('codigoUsuario' => $usuario->getCodigousuario()));
    }

    private function getFavorite(Request $request, $form)
    {
        $id = $request->request->get($form->getName())["usuario"];
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository(Usuario::class);
        return $repo->find($id);
    }




}
