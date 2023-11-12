<?php

namespace App\Application\Controller;

use App\Application\UseCase\GetTweetConverterUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class TweetConverterController extends AbstractController
{
    /**
     * @Route("/tweets/{userName}",name="tweets", methods={"GET"})
     *
     * @param GetTweetConverterUseCase $useCase
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param                         $userName
     *
     * @return JsonResponse
     */
    public function index(
        GetTweetConverterUseCase $useCase,
        Request $request,
        ValidatorInterface $validator,
        $userName
    ): JsonResponse {
        $limit = $request->query->get('limit');

        $input = ['limit' => $limit];

        $constraints = new Assert\Collection([
            'limit' => [
                new Assert\LessThanOrEqual(10), new Assert\NotNull(), new Assert\Positive()
            ],
        ]);

        $errors = $validator->validate($input, $constraints);

        if (count($errors) > 0) {
            $accessor = PropertyAccess::createPropertyAccessor();

            $errorMessages = [];

            foreach ($errors as $error) {
                $accessor->setValue($errorMessages, $error->getPropertyPath(), $error->getMessage());
            }

            return new JsonResponse($errorMessages);
        }

        return new JsonResponse($useCase->execute($userName, $limit));
    }
}
