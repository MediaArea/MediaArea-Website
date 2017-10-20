<?php

namespace PaymentBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
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

        $response = $this->get('tfox.mpdfport')->generatePdfResponse($html);
        $disposition = $this->downloadFileDisposition($response, $data['date'].'-MediaArea-Invoice-'.$id.'.pdf');
        $response->headers->set('Content-Disposition', $disposition);
        $response->headers->set('Content-length', strlen($response->getContent()));

        return $response;
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

    /**
     * Make the content-disposition string to download a file
     * Handle unauthorized and non ASCII characters.
     *
     * @param Response response the response object
     * @param string filename the name of the file to download
     *
     * @return string
     */
    protected function downloadFileDisposition(Response $response, $filename)
    {
        // Store current locale and set locale temporary to en_US
        $locale = setlocale(LC_ALL, 0);
        setlocale(LC_ALL, 'en_US.UTF8');

        // $filename can not contain '/' and '\\'
        $filename = str_replace(array('/', '\\'), '-', $filename);

        // $filenameFallback should be ASCII only and can not contain '%', '/' and '\\' (already stripped in $filename)
        if (function_exists('iconv')) {
            $filenameFallback = iconv('UTF-8', 'ASCII//TRANSLIT', $filename);
        } else {
            $filenameFallback = preg_replace('/[^\x20-\x7E]/', '-', $filename);
        }
        $filenameFallback = str_replace('%', '-', $filenameFallback);

        // Restore locale
        setlocale(LC_ALL, $locale);

        return $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $filename,
            $filenameFallback
        );
    }
}
