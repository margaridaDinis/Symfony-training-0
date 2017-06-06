<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BatteryPack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:BatteryPack');
        $batteryPacks = $repository->findAll();

//todo: this should go to Repository class
        $groupBatteryPacks = $repository->createQueryBuilder('b')
            ->select("b.type as battery_type, sum(b.count) as battery_count")
            ->groupBy('b.type')
            ->getQuery();

        $sumBatteryPacks = $groupBatteryPacks->getResult();

        return $this->render('default/index.html.twig', [
            'batteryPacks' => $batteryPacks,
            'batterySum' => $sumBatteryPacks
        ]);
    }
    /**
     * @Route("/all", name="all")
     */
    public function allAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:BatteryPack');
        $batteryPacks = $repository->findAll();

        return $this->render('default/batterypack/index.html.twig', [
            'batteryPacks' => $batteryPacks
        ]);
    }
    /**
     * @Route("/batterypack/new", name="new")
     */
    public function newAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $batteryPack = new BatteryPack();

//todo: this should go to Form class
        $form = $this->createFormBuilder($batteryPack)
            ->add('name', TextType::class, array(
                'required' => false,
                'empty_data' => '',
            ))
            ->add('type', TextType::class, array(
                'required' => true
            ))
            ->add('count', NumberType::class, array(
                'required' => true
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $batteryPack = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($batteryPack);
            $em->flush();
            return $this->redirectToRoute('show', array('id' => $batteryPack->getId()));
        }
        return $this->render('default/batterypack/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/batterypack/show/{id}", name="show")
     */
    public function showAction(BatteryPack $batteryPack)
    {
        return $this->render('default/batterypack/show.html.twig', array(
            'batteryPack' => $batteryPack
        ));
    }
}
