<?php

namespace App\Magnita\Common\Infrastructure\Middleware;

use App\Magnita\Common\Application\Service\ConfigReader;
use App\Magnita\Common\Domain\Enum\Locale;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromRequest
{
    public function handle(Request $request, Closure $next):Response
    {
        $language = $this->tryGetLanguageFromHeader($request);

        $languageIsExist = Locale::from($language);

        if (!$language || !$languageIsExist) {
            $language = ConfigReader::make()->getDefaultLocale()->value;
        }

        App::setLocale($language);
        $request->setLocale($language);

        $response = $next($request);

        $response->headers->add([
            'Content-Language' => App::getLocale(),
        ]);

        return $response;
    }

    public function tryGetLanguageFromHeader(Request $request): ?string
    {
        if (!$request->hasHeader('accept-language')) {
            return null;
        }

        $header = (string) $request->header('accept-language');

        $languages = explode(',', $header);

        if (count($languages) === 0) {
            return null;
        }

        $primary = explode(';', $languages[0])[0];

        return strtolower(trim($primary));
    }
}
