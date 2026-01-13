<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiController extends Controller
{
    /**
     * Return a success response
     */
    protected function successResponse($data = null, string $message = null, int $status = 200): JsonResponse
    {
        $response = [
            'success' => true,
        ];

        if ($message) {
            $response['message'] = $message;
        }

        if ($data !== null) {
            $response['data'] = $data;
        }

        return response()->json($response, $status);
    }

    /**
     * Return an error response
     */
    protected function errorResponse(string $message, int $status = 400, string $code = null, array $details = null): JsonResponse
    {
        $response = [
            'success' => false,
            'error' => [
                'message' => $message,
            ],
        ];

        if ($code) {
            $response['error']['code'] = $code;
        }

        if ($details) {
            $response['error']['details'] = $details;
        }

        return response()->json($response, $status);
    }

    /**
     * Return a resource response
     */
    protected function resourceResponse(JsonResource $resource, int $status = 200): JsonResponse
    {
        return $this->successResponse($resource, null, $status);
    }

    /**
     * Return a collection response with pagination meta
     */
    protected function collectionResponse(ResourceCollection $collection, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $collection->items(),
            'meta' => [
                'pagination' => $this->getPaginationMeta($collection),
            ],
        ], $status);
    }

    /**
     * Get pagination metadata
     */
    protected function getPaginationMeta($collection): array
    {
        $paginator = $collection->resource;

        return [
            'current_page' => $paginator->currentPage(),
            'per_page' => $paginator->perPage(),
            'total' => $paginator->total(),
            'total_pages' => $paginator->lastPage(),
            'has_more' => $paginator->hasMorePages(),
            'links' => [
                'first' => $paginator->url(1),
                'last' => $paginator->url($paginator->lastPage()),
                'prev' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ];
    }

    /**
     * Return a created response
     */
    protected function createdResponse($data = null, string $message = 'Resource created successfully'): JsonResponse
    {
        return $this->successResponse($data, $message, 201);
    }

    /**
     * Return a no content response
     */
    protected function deletedResponse(string $message = 'Resource deleted successfully'): JsonResponse
    {
        return $this->successResponse(null, $message, 200);
    }

    /**
     * Return a not found response
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404, 'NOT_FOUND');
    }

    /**
     * Return an unauthorized response
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized'): JsonResponse
    {
        return $this->errorResponse($message, 401, 'UNAUTHORIZED');
    }

    /**
     * Return a forbidden response
     */
    protected function forbiddenResponse(string $message = 'Forbidden'): JsonResponse
    {
        return $this->errorResponse($message, 403, 'FORBIDDEN');
    }

    /**
     * Return a validation error response
     */
    protected function validationErrorResponse(array $errors): JsonResponse
    {
        return $this->errorResponse(
            'The given data was invalid.',
            422,
            'VALIDATION_ERROR',
            $errors
        );
    }
}
