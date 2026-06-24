<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'default_interest_rate', 'value' => '12', 'group' => 'general', 'label' => 'Taux d\'intérêt par défaut (%)'],
            ['key' => 'max_loan_duration', 'value' => '24', 'group' => 'general', 'label' => 'Durée max (mois)'],
            ['key' => 'currency', 'value' => 'CDF', 'group' => 'general', 'label' => 'Devise'],
            ['key' => 'penalty_rate', 'value' => '2', 'group' => 'general', 'label' => 'Taux de pénalité par défaut (%)'],
        ];

        foreach ($settings as $setting) {
            SystemSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
