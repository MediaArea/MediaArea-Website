<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/Contact", name="ma_contact")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $contact = new Contact();

        if ('GET' === $request->getMethod() && $request->get('sponsor') && $request->get('amount')) {
            $contact
                ->setSubject(sprintf(
                    'Request quote for %s (%s)',
                    htmlspecialchars($request->get('sponsor')),
                    htmlspecialchars($request->get('amount'))
                ))
                ->setMessage(sprintf(
                    "I'm interested in becoming a MediaArea sponsor.\n\nPlease send me a quote of %s to become a %s.",
                    htmlspecialchars($request->get('amount')),
                    htmlspecialchars($request->get('sponsor'))
                ));
        }

        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $message = (new \Swift_Message())
                ->setSubject($contact->getSubject())
                ->setFrom([$contact->getEmail() => $contact->getName()])
                ->setTo('info@mediaarea.net')
                ->setBody(
                    sprintf(
                        "Source: web\n%s\n%s",
                        $contact->getCompany() ? 'Company: '.$contact->getCompany()."\n" : '',
                        $contact->getMessage()
                    ),
                    'text/plain'
                );
            $this->get('mailer')->send($message);

            $this->addFlash('success', 'Your message have been sent');

            return $this->redirectToRoute('ma_contact');
        }

        return [
            'noAds' => true,
            'form' => $form->createView(),
        ];
    }
}
