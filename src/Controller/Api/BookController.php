<?php

namespace App\Controller\Api;

use App\Entity\Book;
use App\Form\BookType;
use App\Helpers\FormHelpers;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class BookController extends AbstractController
{
	/**
     * @param Request $request
     * @Route("/api/book/create", name="api_book_create", methods={"POST"})
     */
    public function createBook(Request $request): JsonResponse
    {
	    $post = json_decode($request->getContent(), true);

	    try {
		    $book = new Book();

		    $form = $this->createForm(BookType::class, $book);
		    $form->submit($post);

		    if ($form->isSubmitted() && $form->isValid() ) {
			    $manager = $this->getDoctrine()->getManager();
			    $manager->persist($book);
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

	/**
	 * @param $id
	 * @return JsonResponse
	 * @Route("/api/{_locale}/book/{id}", requirements={"_locale": "en|ru"}, name="api_book_get", methods={"GET"})
	 */
	public function getBook(int $id, TranslatorInterface $translator): JsonResponse
	{
		$book = $this->getDoctrine()
			->getRepository(Book::class)
			->find($id);

		$result = ($book) ? $book->getFields() : [];

		$result['name'] = $translator->trans($result['name'], [], 'books');

		return new JsonResponse(json_encode($result), 200);
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 * @Route("/api/book/search", name="api_book_search", methods={"GET"})
	 */
	public function searchBook(Request $request): JsonResponse
	{
		$books = $this->getDoctrine()
			->getRepository(Book::class)
			->findAllByNameField($request->query->get('search'));

		$result = [];
		foreach ($books as $book) {
			$result[] = $book->getFields();
		}

		return new JsonResponse(json_encode($result), 200);
	}
}
