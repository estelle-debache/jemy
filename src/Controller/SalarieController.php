<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SalarieController extends Controller
{
    /**
     * @Route("/salarie", name="salarie")
     */
    public function index()
    {
        return $this->render('salarie/inscription.html.twig');
    }
}
