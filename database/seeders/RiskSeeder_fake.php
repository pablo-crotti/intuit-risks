<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RiskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $riskData = [
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Dolor sit amet consectetur adipiscing',
                'description' => 'Elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Institution médico-sociale', 'Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Lorem ipsum dolor sit amet',
                'description' => 'Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Consectetur adipiscing elit',
                'description' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Sed do eiusmod tempor incididunt',
                'description' => 'Ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Ut labore et dolore magna aliqua',
                'description' => 'Enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Enim ad minim veniam',
                'description' => 'Quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Quis nostrud exercitation ullamco',
                'description' => 'Laboris nisi ut aliquip ex ea commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Laboris nisi ut aliquip ex ea',
                'description' => 'Commodo consequat.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Commodo consequat',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'category' => 'Dangers environnementaux',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ]
        ];

        foreach ($riskData as $risk) {
            $categoryId = DB::table('categories')->where('name', $risk['category'])->first()->id;

            $riskId = DB::table('risks')->insertGetId([
                'name' => $risk['name'],
                'description' => $risk['description'],
                'category_id' => $categoryId,
                'is_active' => true,
                'created_at' => now(),
            ]);

            foreach ($risk['organization_types'] as $organizationType) {
                $organizationTypeId = DB::table('organization_types')->where('name', $organizationType)->first()->id;
                DB::table('organization_type_risk')->insert([
                    'organization_type_id' => $organizationTypeId,
                    'risk_id' => $riskId,
                    'created_at' => now(),
                ]);
            }
        }
    }
}
