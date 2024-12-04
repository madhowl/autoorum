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


    public function index()
    {
       /* $data = $this->model->all();
        return new JsonResponse(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );*/


        echo $this->twig->render('home.twig', []);
    }
    public function get_companies()
    {
        $this->model->setTable('companies');
        $data = $this->model->all();
        return new JsonResponse(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );

    }
    public function get_models($company_id)
    {
        $this->model->setTable('models');

        $data = $this->model->getmodels($company_id);
        return new JsonResponse(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );

    }
    public function get_years($model_id)
    {
        $this->model->setTable('cars');

        $data = $this->model->getyears($model_id);
        return new JsonResponse(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );

    }
    public function get_configurations($car_id)
    {
        $this->model->setTable('configurations');

        $data = $this->model->getconfigurations($car_id);
        return new JsonResponse(
            $data,
            200,
            [],
            JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
        );

    }
}
