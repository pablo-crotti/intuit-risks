<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Dangers humains et sociaux',
                'label' => 'HUMSOC',
                'color' => '#BACBA9',
                'created_at' => now(),
                'description_short' => 'Risques liés à des comportements humains ou à des impacts sociaux négatifs.',
                'description_long' => 'Ces risques englobent les menaces telles que les conflits sociaux, les crises de réputation, et les impacts sur la santé et la sécurité des individus, qui peuvent résulter de comportements humains imprévus ou de problèmes sociaux sous-jacents.',
            ],
            [
                'name' => 'Dangers de santé',
                'label' => 'SAN',
                'color' => '#E08E45',
                'created_at' => now(),
                'description_short' => 'Risques pouvant affecter la santé physique ou mentale des individus.',
                'description_long' => 'Ces risques incluent les maladies infectieuses, les accidents de travail, les risques psychosociaux, et les dangers sanitaires liés à l\'environnement, qui peuvent avoir un impact direct sur la santé et le bien-être des individus.',
            ],
            [
                'name' => 'Dangers sécuritaires',
                'label' => 'SEC',
                'color' => '#6B2737',
                'created_at' => now(),
                'description_short' => 'Risques liés à la sécurité physique des personnes ou des biens.',
                'description_long' => 'Ces risques comprennent les menaces telles que le terrorisme, la criminalité, les accidents industriels, les cyberattaques et autres incidents qui compromettent la sécurité physique des individus, des biens ou des infrastructures.',
            ],
            [
                'name' => 'Dangers économiques et financiers',
                'label' => 'ECOFIN',
                'color' => '#3943B7',
                'created_at' => now(),
                'description_short' => 'Risques susceptibles de causer des pertes financières ou de compromettre la stabilité économique.',
                'description_long' => 'Ces risques incluent les fluctuations des marchés financiers, les crises économiques, les défaillances d\'entreprises, les changements législatifs et réglementaires, ainsi que les événements géopolitiques qui peuvent affecter les performances économiques et financières d\'une organisation.',
            ],
            [
                'name' => 'Dangers métiers',
                'label' => 'MET',
                'color' => '#8380B6',
                'created_at' => now(),
                'description_short' => 'Risques spécifiques à une profession ou à un secteur d\'activité.',
                'description_long' => 'Ces risques concernent les défis opérationnels, technologiques ou commerciaux propres à une industrie particulière, tels que l\'obsolescence des compétences, la concurrence accrue, les changements de marché ou les interruptions de chaîne d\'approvisionnement.',
            ],
            [
                'name' => 'Dangers d\'approvisionnement',
                'label' => 'APP',
                'color' => '#7A6C5D',
                'created_at' => now(),
                'description_short' => 'Risques associés à l\'indisponibilité ou à l\'interruption des fournitures nécessaires.',
                'description_long' => 'Ces risques englobent les interruptions de chaîne d\'approvisionnement, les pénuries de matières premières, les défaillances de fournisseurs clés, ainsi que les perturbations logistiques qui peuvent compromettre la continuité des opérations d\'une organisation.',
            ],
            [
                'name' => 'Dangers infrastructurels',
                'label' => 'INFRA',
                'color' => '#13505B',
                'created_at' => now(),
                'description_short' => 'Risques liés à la défaillance ou à la vulnérabilité des infrastructures essentielles.',
                'description_long' => 'Ces risques concernent les menaces telles que les défaillances d\'infrastructures critiques (énergie, transport, télécommunications), les catastrophes naturelles, les défauts de conception ou de maintenance, qui peuvent perturber les opérations ou causer des dommages significatifs.',
            ],
            [
                'name' => 'Dangers institutionnels et réglementaires',
                'label' => 'INSREG',
                'color' => '#EFCA08',
                'created_at' => now(),
                'description_short' => 'Risques liés à l\'instabilité politique, aux réglementations changeantes et aux risques géopolitiques.',
                'description_long' => ': Risques liés à l\'instabilité politique, aux changements réglementaires et aux risques géopolitiques affectant les opérations commerciales et la stabilité économique',
            ],
            [
                'name' => 'Dangers politiques',
                'label' => 'POL',
                'color' => '#9E8576',
                'created_at' => now(),
                'description_short' => 'Risques découlant de changements politiques ou de réglementations.',
                'description_long' => 'Ces risques comprennent les instabilités politiques, les changements de gouvernement, les modifications de politiques publiques, les conflits internationaux ou les sanctions économiques, qui peuvent affecter les opérations commerciales et la stabilité des marchés.',
            ],
            [
                'name' => 'Dangers d\'image',
                'label' => 'IMG',
                'color' => '#F15BB5',
                'created_at' => now(),
                'description_short' => 'Risques liés à la réputation ou à l\'image publique d\'une organisation.',
                'description_long' => 'Ces risques englobent les dommages potentiels à la réputation d\'une organisation, y compris les conséquences de mauvaises décisions, les crises médiatiques, et les perceptions négatives du public.',
            ],
            [
                'name' => 'Dangers environnementaux',
                'label' => 'ENV',
                'color' => '#04E762',
                'created_at' => now(),
                'description_short' => 'Risques liés aux dommages écologiques ou aux catastrophes naturelles.',
                'description_long' => 'Ces risques englobent les accidents environnementaux, le changement climatique, la pollution, la déforestation, les perturbations écologiques et les événements météorologiques extrêmes, qui peuvent avoir un impact direct sur l\'environnement naturel et sur les activités humaines qui en dépendent.',
            ],
            [
                'name' => 'Dangers liés à la prise en charge des patients',
                'label' => 'PAT',
                'color' => '#D3C0D2',
                'created_at' => now(),
                'description_short' => 'Risques liés à la prise en charge des patients dans un cadre médical ou sanitaire.',
                'description_long' => 'Ces risques incluent les erreurs médicales, les problèmes de sécurité des patients, les préoccupations éthiques, et les défis liés à la gestion des soins de santé, qui peuvent affecter la qualité des soins et la confiance du public envers les établissements de santé.',
            ],
        ]);
    }
}
