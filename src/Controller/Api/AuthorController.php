<?php

namespace App\Controller\Api;

use App\Form\AuthorType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Author;
use App\Helpers\FormHelpers;

/**
 * @Route("/api/author", name="api_author_")
 */
class AuthorController extends AbstractController
{
    /**
     * @param Request $request
     * @Route("/create", name="create", methods={"POST"})
     */
    public function createAuthor(Request $request): JsonResponse
    {
    	$post = json_decode($request->getContent(), true);

	    try {
		    $author = new Author();

		    $form = $this->createForm(AuthorType::class, $author);
		    $form->submit($post);

		    if ($form->isSubmitted() && $form->isValid() ) {
			    $manager = $this->getDoctrine()->getManager();
			    $manager->persist($author);
			    $manager->flush();
		    }
		    else {
			    return new JsonResponse(['success' => false, 'errors' => FormHelpers::arrayErrorsFromForm($form)], 422);
		    }
	    }
	    catch (\Exception $exception)
	    {
		    return new JsonResponse(['success' => false, 'error' => $exception->getMessage()], 500);
	    }

	    return new JsonResponse(['success' => true], 200);
    }
}
