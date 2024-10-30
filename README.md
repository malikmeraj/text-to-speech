# Text-to-Speech API (TTS) in PHP

This PHP API provides a simple text-to-speech (TTS) service using Google Translate's TTS functionality. It allows you to send a text input and receive an MP3 file with the spoken text. The API handles long text by splitting it into chunks of up to 199 characters, then combining the audio output.

## Features

- Converts text to speech using Google Translate's TTS.
- Splits long text into 199-character chunks to handle large inputs.
- Returns an MP3 audio file of the spoken text.

## Requirements

- PHP 7.0 or higher
- Web server (e.g., Apache, Nginx)
- Internet connection (for Google Translate API access)

     ```

## Usage

The API accepts text and language as parameters and returns an MP3 file with the spoken text.

### Request Parameters

- `text` (required): The text to convert to speech.
- `lang` (optional): The language code for the speech (default is `'en'` for English). Examples: `'en'`, `'es'`, `'fr'`, etc.

### Example Requests

#### CURL

You can use CURL to make requests to the API:

```bash
curl -X GET "http://your-server.com/tts_api.php?text=Hello%20world%20this%20is%20a%20test&lang=en" --output output.mp3
