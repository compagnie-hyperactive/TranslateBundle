<?php

namespace Lch\TranslateBundle\Utils;

use Doctrine\ORM\EntityManagerInterface;
use Lch\TranslateBundle\Model\Behavior\Translatable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class LangSwitchHelper
 * @package Lch\TranslateBundle\Utils
 */
class LangSwitchHelper
{
    /** @var TranslationsHelper $translationsHelper */
    protected $translationsHelper;

    /** @var RouterInterface $router */
    protected $router;

    /** @var RequestStack $requestStack */
    protected $requestStack;

    /** @var EntityManagerInterface $em */
    protected $em;

    /**
     * LangSwitchHelper constructor.
     * @param TranslationsHelper $translationsHelper
     * @param RouterInterface $router
     * @param RequestStack $requestStack
     * @param EntityManagerInterface $em
     */
    public function __construct(TranslationsHelper $translationsHelper,
                                RouterInterface $router,
                                RequestStack $requestStack,
                                EntityManagerInterface $em
    ) {
        $this->translationsHelper = $translationsHelper;
        $this->router = $router;
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    /**
     * @param object|null $translatableEntity
     *
     * @return array
     */
    public function getAvailableI18nPaths(object $translatableEntity = null): array
    {
        $request = $this->requestStack->getMasterRequest();

        return $translatableEntity !== null
            ? $this->getShowedEntityPaths($request, $translatableEntity)
            : $this->getStaticPaths($request)
            ;
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function getStaticPaths(Request $request): array
    {
        $paths = [];

        $currentRoute = $request->get('_route');
        $currentLocale = $request->getLocale();

        foreach ($this->translationsHelper->getAvailableLanguages() as $language) {
            if ($language !== $currentLocale) {
                $paths[$language] = $this->getTranslatedPath($currentRoute, [
                    '_locale' => $language
                ]);
            }
        }

        return $paths;
    }

    /**
     * Route parameters must include "_locale" parameter.
     *
     * @param string $route
     * @param array $parameters
     *
     * @return string
     */
    public function getTranslatedPath(string $route, array $parameters): string
    {
        if (!isset($parameters['_locale'])) {
            throw new \UnexpectedValueException('"_locale" parameter is mandatory in order to translate route.');
        }

        try {
            return $this->router->generate(
                $route,
                $parameters
            );
        } catch (RouteNotFoundException $e) {
            return $this->router->generate(
                $route . '.' . $parameters['_locale'],
                $parameters
            );
        }
    }

    /**
     * @param Request $request
     * @param object $entity
     * @return array
     */
    public function getShowedEntityPaths(Request $request, object $entity): array
    {
        if (!$this->translationsHelper->isEntityTranslatable($entity)) {
            throw new \UnexpectedValueException('Expecting translatable entity.');
        }

        $qb = $this->em->createQueryBuilder();
        $qb
            ->from(get_class($entity), 'e')
            ->select('e')

            ->where('e.translatedParent = :current_entity')
            ->orWhere(':current_entity MEMBER OF e.translatedChildren')
            ->andWhere('e != :current_entity')
            ->setParameter('current_entity', $entity)
        ;

        $availableEntities = $qb->getQuery()->getResult();

        $paths = [];
        $currentRoute = $request->get('_route');
        /** @var Translatable $availableEntity */
        foreach ($availableEntities as $availableEntity) {
            // Todo: Must ensure that very translatable entity
            // implements slug property
            $paths[$availableEntity->getLanguage()] = $this->router->generate(
                $currentRoute, ['slug' => $availableEntity->getSlug()]
            );
        }

        return $paths;
    }
}
