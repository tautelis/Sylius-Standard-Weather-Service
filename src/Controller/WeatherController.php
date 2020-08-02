<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\Weather\WeatherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class WeatherController extends AbstractController
{
    /** @var SessionInterface */
    private $session;

    /** @var WeatherService */
    private $weatherService;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /**
     * @param SessionInterface $session
     * @param WeatherService $weatherService
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        SessionInterface $session,
        WeatherService $weatherService,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->session = $session;
        $this->weatherService = $weatherService;
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function locationAction(Request $request): RedirectResponse
    {
        $locationCode = str_replace(
            [' ', 'ą', 'č', 'ę', 'ė', 'į', 'š', 'ų', 'ū'],
            ['-', 'a', 'c', 'e', 'e', 'i', 's', 'u', 'u'],
            strtolower($request->request->get('locationCode'))
        );

        if ($this->weatherService->isValidLocationCode($locationCode)) {
            $this->session->set(WeatherService::SESSION_KEY, $locationCode);
        } else {
            $this->session->getFlashBag()->add('error', 'app.weather.location_not_found');
        }

        return $this->redirect(
            $request->headers->has('referer')
                ? $request->headers->get('referer')
                : $this->urlGenerator->generate('sylius_shop_homepage', ['_locale' => $request->get('_locale')])
        );
    }
}
