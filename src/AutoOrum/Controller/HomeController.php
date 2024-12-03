<?php

namespace AutoOrum\Controller;

use AutoOrum\Model\Car;
use Twig\Environment;
use Laminas\Diactoros\Response\JsonResponse;

class HomeController
{
    private Environment $twig;
    private Car $model;

    public function __construct(Car $car, Environment $twig)
    {
        $this->model = $car;
        $this->twig = $twig;
    }


    public function index(): JsonResponse
    {
        $data = $this->model->all();
        return new JsonResponse(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );

       /* return json_encode($this->model->all());
        echo $this->twig->render('home.twig', [
            'articles' => $this->model->all(),
        ]);*/
    }
}
