<?php

namespace App\Controller;

use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather')]
    public function city(string $country,string $city,MeasurementRepository $measurementRepository,LocationRepository $locationRepository): Response
    {

        $location = $locationRepository->findByCountryAndCity($country,$city);

        if (!$location) {
            throw $this->createNotFoundException('The location does not exist');
        }


        $measurements = $measurementRepository->findByLocation($location);


        return $this->render('weather/index.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }
}
