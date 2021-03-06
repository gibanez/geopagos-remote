<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        $cards = [
            [
                "title" => 'Usuario',
                "path" => 'usuario_index',
                "description" => 'Listado de usuarios'
            ],
            [
                "title" => 'Pagos',
                "path" => 'usuario_index',
                "description" => 'Listado de pagos'
            ]
        ];

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'cards' => $cards
        ]);
    }
}
