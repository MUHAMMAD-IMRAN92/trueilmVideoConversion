<?php

use Illuminate\Support\Facades\Response;

function sendSuccess($message, $data)
{
    return Response::json(array('status' => 'success', 'message' => $message, 'data' => $data), 200, []);
}

function sendError($error_message, $code, $data = null)
{
    return Response::json(array('status' => 'error', 'message' => $error_message, 'data' => $data), $code);
}
