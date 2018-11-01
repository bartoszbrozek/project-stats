<?php

namespace App\Service;

class JsonHelper
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param array $requiredParams
     * @return array|null|\Symfony\Component\HttpFoundation\Request
     * @throws \Exception
     */
    public function transformJsonBody(\Symfony\Component\HttpFoundation\Request $request, array $requiredParams = [])
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        if ($data === null) {
            return $request;
        }

        $request->request->replace($data);
        $requestArray = $request->request->all();

        foreach ($requiredParams as $requiredParam) {
            if (!isset($requestArray[$requiredParam])) {
                throw new \Exception("Param {$requiredParam} is missing");
            }
        }

        return $requestArray;

    }
}