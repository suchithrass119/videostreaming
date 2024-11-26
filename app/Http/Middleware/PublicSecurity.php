<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PublicSecurity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $sanitizedInputs = array_map([$this, 'sqlsanitize'], $request->all());

        $request->merge($sanitizedInputs);

        $host_aaddr = $_SERVER['SERVER_NAME'];
        $function_reslt = $this->hostheader_validate($host_aaddr);

        if ($function_reslt == 0) {
            abort(505);
        }

        $req_count = count($request->all());
        $input = $request->all();

        if ($req_count > 1) {
            array_walk_recursive($input, function (&$input) {
            $input = $this->xss_strip($input);
            });
            $request->merge($input);
        }


        $response = $next($request);
        return $response
            ->header('Access-Control-Allow-Origin', $request->headers->get('Origin') ?: '*')
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');

    }

    protected function sqlsanitize($parameter)
    {
        // If the parameter is an array, recursively sanitize each element
        if (is_array($parameter)) {
            foreach ($parameter as $key => $value) {
                // Sanitize each value in the array
                $parameter[$key]= $this->sqlsanitize($value);
                
            }
            return $parameter;
        }
    
        // If it's a string, proceed with the sanitization
        if (is_string($parameter)) {
            $parameter= htmlspecialchars(strip_tags($parameter), ENT_QUOTES, 'UTF-8');
            // Replace unwanted characters with sanitized values
            $parameter = str_replace("&Acirc;", "", $parameter);
            $parameter = str_replace("&nbsp;", "", $parameter);
            $parameter = str_replace("--", "", $parameter);
            $parameter = str_replace(";", "", $parameter);
            $parameter = str_replace("/*", "", $parameter);
            $parameter = str_replace("*/", "", $parameter);
            $parameter = str_replace("=", "", $parameter);
            $parameter = htmlentities($parameter);
            $parameter = pg_escape_string($parameter); // Use appropriate escaping method depending on your DB
            $parameter = trim($parameter);
    
            // Additional replacements, if necessary
            $parameter = str_replace("&Acirc;", " ", $parameter);
            $parameter = str_replace("&nbsp;", "", $parameter);
    
            return $parameter;
        }
    
        // If the input is not a string or array, return it as is
        return $parameter;
    }
    public function hostheader_validate($host_addr)
    {
        return 1; //Uncomment this to access this from other computers on the same network

        // $valid_host = ['localhost'];
        $host_addr = trim($host_addr);
        $valid_host = config('constants.host_headers');
        if (!in_array($host_addr, $valid_host)) {
            return 0;
        } else {
            return 1;
        }
    }
    public function xss_strip($value)
    {
        $value = preg_replace('/(script|style).*?\/script/ius', '', $value) ? preg_replace('/script.*?\/script/ius', '', $value) : $value; // $value =preg_replace('/script.*?\/script/ius', '', $value)
        $value = preg_replace('#<a.*?>([^>]*)</a>#i', '$1', $value);
        return $value;
    }
}
