<?php

// Validate request
function validateBidRequest($bidFloor, $geo)
{
    return $bidFloor > 0 && !empty($geo['country']);
}

// Bid response
function generateBidResponse($bidRequest, $campaign)
{
    $imp = $bidRequest['imp'][0];
    return [
        "id" => $bidRequest['id'],
        "bidid" => uniqid(),
        "seatbid" => [
            [
                "bid" => [
                    [
                        "price" => $campaign['price'],
                        "adm" => json_encode([
                            "native" => [
                                "assets" => [
                                    ["id" => 101, "title" => ["text" => $campaign['native_title']], "required" => 1],
                                    ["id" => 102, "data" => ["value" => $campaign['native_data_value'], "type" => 2], "required" => 1],
                                    ["id" => 103, "data" => ["value" => $campaign['native_data_cta'], "type" => 12], "required" => 1],
                                    ["id" => 104, "img" => ["url" => $campaign['image_url'], "w" => 600, "h" => 600], "required" => 1]
                                ],
                                "imptrackers" => [
                                    "https://tracking.example.com/imp?campaign=" . urlencode($campaign['campaignname'])
                                ],
                                "link" => [
                                    "url" => $campaign['url']
                                ]
                            ]
                        ]),
                        "id" => uniqid(),
                        "impid" => $imp['id'],
                        "crid" => uniqid(),
                        "bundle" => $campaign['url']
                    ]
                ],
                "seat" => "1001"
            ]
        ]
    ];
}
