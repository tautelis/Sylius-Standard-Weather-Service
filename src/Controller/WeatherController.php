<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\Weather\WeatherClientInterface;
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

    /** @var WeatherClientInterface */
    private $weatherClient;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /**
     * @param SessionInterface $session
     * @param WeatherClientInterface $weatherClient
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        SessionInterface $session,
        WeatherClientInterface $weatherClient,
        UrlGeneratorInterface $urlGenerator
    ) {
        $this->session = $session;
        $this->weatherClient = $weatherClient;
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

        if ($this->weatherClient->isValidLocationCode($locationCode)) {
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
