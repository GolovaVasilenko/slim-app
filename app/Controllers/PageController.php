<?php

namespace App\Controllers;


use App\Services\PageServiceManager;

class PageController extends AbstractController
{
    public function index($request, $response, $args)
    {
        $sm = new PageServiceManager($this->container);

        //$pages = $sm->all();

        //$home = $sm->all();

        /*$data = [
            'id' => 3,
            'title' => 'title page1',
            'body' => 'body page1',
            'slug' => 'title-page1',
        ];
        $sm->insert($data);
        $sm->update($data);
        $sm->remove(3)*/

        //var_dump($home); die;

        return $this->view->render($response, 'pages/page.twig', $args);
    }
}