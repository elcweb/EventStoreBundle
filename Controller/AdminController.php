<?php

namespace Elcweb\EventStoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/eventstore")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('ElcwebEventStoreBundle:Event')->findBy(array(), array("createdAt" => "DESC"));
        
        return array(
            'events' => $events
        );
    }
}
