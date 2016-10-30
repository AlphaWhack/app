<?php

namespace WhackUp\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\SecurityContext;
use WhackUp\ManageBundle\Entity\Disco;

class DiscoController extends Controller
{
    public function indexAction(Request $request)
    {
        $user= $this->getUser();
        $super_admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_SUPER_ADMIN', $user);
        $admin_right = $this->get('rh_whackup.service.role')->isGranted('ROLE_ADMIN', $user);
        // if you are admin or super admin
        if ($admin_right || $super_admin_right ) {
            return $this->redirectToRoute('fos_user_security_logout');
        }

        return $this->render('WhackUpCoreBundle:Disco:index.html.twig');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * show list of night club
     */
    public function discoAction(Request $request)
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('WhackUpManageBundle:Disco')
        ;
        $listDisco = $repository->findAll();

        return $this->render('WhackUpCoreBundle:Disco:disco.html.twig',
            array(
                'discos' => $listDisco,
            ));
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function addFavouriteAction(Request $request){
        if ($request->isXMLHttpRequest()) {
            $id = $request->get('id');
            $disco = "";
            if ($id!= ' ') {
                $em = $this->getDoctrine()->getManager();
                $disco = $em->getRepository('WhackUpManageBundle:Disco')
                    ->findOneBy(array('id' => $id));

                $user = $this->getUser();
                $user->addDisco($disco);

                $em->persist($user);
                $em->flush();
            }

            return new JsonResponse(array('data' => 'like'));
        }
        return $this->render('WhackUpCoreBundle:Disco:index.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function removeFavouriteAction(Request $request){
        if ($request->isXMLHttpRequest()) {
            $id = $request->get('id');
            $disco = "";
            if ($id!= ' ') {
                $em = $this->getDoctrine()->getManager();
                $disco = $em->getRepository('WhackUpManageBundle:Disco')
                    ->findOneBy(array('id' => $id));

                $user = $this->getUser();
                $user->removeDisco($disco);

                $em->persist($user);
                $em->flush();
            }

            return new JsonResponse(array('data' => ''));
        }
        return $this->render('WhackUpCoreBundle:Disco:index.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function rechercheAction(Request $request){
        if ($request->isXMLHttpRequest()) {
            $word = trim($request->get('key'));
            $result = 0;
            $discos = '';
            if ($word != '') {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('WhackUpManageBundle:Disco');
                //$discos = $repository->findByNom($word);
                $discos = $repository->findByNameDisco($word);
                $result = $repository->nbreByNameDisco($word);
            }

            return $this->render('WhackUpCoreBundle:Disco:recherche.html.twig',array(
                    'key' => $word,
                    'nbrediscos' => $result,
                    'discos' => $discos,
                ));
        }
        return $this->render('WhackUpCoreBundle:Disco:index.html.twig');
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function favouriteAction(Request $request)
    {
        $user = $this->getUser();

        $discos = $user->getDiscos();

        return $this->render('WhackUpCoreBundle:Disco:favourite.html.twig',
            array(
                'favoris' => $discos,
            ));
    }

    public function aroundAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:around.html.twig');
    }

    public function usAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:us.html.twig');
    }

    public function sliderAction(Request $request)
    {
        return $this->render('WhackUpCoreBundle:Disco:slider.html.twig');
    }
}
