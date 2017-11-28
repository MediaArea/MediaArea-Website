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
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ('POST' === $request->getMethod() && $form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $message = (new \Swift_Message())
                ->setSubject('[web] '.$contact->getSubject())
                ->setFrom([$contact->getEmail() => $contact->getName()])
                ->setTo('info@mediaarea.net')
                ->setBody(
                    ($contact->getCompany() ? 'Company: '.$contact->getCompany()."\n\n" : '').$contact->getMessage(),
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
