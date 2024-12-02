<?php
require_once 'campaigns.php';
require_once 'helpers.php';

// Handle request
$bidRequestRaw = file_get_contents('php://input');
$bidRequest = json_decode($bidRequestRaw, true);

if (!$bidRequest || empty($bidRequest['id']) || empty($bidRequest['imp'])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid bid request"]);
    exit;
}

// Parameters
$imp = $bidRequest['imp'][0];
$device = $bidRequest['device'] ?? [];
$geo = $device['geo'] ?? [];
$bidFloor = $imp['bidfloor'] ?? 0;

// Validate data
if (!validateBidRequest($bidFloor, $geo)) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid bid request parameters"]);
    exit;
}

// Campaigns
$campaigns = getCampaigns();
$selectedCampaign = selectCampaign($campaigns, $geo, $bidFloor);
if (!$selectedCampaign) {
    http_response_code(204);
    exit;
}

// Send response
$bidResponse = generateBidResponse($bidRequest, $selectedCampaign);
header('Content-Type: application/json');
echo json_encode($bidResponse, JSON_PRETTY_PRINT);
