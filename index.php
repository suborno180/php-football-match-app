<?php
// Fetch data from the provided API
$api_url = "https://script.googleusercontent.com/macros/echo?user_content_key=DAlRw_drlo9Ps13-fhExMHtEyvZmachPfRnjKoZNSYiN_9Ivt_JMXkoCPZ_z7xZRLeC3yvbQ_9_QHzA41ZIJcEAXsfyVAvQNm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnLHMUqpHDYDTz6A2INIMvvi7QUaUG75la6S2Iir2NOq58_idh1L442kQKpqux0BVq1plfeoh8f34aiuYO5R_nUaPZvrSdn96ig&lib=M-inZXM7_pDGicU58ND0rCWwDw1poLk9s";
$response = file_get_contents($api_url);
$data = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <title>Football Matches</title>
</head>
<body>
    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6 text-white">
        <div class="container mx-auto text-center">
            <h1 class="text-4xl font-extrabold mb-4">Exciting Football Matches</h1>
            <p class="text-lg">Experience the thrill of every game!</p>
        </div>
    </div>


            <?php // Check if the "output" key exists in the data
            if (isset($data["data"]["output"])) {
                $fixtures = $data["data"]["output"];

                // Loop through each fixture, starting from the second item (index 1)
                for ($i = 1; $i < count($fixtures); $i++) {
                    $fixture = $fixtures[$i];
                    ?>
                    <div class="mx-auto container max-w-[700px] px-4">
                        <a href="preview.php?fixture_id=<?php echo $fixture['fixture_id']; ?>&league_round=<?php echo urlencode($fixture['league_round']); ?>" target="_blank" rel="noopener noreferrer" class="flex items-center gap-4 p-2 border-y-[1px] hover:bg-blue-100" style="border: 0.5px solid gray;border-left: none; border-right: none; ">
                        <div style="width: 40px;">
                            <img src="./images/ball-football-icon.svg" class="w-10 h-10 object-cover" alt="">
                        </div>
                            <div>
                                <?php
                                // Extract time and date from the "fixture_date"
                                $fixtureTimestamp = strtotime($fixture['fixture_date']);
                                $time = date('h:i A', $fixtureTimestamp);

                                // Extract day and month and make it dynamic with the current year
                                $dayMonth = date('d M', $fixtureTimestamp);
                                $currentYear = date('Y');
                                $dynamicDate = "$dayMonth $currentYear";
                                ?>
                                <h2 class="whitespace-nowrap text-[13px]"><?php echo $time; ?></h2>
                                <h2 class="whitespace-nowrap text-[13px]"><?php echo $dynamicDate; ?></h2>
                            </div>
                            <div>
                                <h1 class="line-clamp-1 font-bold text-[13px]"><?php echo isset($fixture['teams_home_name']) ? $fixture['teams_home_name'] : 'N/A'; ?> - <span><?php echo isset($fixture['teams_away_name']) ? $fixture['teams_away_name'] : 'N/A'; ?></h1>
                                <h1 class="line-clamp-1 text-gray-500 text-[13px]"><?php echo isset($fixture['league_round']) ? $fixture['league_round'] : 'N/A'; ?></h1>
                            </div>
                        </a>
                    </div>
                <?php
                }
            } else {
                echo "No fixtures found in the data.";
            } ?>
        </div>
    </div>
</body>
</html>
