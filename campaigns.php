<?php

// campaigns
function getCampaigns()
{
    return [
        [
            "campaignname" => "Transsion_Native_Campaign_Test_Nov_30_2024",
            "advertiser" => "TestGP",
            "price" => 0.1,
            "device_make" => "No Filter",
            "country" => "Bangladesh",
            "creative_type" => "201",
            "image_url" => "https://d2v3eqx6ppywls.cdn.net/600x600.jpg",
            "url" => "https://gamestar.shabox.mobi/",
            "native_title" => "GameStar",
            "native_data_value" => "Play Tournament Game",
            "native_data_cta" => "PLAY N WIN",
            "native_data_rating" => "1",
            "native_data_price" => "1"
        ]
    ];
}

// select campaigns by criteria
function selectCampaign($campaigns, $geo, $bidFloor)
{
    $eligibleCampaigns = array_filter($campaigns, function ($campaign) use ($geo, $bidFloor) {
        return (
            ($campaign['country'] === $geo['country'] || $campaign['country'] === "No Filter") &&
            $campaign['price'] >= $bidFloor
        );
    });

    if (empty($eligibleCampaigns)) {
        return null;
    }

    usort($eligibleCampaigns, function ($a, $b) {
        return $b['price'] <=> $a['price'];
    });

    return $eligibleCampaigns[0];
}
