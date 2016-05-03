<?php

namespace Elcweb\EventStoreBundle\Controller;

use Elcweb\EventStoreBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/eventstore")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        /** @var $em EntityManager */
        $em = $this->getDoctrine()->getManager();


        // get the events sorted DESC
        $events = $em->getRepository('ElcwebEventStoreBundle:Event')->findBy(array(), array("createdAt" => "DESC"));

        $paginator  = $this->get('knp_paginator');
        /** @var $pagination Event[] */
        $pagination = $paginator->paginate(
            $events,
            $this->get('request')->query->get('page', 1) /*page number*/,
            100/*limit per page*/
        );

        return array(
            'events' => $pagination,

        );
    }

    /**
     * @Route("/show/{event}")
     * @Template()
     */
    public function showAction(Event $event)
    {
        return array(
            'event' => $event
        );
    }
}
