<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    /**
     * @Route("/salarie")
     */
class SalarieController extends Controller
{
    /**
     * 
     * @Route("/" , name="salarie-tdb")
     */
    public function index()
    {
        return $this->render('salarie/index.html.twig');
    }
}
