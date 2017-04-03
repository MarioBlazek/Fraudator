<?php

namespace Marek\Fraudator\Http;

class Client
{
    /**
     * @param Request $request
     *
     * @return Response
     */
    public function execute(Request $request)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $request->getUrl());
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($request->hasAuth()) {
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, $request->getAuth());
        }

        if ($request->isPost()) {
            $data = json_encode($request->getData());
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($data)
                ]
            );
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        $code = $info['http_code'];

        if (!empty(curl_error($ch))) {
            $code = 500;
        }

        curl_close($ch);

        return new Response($code, $result);
    }
}