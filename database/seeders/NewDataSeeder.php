<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LearningCenter;
use App\Models\SubjectsOfLearningCenter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = database_path('baza/new_data.json');

        if (!file_exists($jsonPath)) {
            $this->command->error('JSON file not found: ' . $jsonPath);
            return;
        }

        $jsonContent = file_get_contents($jsonPath);
        $jsonData = json_decode($jsonContent, true);

        if (empty($jsonData) || !is_array($jsonData)) {
            $this->command->error('Invalid JSON structure or empty file');
            return;
        }

        $total = count($jsonData);
        $this->command->info("Seeding {$total} learning centers from new_data.json...");

        $defaultUserId = DB::table('users')->value('id') ?? 1;
        $processed = 0;
        $errors = 0;

        foreach ($jsonData as $index => $centerData) {
            try {
                // Extract province and region from legal address or business address
                $address = $centerData['Legaladdress'] ?? $centerData['Businessaddress'] ?? '';
                $province = $this->extractProvince($address);
                $region = $this->extractRegion($address);

                // Determine status based on Status_from_web
                $status = 'active';
                if (isset($centerData['Status_from_web']) && $centerData['Status_from_web'] === 'Tugatilgan') {
                    $status = 'inactive';
                }

                // Check for duplicate TIN
                $tin = $centerData['TIN'] ?? null;
                if ($tin && LearningCenter::where('tin', $tin)->exists()) {
                    $this->command->warn("Skipping center {$index}: TIN {$tin} already exists");
                    continue;
                }

                // Create learning center
                $learningCenter = LearningCenter::create([
                    'tin' => $tin,
                    'name' => $this->cleanString($centerData['Nameoftheeducationalinstitution'] ?? ''),
                    'type' => $this->mapType($centerData['Typeofeducationalactivity'] ?? 'MT'),
                    'about' => $this->cleanString($centerData['Listofeducationaldirections'] ?? ''),
                    'country' => 'uzbekistan',
                    'province' => $province,
                    'region' => $region,
                    'address' => $this->cleanString($centerData['Businessaddress'] ?? $centerData['Legaladdress'] ?? ''),
                    'legal_address' => $this->cleanString($centerData['Legaladdress'] ?? ''),
                    'territory' => $this->cleanString($centerData['Territory'] ?? ''),
                    'license_number' => $centerData['Licensenumber'] ?? null,
                    'license_registration_date' => $this->parseDate($centerData['Licenseregistrationdate'] ?? null),
                    'license_validity_period' => $this->parseDate($centerData['Licensevalidityperiod'] ?? null),
                    'manager_name' => $this->cleanString($centerData['Manager_Name'] ?? ''),
                    'phone_number' => $this->cleanPhone($centerData['Phone_Number'] ?? ''),
                    'email' => $this->cleanEmail($centerData['Email'] ?? ''),
                    'ifut_code' => $this->cleanString($centerData['IFUT'] ?? ''),
                    'users_id' => $defaultUserId,
                    'status' => $status,
                    'checked' => true,
                    'student_count' => 0,
                    'rating' => 0,
                    'ratings_total' => 0,
                    'total_reyting' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Seed subjects from Listofeducationaldirections
                if (!empty($centerData['Listofeducationaldirections'])) {
                    $this->seedSubjects($learningCenter->id, $centerData['Listofeducationaldirections']);
                }

                $processed++;

                if (($index + 1) % 100 === 0) {
                    $this->command->info("Processed " . ($index + 1) . " / {$total} centers");
                }

            } catch (\Exception $e) {
                $errors++;
                $this->command->error("Error processing center {$index}: " . $e->getMessage());
                continue;
            }
        }

        $this->command->info("Successfully seeded {$processed} learning centers! Errors: {$errors}");
    }

    /**
     * Extract province from address
     */
    private function extractProvince(string $address): string
    {
        $address = strtolower($address);

        $provinces = [
            'toshkent' => 'Toshkent',
            'samarqand' => 'Samarqand',
            'buxoro' => 'Buxoro',
            'andijon' => 'Andijon',
            'fergana' => 'Farg\'ona',
            'namangan' => 'Namangan',
            'xorazm' => 'Xorazm',
            'navoiy' => 'Navoiy',
            'qashqadaryo' => 'Qashqadaryo',
            'surxondaryo' => 'Surxondaryo',
            'jizzax' => 'Jizzax',
            'sirdaryo' => 'Sirdaryo',
            'toshkent viloyati' => 'Toshkent viloyati',
            'qoraqalpog\'iston' => 'Qoraqalpog\'iston',
        ];

        foreach ($provinces as $key => $value) {
            if (str_contains($address, $key)) {
                return $value;
            }
        }

        return '';
    }

    /**
     * Extract region from address (city/district)
     */
    private function extractRegion(string $address): string
    {
        // Try to extract district/shahar/tuman from address
        if (preg_match('/(?:shahri|tumani|shahar)\s*,?\s*([^,]+)/iu', $address, $matches)) {
            return trim($matches[1]);
        }

        return '';
    }

    /**
     * Map educational activity type
     */
    private function mapType(string $type): string
    {
        $typeMap = [
            'MT' => 'Maktabgacha ta\'lim',
            'QO\'SHIMCHA' => 'Qo\'shimcha ta\'lim',
            'MAXSUS' => 'Maxsus ta\'lim',
        ];

        return $typeMap[$type] ?? 'Boshqa ta\'lim';
    }

    /**
     * Parse date string to Y-m-d format
     */
    private function parseDate(?string $date): ?string
    {
        if (empty($date) || $date === 'N/A') {
            return null;
        }

        try {
            return date('Y-m-d', strtotime($date));
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Clean phone number
     */
    private function cleanPhone(string $phone): string
    {
        $phone = preg_replace('/[^\d,\s]/', '', $phone);
        return trim($phone);
    }

    /**
     * Clean email
     */
    private function cleanEmail(string $email): ?string
    {
        $email = strtolower(trim($email));
        if (empty($email) || $email === 'yo\'q' || $email === 'mavjud emas' || !str_contains($email, '@')) {
            return null;
        }
        return $email;
    }

    /**
     * Clean string data
     */
    private function cleanString(string $string): string
    {
        return trim(preg_replace('/\s+/', ' ', $string));
    }

    /**
     * Seed subjects for learning center
     */
    private function seedSubjects(int $centerId, string $directions): void
    {
        // Split directions by new lines or numbers
        $subjects = preg_split('/\r\n|\r|\n|\d+\./', $directions, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($subjects as $subject) {
            $subject = $this->cleanString($subject);
            if (empty($subject) || strlen($subject) < 3) {
                continue;
            }

            try {
                DB::table('subjects_of_learning_centers')->insert([
                    'learning_centers_id' => $centerId,
                    'subject_name' => $subject,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                // Skip duplicate or error
                continue;
            }
        }
    }
}
