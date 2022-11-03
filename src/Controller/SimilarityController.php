<?php

namespace App\Controller;

use App\Form\SimilarityFormType;
use App\Service\AlgorithmManager;
use App\Service\DevLoremIpsumClient;
use App\Service\OptionsProvider\AlgorithmOptionsProvider;
use App\SimilarityAlgorithms\HammingAlgorithm;
use App\SimilarityAlgorithms\SimilarityAlgorithm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SimilarityController extends AbstractController
{
    #[Route('/')]
    public function index(Request $request, AlgorithmManager $algorithmManager, AlgorithmOptionsProvider $algorithmOptionsProvider)
    {
        $form = $this->createForm(SimilarityFormType::class);
        $form = $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();

                $algorithmName = $algorithmOptionsProvider->getAlgorithmNameBasedOnKey($data['algorithm']);

                /** @var SimilarityAlgorithm $algorithm */
                $algorithm = $algorithmManager->getAlgorithm($algorithmName);
                $algorithm->setTexts([
                    'text1' => $data['text1'],
                    'additional_text1' => $data['additional_text1'],
                    'text2' => $data['text2'],
                    'additional_text2' => $data['additional_text2'],
                ]);

                $dif = $algorithm->compare();

                $result = 'For chosen algorithm \'' . $algorithmName . '\' calculated similarity is ' . $dif;

                if ($request->isXmlHttpRequest()) {
                    return $this->json([
                        'data'=> $result,
                    ], Response::HTTP_OK);
                }

                return $this->render('index.html.twig', [
                    'form' => $form->createView(),
                    'result' => $result
                ]);
            }
        }

        return $this->render('index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/generate-text', name: "generate_text")]
    public function generateText(DevLoremIpsumClient $client)
    {
        try {
            $texts = $client->getTexts();
        } catch (\Exception $e) {
            return $this->json([
                'msg' => 'Unexpected error.',
                'success' => false
                ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        return $this->json([
            'data' => $texts,
            'success' => true
        ], Response::HTTP_OK);
    }
}

