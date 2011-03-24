<?php

namespace Lichess\TranslationBundle;

use Symfony\Component\HttpFoundation\Session;

/**
 * Changes the user language
 *
 * @author     Thibault Duplessis <thibault.duplessis@gmail.com>
 */
class Switcher
{
    protected $manager;

    /**
     * Instanciates a new language switcher
     **/
    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Switches the session language
     *
     * @return null
     **/
    public function switchLocale(Session $session, $code)
    {
        $session->setLocale($code);
        $session->set('locale_name', $this->manager->getAvailableLanguageName($code));
        $session->setFlash('locale_change', $code);
    }

    /**
     * Chooses a language for a request
     *
     * @return null
     **/
    public function switchLocaleForRequest(Request $request)
    {
        $chosenLanguage = $event->getRequest()->getPreferredLanguage(array_keys(
            $this->manager->getAvailableLanguageCodes()
        ));
        $this->switchLocale($request->getSession(), $chosenLanguage);

        $preferredLanguage = $this->getRequestPreferredLanguage($event->getRequest());
        if ($preferredLanguage && $chosenLanguage != $preferredLanguage) {
            $allLanguageCodes = array_keys($this->manager->getLanguages());
            if (in_array($preferredLanguage, $allLanguageCodes)) {
                $session->setFlash('locale_missing', $preferredLanguage);
            }
        }
    }

    private function getRequestPreferredLanguage(Request $request)
    {
        foreach ($request->getLanguages() as $language) {
            if (preg_match('/^[a-z]{2,3}$/i', $language)) {
                return $language;
            }
        }
    }
}