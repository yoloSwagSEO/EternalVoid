<?php
    namespace Eternal\Http\Middleware;

    use Closure;
    use Config;
    use Session;
    use Illuminate\Routing\Route;

    class Universe {

        private $route;

        public function __construct(Route $route) {
            $this->route = $route;
        }

        public function handle($request, Closure $next) {

            $universe = $this->route->getParameter('universe');
            if(!empty($universe)) {
                Config::set('database.default', $universe);
                Session::put('universe', $universe);

                $this->route->forgetParameter('universe');
            } else {
                return redirect()->guest(Config::get('app.url'));
            }

            return $next($request);
        }
    }