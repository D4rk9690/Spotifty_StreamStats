# Spotify Stats Webpage

This project is a simulated Spotify stats webpage that displays information about your listening habits, including total minutes spent listening, total number of streams, most streamed artist, and top streamed tracks.

## Features

- Displays total minutes spent listening and total streams.
- Shows the most streamed artist from your Spotify listening history.
- Provides a dropdown menu to select and display details of top streamed tracks.

## Installation

1. Clone the repository or download the ZIP file.
2. Open the project folder in your preferred code editor.

## Usage

1. Place your Spotify listening history JSON file (`data.json`) in the project folder.
2. Open `index.php` in your web browser or set up a local server (e.g., XAMPP, WAMP, MAMP) to view the webpage.

## Customization

- Modify the `style.css` file to customize the webpage's visual appearance.
- Adjust the JavaScript code in `script.js` to add more interactivity or features.

## Example JSON Structure

The JSON file (`data.json`) should have a structure similar to the provided example:

```json
[
    {
        "ts": "2023-08-03T14:26:01Z",
        "username": "your_username",
        "platform": "windows",
        "ms_played": 67229,
        "master_metadata_album_artist_name": "NF",
        "master_metadata_track_name": "Grindin'"
        // ... other fields
    },
    // ... more entries
]
