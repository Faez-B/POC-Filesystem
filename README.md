# POC Filesystem

This is a Proof of Concept (POC) project demonstrating file upload and base64 image handling using Symfony.

## Requirements

- PHP 8.1 or higher
- Composer
- Symfony CLI

## Installation

1. Clone the repository:

    ```bash
    git clone https://github.com/Faez-B/POC-Filesystem.git
    ```

2. Navigate to the project directory:

    ```bash
    cd POC-Filesystem
    ```

3. Install dependencies:

    ```bash
    composer install
    ```

4. Set up environment variables:
    - Update the `BASE64` variable in the `.env.local` file in order to use `/base64` route.

5. Start the Symfony server:

    ```bash
    symfony serve -d
    ```

## Usage

### File Upload

1. Navigate to the home page:

    ```bash
    http://127.0.0.1:8000/
    ```

2. Use the form to upload a file. The file will be saved in the directory specified by the `%upload_dir%` environment variable, and its base64-encoded content will be displayed on the page.

### Save Base64 Image

1. Navigate to the base64 save route:

    ```bash
    http://127.0.0.1:8000/base64
    ```

2. The base64-encoded image content will be saved as a PNG file in the `%upload_dir%/base64` directory.

## Routes

- `/` - Home page with file upload form.
- `/base64` - Route to save base64-encoded image content.
