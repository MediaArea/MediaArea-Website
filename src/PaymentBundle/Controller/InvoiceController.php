<?php

namespace PaymentBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TFox\MpdfPortBundle\Response\PDFResponse;
use PaymentBundle\Entity\Invoice;

/**
 * @Route("/invoice")
 */
class InvoiceController extends Controller
{
    /**
     * @Route("/ajax/modal/{id}", name="invoice_ajax_modal_data", requirements={"id": "\d+"})
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

        return new JsonResponse($this->getInvoiceDatas($id, $user), 200);
    }

    /**
     * @Route("/pdf/{id}", name="invoice_download_pdf", requirements={"id": "\d+"})
     */
    public function downloadPdfAction($id)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $data = $this->getInvoiceDatas($id, $user);

        // Get html for pdf rendering
        $html = $this->renderView('PaymentBundle:Invoice:pdf.html.twig', ['data' => $data]);

        return new PDFResponse(
            $this->get('t_fox_mpdf_port.pdf')->generatePdf($html),
            $data['date'].'-MediaArea-Invoice-'.$id.'.pdf'
        );
    }

    /**
     * Get invoices data for display.
     *
     * @param int           $id   Invoice ID
     * @param UserInterface $user
     *
     * @return array Datas
     */
    protected function getInvoiceDatas($id, $user)
    {
        $invoice = $this->getDoctrine()
            ->getRepository(Invoice::class)
            ->findOneBy(['id' => $id, 'user' => $user]);

        if (!$invoice) {
            throw new NotFoundHttpException();
        }

        function formatAmount($amount, $currency)
        {
            if ('JPY' == $currency) {
                return number_format($amount, 0);
            } else {
                return number_format($amount, 2);
            }
        }

        $total = $invoice->getAmount() + $invoice->getVat();
        if ($total >= 500) {
            $product = 'Supporter++';
        } elseif ($total >= 300) {
            $product = 'Supporter+';
        } elseif ($total >= 100) {
            $product = 'Supporter';
        } elseif ($total >= 30) {
            $product = 'Voter';
        } elseif ($total >= 10) {
            $product = 'Member';
        } else {
            $product = 'Thanks!';
        }

        return [
            'id' => $id,
            'date' => $invoice->getDate()->format('Y-m-d'),
            'amount' => formatAmount($invoice->getAmount(), $invoice->getCurrency()),
            'vat' => formatAmount($invoice->getVat(), $invoice->getCurrency()),
            'total' => formatAmount($total, $invoice->getCurrency()),
            'product' => $product,
            'country' => $invoice->getCountry(),
            'currency' => $invoice->getCurrency(),
        ];
    }
}
