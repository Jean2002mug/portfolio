<?php
// Retired endpoint: the free AI matcher runs in the visitor's browser.
// No external AI inference API is called by the website.
http_response_code(410);
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
echo json_encode(['error' => 'This endpoint has been retired. Please use ai.php.']);
