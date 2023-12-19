<?php
// Fetch data from the provided API (similar to your main file)
$api_url = "https://script.googleusercontent.com/macros/echo?user_content_key=DAlRw_drlo9Ps13-fhExMHtEyvZmachPfRnjKoZNSYiN_9Ivt_JMXkoCPZ_z7xZRLeC3yvbQ_9_QHzA41ZIJcEAXsfyVAvQNm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnLHMUqpHDYDTz6A2INIMvvi7QUaUG75la6S2Iir2NOq58_idh1L442kQKpqux0BVq1plfeoh8f34aiuYO5R_nUaPZvrSdn96ig&lib=M-inZXM7_pDGicU58ND0rCWwDw1poLk9s";
$response = file_get_contents($api_url);
$data = json_decode($response, true);

// Retrieve fixture_id from the URL
$fixture_id = isset($_GET['fixture_id']) ? $_GET['fixture_id'] : '';

// Filter the data based on the fixture_id
$fixture = array_filter($data["data"]["output"], function ($item) use ($fixture_id) {
    return $item['fixture_id'] == $fixture_id;
});

// Output the information for the selected fixture
if ($fixture) {
    $fixture = reset($fixture); // Get the first (and only) item from the filtered array
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $fixture['league_round']; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 p-4 lg:p-0">
    <div class="container mx-auto mt-8">
        <div class="mx-auto max-w-[500px] bg-white p-8 rounded-lg shadow-md mb-8">
            <div class="mb-6">
                <img src="<?php echo getValidImageUrl($fixture['respons_league_logo']); ?>" alt="League Logo" class="w-24 h-24 mx-auto mb-4">
                <h2 class="text-2xl font-bold text-center text-blue-600"><?php echo $fixture['league_round']; ?></h2>
                <p class="text-sm text-gray-600 text-center"><?php echo isset($fixture['response_league_name']) ? $fixture['response_league_name'] : 'N/A'; ?> - <?php echo isset($fixture['league_country']) ? $fixture['league_country'] : 'N/A'; ?></p>
            </div>

            <div class="flex justify-between items-center mb-6">
                <div class="text-center">
                    <img src="<?php echo getValidImageUrl($fixture['teams_home_logo']); ?>" alt="Home Team Logo" class="w-16 h-16 mx-auto mb-2 rounded-full border border-blue-500 p-1">
                    <p class="text-sm font-semibold"><?php echo $fixture['teams_home_name']; ?></p>
                </div>
                <div>
                    <span class="text-3xl font-bold text-gray-700">vs</span>
                </div>
                <div class="text-center">
                    <img src="<?php echo getValidImageUrl($fixture['teams_away_logo']); ?>" alt="Away Team Logo" class="w-16 h-16 mx-auto mb-2 rounded-full border border-blue-500 p-1">
                    <p class="text-sm font-semibold"><?php echo $fixture['teams_away_name']; ?></p>
                </div>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">Status: <?php echo $fixture['fixture_status_long']; ?></p>
                <p class="text-xs text-gray-500"><?php echo formatUtcTimestamp($fixture['fixture_date']); ?></p>
            </div>

            <div class="mt-6">
                <div class="flex justify-between items-center">
                    <div>
                        <img src="<?php echo getValidImageUrl($fixture['league_flag']); ?>" alt="Country Flag" class="w-6 h-6">
                        <span class="text-xs text-gray-500"><?php echo $fixture['league_country']; ?></span>
                    </div>
                    <span class="text-xs text-gray-500">Venue: <?php echo $fixture['fixture_venue_city']; ?></span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


<?php
} else {
    echo 'No data found for the specified fixture_id.';
}

function formatUtcTimestamp($utcTimestamp)
{
    $date = new DateTime($utcTimestamp, new DateTimeZone('UTC'));
    $date->setTimeZone(new DateTimeZone('America/New_York')); // Replace with your target timezone
    return $date->format('D, M d, Y H:i:s T');
}


function getValidImageUrl($url)
{
    // Check if the URL is empty or undefined
    if (!$url) {
        // Replace with the URL of your placeholder image
        return 'https://via.placeholder.com/150';
    }
    return $url;
}
?>
