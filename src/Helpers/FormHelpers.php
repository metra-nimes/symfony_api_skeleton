<?php


namespace App\Helpers;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormErrorIterator;

class FormHelpers
{
	public static function arrayErrorsFromForm(FormInterface $form)
	{
		$result = [];
		foreach ($form->getErrors(true, false) as $formError) {
			if ($formError instanceof FormError) {
				$result[$formError->getOrigin()->getName()] = $formError->getMessage();
			}
			elseif ($formError instanceof FormErrorIterator) {
				$result = self::arrayErrorsFromForm($formError->getForm());
			}
		}

		return $result;
	}
}