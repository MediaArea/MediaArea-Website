<?php

namespace PaymentBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PaymentBundle\Entity\Invoice;

/**
 * @Route("/invoice")
 */
class InvoiceController extends Controller
{
    /**
     * @Route("/modal/{id}", name="invoice_modal_data")
     */
    public function modalDataAction(Request $request, $id)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new NotFoundHttpException();
        }

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $invoice = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->findOneBy(['id' => $id, 'user' => $user]);

        if (!$invoice) {
            throw new NotFoundHttpException();
        }

        $data = [
            'date' => $invoice->getDate()->format('Y-m-d'),
            'amount' => round($invoice->getAmount(), 2),
            'vat' => round($invoice->getVat(), 2),
            'country' => $invoice->getCountry(),
            'currency' => $invoice->getCurrency(),
        ];

        return new JsonResponse($data, 200);
    }
}
