<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController
{
    public function index()
    {
        $colors = [];
        for ($i = 0, $iMax = random_int(2, 5); $i < $iMax; $i++) {
            $colors[] = $this->randomColor();
        }

        return $this->render('index.html.twig', [
            'colors' => $colors
        ]);
    }

    public function api(Request $request)
    {
        $numberOfColors = $request->query->get('colors');

        if (null === $numberOfColors || !is_numeric($numberOfColors) || (int)$numberOfColors < 0) {
            return new JsonResponse('Please provide the number of colours using the key: colors');
        }

        if ((int)$numberOfColors > 15) {
            return new JsonResponse('15 is the maximum amount of colours you can request at once');
        }

        $colors = [];
        for ($i = 0; $i < $numberOfColors; $i++) {
            $colors[] = $this->randomColor();
        }

        return new JsonResponse(['colors' => $colors]);
    }

    private function randomColor()
    {
        $seed = md5(uniqid('', true));
        return substr(str_shuffle($seed), 0, 6);
    }
}
