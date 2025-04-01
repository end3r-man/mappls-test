# Laravel Map API

This Laravel project provides an API endpoint to fetch location details. Users can retrieve location data either by default settings or by specifying an address through query parameters.

## Disclaimer

This project is developed for educational purposes and ethical bug bounty research only. It should not be used for any illegal activities. The creators and contributors are not responsible for any misuse of this software.

## Installation

1. Clone the repository:
   ```sh
   git clone https://github.com/end3r-man/mappls-test.git
   cd mappls-test
   ```

2. Install dependencies:
   ```sh
   composer install
   ```

3. Set up environment variables:
   ```sh
   cp .env.example .env
   ```
   Update the `.env` file with your configuration.

4. Generate application key:
   ```sh
   php artisan key:generate
   ```

5. Run the server:
   ```sh
   php artisan serve
   ```

## API Endpoint

### Get Location

#### Route:
```http
GET /map
```

#### Parameters:
| Parameter | Type   | Description                          |
|-----------|--------|--------------------------------------|
| address   | string | (Optional) Address for geolocation  |

#### Example Requests:

1. **Without parameters:**
   ```sh
   curl -X GET "http://localhost:8000/map"
   ```

2. **With an address:**
   ```sh
   curl -X GET "http://localhost:8000/map?address=chennai"
   ```

#### Example Response:
```json
{
    "copResults": {
        "houseNumber": "",
        "houseName": "",
        "poi": "",
        "street": "",
        "subSubLocality": "",
        "subLocality": "",
        "locality": "",
        "village": "",
        "subDistrict": "",
        "district": "Chennai District",
        "city": "Chennai",
        "state": "Tamil Nadu",
        "pincode": "",
        "floorNumber": "",
        "formattedAddress": "Chennai, Tamil Nadu",
        "eLoc": "2KK6DX",
        "latitude": 13.082881,
        "longitude": 80.276002,
        "geocodeLevel": "city",
        "confidenceScore": 0.8,
        "matching": "- - - - - - - - - E E O -",
        "eopScore": 20,
        "partialMatch": "- - - - - - - - - - - - -",
        "matchScore": "- - - - - - - - - 100 100 - -"
    }
}
```

## License

This project is licensed under the [MIT License](LICENSE).

