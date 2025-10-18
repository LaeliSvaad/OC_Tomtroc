<?php
declare(strict_types=1);

namespace App\Routing;

use App\Config\Config;
use App\Controller\NotFoundController;
use App\Http\Session\PhpSessionStorage;
use App\Http\Session\SessionStorageInterface;
use App\Http\Request;
use App\View\View;

final class Router
{
    private Request $request;
    private SessionStorageInterface $session;
    private View $view;
    public function __construct()
    {
        $this->session = new PhpSessionStorage();
        $this->session->start();

        $this->request = new Request();
        $this->view = new View($this->session);
    }
    public function handleRequest(string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);

        foreach (Config::get('routes') as [$routePath, $controllerClass, $methodName]) {
            //Route statique exacte
            if ($routePath === $path) {
                $controller = new $controllerClass($this->view, $this->session, $this->request);
                $controller->$methodName();
                return;
            }

            //Route dynamique : {param} ou {param:regex}
            [$regex, $paramNames] = $this->convertToNamedRegex($routePath);

            if (preg_match($regex, $path, $matches)) {

                $params = [];
                foreach ($paramNames as $name) {
                    $params[$name] = $matches[$name] ?? null;
                }

                $controller = new $controllerClass($this->view, $this->session, $this->request);
                $convertedParams = $this->convertParamsForMethod($controllerClass, $methodName, $params);
                if ($convertedParams === false) {
                    (new NotFoundController($this->view, $this->session))->show404();
                    return;
                }

                $controller->$methodName(...$convertedParams);
                return;
            }
        }

        //Aucune route ne correspond
        (new NotFoundController($this->view, $this->session))->show404();
    }

    /**
     * Transforme une route du type :
     *   /livre/{id:\d+}
     *   /auteur/{slug:[a-z-]+}
     *   /produit/{cat}/{ref:\d+}
     *
     * En regex utilisable :
     *   #^/livre/(?P<id>\d+)$#
     *   #^/auteur/(?P<slug>[a-z-]+)$#
     *
     * @return array [string $regex, string[] $paramNames]
     */
    private function convertToNamedRegex(string $routePath): array
    {
        $paramNames = [];
        $regex = preg_replace_callback(
            '#\{([a-zA-Z_][a-zA-Z0-9_]*)(?::([^}]+))?\}#',
            function ($matches) use (&$paramNames) {
                $name = $matches[1];
                $constraint = $matches[2] ?? '[^/]+';
                $paramNames[] = $name;
                return '(?P<' . $name . '>' . $constraint . ')';
            },
            $routePath
        );
        $regex = "#^" . $regex . "$#";
        return [$regex, $paramNames];
    }

    /**
     * Convertit les paramètres nommés en valeurs typées selon la signature du contrôleur.
     *
     * @param class-string $controllerClass
     * @param string $methodName
     * @param array<string,string|null> $rawParams
     * @return array|false
     */
    private function convertParamsForMethod(string $controllerClass, string $methodName, array $rawParams)
    {
        try {
            $ref = new \ReflectionMethod($controllerClass, $methodName);
        } catch (\ReflectionException $e) {
            return false;
        }

        $converted = [];

        foreach ($ref->getParameters() as $refParam) {
            $name = $refParam->getName();
            if (!array_key_exists($name, $rawParams)) {
                if ($refParam->isDefaultValueAvailable()) {
                    $converted[] = $refParam->getDefaultValue();
                    continue;
                }
                if ($refParam->allowsNull()) {
                    $converted[] = null;
                    continue;
                }
                return false;
            }

            $raw = $rawParams[$name];
            $type = $refParam->getType();

            if ($type === null) {
                $converted[] = $raw;
                continue;
            }

            $typeName = $type->getName();
            $allowsNull = $type->allowsNull();

            if ($raw === null && $allowsNull) {
                $converted[] = null;
                continue;
            }

            switch ($typeName) {
                case 'int':
                    if (!is_numeric($raw)) return false;
                    $converted[] = (int)$raw;
                    break;
                case 'float':
                    if (!is_numeric($raw)) return false;
                    $converted[] = (float)$raw;
                    break;
                case 'bool':
                    $converted[] = in_array(strtolower((string)$raw), ['1', 'true', 'on', 'yes'], true);
                    break;
                case 'string':
                    $converted[] = (string)$raw;
                    break;
                default:
                    return false; // type non géré
            }
        }

        return $converted;
    }
}