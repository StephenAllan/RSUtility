<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    /**
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('home.html.twig');
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function itemInfoAction(Request $request)
    {
        $path = $this->getParameter('kernel.root_dir') . '/../app/Resources/json/';
        $json = file_get_contents($path . 'items_osrs.json');
        return $this->render('itemInfo.html.twig', array(
            'itemInfo' => $json
        ));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function utilityAction(Request $request)
    {
        $utilityRepository = $this->get('utility_repository');

        $items = $utilityRepository->parseStaticItemInfo();
        $items = $utilityRepository->getCurrentData($items);

        return $this->render('utility.html.twig', array(
            'data' => $items
        ));
    }
}
