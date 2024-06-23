<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StandardApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Only format JSON responses
        if ($response instanceof \Illuminate\Http\JsonResponse) {
            $statusCode = $response->getStatusCode();
            $originalData = $response->getData();
            $message = $this->getMessageForStatusCode($statusCode);

            $response->setData([
                'code' => $statusCode,
                'message' => $message,
                'data' => $originalData,
            ]);
        }

        return $response;
    }

    /**
     * Get a message for the given status code.
     *
     * @param  int  $statusCode
     * @return string
     */
    protected function getMessageForStatusCode($statusCode)
    {
        $messages = [
            Response::HTTP_OK => 'OK',
            Response::HTTP_CREATED => 'Created',
            Response::HTTP_ACCEPTED => 'Accepted',
            Response::HTTP_NO_CONTENT => 'No Content',
            Response::HTTP_BAD_REQUEST => 'Bad Request',
            Response::HTTP_UNAUTHORIZED => 'Unauthorized',
            Response::HTTP_FORBIDDEN => 'Forbidden',
            Response::HTTP_NOT_FOUND => 'Not Found',
            Response::HTTP_METHOD_NOT_ALLOWED => 'Method Not Allowed',
            Response::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
            // Add other status codes and messages as needed
        ];

        return $messages[$statusCode] ?? 'Unknown status';
    }
}
