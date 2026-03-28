# Uzbekistan Learning Centers Seeder

## Usage

To seed the database with Uzbekistan learning centers data:

```bash
php artisan db:seed --class=UzbekistanLearningCentersSeeder
```

Or run all seeders including this one:

```bash
php artisan db:seed
```

## Features

- **Automatic Data Processing**: Reads from `database/data/uzbekistan_learning_centers.json`
- **Data Cleaning**: Cleans and validates all center data
- **Image Handling**: Processes and stores center images
- **Progress Tracking**: Shows progress during seeding
- **Error Handling**: Skips invalid entries and continues processing
- **Memory Efficient**: Processes data in batches to avoid memory issues

## Data Structure

The seeder expects the JSON file to have the following structure:

```json
{
  "generated_at": "2026-03-28T07:26:37.146580",
  "country": "uzbekistan", 
  "total": 1664,
  "centers": [
    {
      "name": "Center Name",
      "type": "O'quv markazi",
      "about": "Description",
      "province": "Tashkent",
      "region": "District",
      "address": "Full address",
      "location": "41.2920045,69.3296072",
      "images": [
        {
          "url": "https://...",
          "width": 4208,
          "height": 3120
        }
      ]
    }
  ]
}
```

## Notes

- Requires a default user to exist in the users table
- Images are stored as URLs (can be modified to download actual files)
- All existing learning centers and images will be cleared before seeding
- Uses the first available user ID as the owner of all centers
