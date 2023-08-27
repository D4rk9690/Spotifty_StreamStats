<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Spotify Stats</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #1a1a1a;
    color: white;
}

.spotify-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #212121;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
}

.spotify-header {
    text-align: center;
    margin-bottom: 20px;
}

.spotify-header img {
    width: 100px;
    height: 100px;
}

.spotify-stats p {
    font-size: 18px;
    margin: 10px 0;
}

span {
    color: #1DB954;
    font-weight: bold;
}

.total-minutes::before,
.total-streams::before {
    content: "🎧 ";
}

.spotify-stats p::before {
    content: "🎶 ";
}

h1 {
    font-size: 28px;
    margin-top: 0;
}

.top-tracks {
    margin-top: 20px;
}

.top-tracks h2 {
    font-size: 24px;
    margin-bottom: 10px;
}

.track-dropdown {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color:  #1a1a1a;
    cursor: pointer;
    appearance: none;
    -webkit-appearance: none;
    background-image: url('dropdown-arrow.png');
    background-position: right center;
    background-repeat: no-repeat;
    background-size: 20px;
    color: white;
}

.track-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.track-list li {
    font-size: 16px;
    margin-bottom: 5px;
}

.track-name {
    font-weight: bold;
    color: #1DB954;
}
    </style>

</head>
<body>
    <div class="spotify-container">
        <div class="spotify-header">
            <img src="spotify_logo.png" alt="Spotify Logo">
            <h1>Your Spotify Stats</h1>
        </div>
        <div class="spotify-stats">
            <?php
            $jsonData = json_decode(file_get_contents("data.json"), true); // Replace with actual JSON file path
            
            $totalMinutes = 0;
            $totalStreams = 0;
            $artistStreams = [];
            
            foreach ($jsonData as $entry) {
                $ms_played = $entry["ms_played"] ?? 0;
                $totalMinutes += $ms_played / 60000;
                $totalStreams++;
                
                $artist = $entry["master_metadata_album_artist_name"] ?? null;
                if ($artist) {
                    if (!isset($artistStreams[$artist])) {
                        $artistStreams[$artist] = 0;
                    }
                    $artistStreams[$artist]++;
                }
            }
            
            // Find the most streamed artist
            $mostStreamedArtist = "";
            $maxStreams = 0;
            
            foreach ($artistStreams as $artist => $streams) {
                if ($streams > $maxStreams) {
                    $maxStreams = $streams;
                    $mostStreamedArtist = $artist;
                }
            }
            ?>
            <p class='total-minutes'>Total minutes spent listening: <span> <?php echo number_format($totalMinutes, 2)  ?> </span>minutes</p>
            <p class='total-streams'>Total number of streams: <span> <?php echo $totalStreams ?> </span></p>
            <p class='most-streamed-artist'>Most streamed artist: <span> <?php echo $mostStreamedArtist ?> </span></p>
            

            <div class="top-tracks">
            <h2>Your Top Streamed Tracks</h2>
            <div class="custom-dropdown">
                <select class="track-dropdown" onchange="displayTrackInfo(this)">
                    <option value="">Select a track</option>
                    <?php
                    $trackData = [];
                    
                    foreach ($jsonData as $entry) {
                        $trackName = $entry["master_metadata_track_name"] ?? "Unknown Track";
                        if (!isset($trackData[$trackName])) {
                            $trackData[$trackName] = 0;
                        }
                        $trackData[$trackName]++;
                    }
                    
                    arsort($trackData);
                    
                    foreach ($trackData as $trackName => $playCount) {
                        echo "<option value='$playCount'>$trackName</option>";
                    }
                    ?>
                </select>
            </div>
            <ul id="selected-track-info" class="track-list"></ul>
        </div>

        </div>
    </div>

    <script>
    function displayTrackInfo(select) {
        const selectedTrackInfo = document.getElementById("selected-track-info");
        selectedTrackInfo.innerHTML = "";
        
        if (select.value) {
            const trackName = select.options[select.selectedIndex].text;
            const playCount = select.value;
            const listItem = document.createElement("li");
            listItem.innerHTML = `<span class='track-name'>${trackName}:</span> ${playCount} plays`;
            selectedTrackInfo.appendChild(listItem);
        }
    }
    </script>
</body>
</html>