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
                'name' => 'Perte de motivation des employés et perte de personnel-clé',
                'description' => 'Un manque de reconnaissance, de développement professionnel ou de satisfaction au travail peut entraîner une baisse de motivation et une diminution de la productivité. Cela peut également provoquer la perte de personnel-clé.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Perte de motivation des employés',
                'description' => 'Un manque de reconnaissance, de développement professionnel ou de satisfaction au travail peut entraîner une baisse de motivation et une diminution de la productivité.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Absentéisme et turnover élevés',
                'description' => 'Un taux élevé d\'absentéisme ou de rotation du personnel peut indiquer des problèmes de gestion ou de satisfaction au travail.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Conflits interpersonnels',
                'description' => 'Les désaccords et les tensions entre collègues ou entre différentes équipes peuvent créer un environnement de travail négatif et affecter la collaboration et la communication.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Problèmes de leadership',
                'description' => 'Une mauvaise gestion ou des conflits internes peuvent affecter la performance et la motivation des employés.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Harcèlement moral ou sexuel',
                'description' => 'Des comportements inappropriés au travail, tels que le harcèlement moral ou sexuel, peuvent créer un climat de travail toxique et nuire à la santé mentale et physique des employés.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Pénurie de personnel qualifié',
                'description' => 'Vieillissement de la population, manque d\'attrait de la profession, migration vers d\'autres métiers, formation insuffisante, rémunération et conditions de travail peu attractives sont les principales causes de pénurie de personnel qualifié.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Grèves',
                'description' => 'Des mouvements de grève peuvent perturber les activités de l\'entreprise et entraîner des retards ou des arrêts de production.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Grèves',
                'description' => 'Des mouvements de grève peuvent perturber les activités de l\'administration et entraîner des retards.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Grèves',
                'description' => 'Des mouvements de grève peuvent perturber les activités de l\'institution et entraîner une mauvaise qualité de prise en charge.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Dangers sociaux',
                'description' => 'Les autorités publiques peuvent être confrontées à des risques sociaux, tels que les tensions sociales, les conflits politiques, les manifestations, etc. Ces risques peuvent avoir un impact sur la stabilité du gouvernement et de la société et nécessitent une gestion efficace pour maintenir l\'ordre public et la confiance des citoyens.',
                'category' => 'Dangers humains et sociaux',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Maladies professionnelles',
                'description' => 'Certains secteurs d\'activité peuvent exposer les travailleurs à des maladies professionnelles spécifiques, telles que l\'exposition à des produits chimiques dangereux, des radiations, des agents infectieux, etc.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Maladies professionnelles',
                'description' => 'Exposition à des produits chimiques, des radiations, des agents infectieux, etc.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Conditions de travail dangereuses',
                'description' => 'Les conditions de travail peuvent influencer la santé des employés. Par exemple, des postes de travail mal aménagés, des environnements bruyants, des températures extrêmes, etc., peuvent entraîner des problèmes de santé à long terme.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Stress professionnel',
                'description' => 'Le stress au travail peut avoir un impact significatif sur la santé mentale et physique des employés. Des charges de travail excessives, des délais serrés, des conflits interpersonnels, etc., peuvent contribuer au stress et à ses conséquences néfastes.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Absence de mesures de santé et de sécurité',
                'description' => 'Si une entreprise ne met pas en place des mesures adéquates en matière de santé et de sécurité au travail, cela peut entraîner des accidents, des blessures et des problèmes de santé pour les employés.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Absence de mesures de santé et de sécurité',
                'description' => 'Si une administration ne met pas en place des mesures adéquates en matière de santé et de sécurité au travail, cela peut entraîner des accidents, des blessures et des problèmes de santé pour les employés.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Absence de mesures de santé et de sécurité',
                'description' => 'Si une institution ne met pas en place des mesures adéquates en matière de santé et de sécurité au travail, cela peut entraîner des accidents, des blessures et des problèmes de santé pour les employés.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Exposition à des agents pathogènes',
                'description' => 'Dans certains secteurs, les travailleurs peuvent être exposés à des agents pathogènes, tels que des virus, des bactéries ou des champignons, ce qui peut augmenter le risque de maladies et d\'infections.',
                'category' => 'Dangers de santé',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ], [
                'name' => 'Brigandage',
                'description' => 'Les vols et les cambriolages peuvent représenter un danger pour la sécurité des employés et la protection des biens de l\'entreprise.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Terrorisme',
                'description' => 'Les attaques terroristes peuvent causer des dommages importants aux infrastructures et mettre en danger la vie des employés.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Espionnage industriel',
                'description' => 'Le vol de données sensibles, les attaques informatiques ou les infiltrations d\'agents étrangers peuvent menacer la sécurité des entreprises.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Violences internes',
                'description' => 'Les conflits entre employés, les actes de sabotage ou les agressions physiques peuvent également constituer des dangers sécuritaires.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Attaques informatiques',
                'description' => 'Les cyberattaques, telles que les attaques de phishing, les logiciels malveillants ou les violations de données, peuvent causer des perturbations majeures dans les opérations de l\'entreprise et compromettre la sécurité des informations.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Brigandage',
                'description' => 'Les vols et les cambriolages peuvent représenter un danger pour la sécurité des employés et la protection des biens de l\'administration.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Terrorisme',
                'description' => 'Les attaques terroristes peuvent causer des dommages importants aux infrastructures et mettre en danger la vie des employés et de la population.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Espionnage',
                'description' => 'Le vol de données sensibles, les attaques informatiques ou les infiltrations d\'agents étrangers peuvent menacer la sécurité des administrations.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Violences internes',
                'description' => 'Les conflits entre employés, les actes de sabotage ou les agressions physiques peuvent également constituer des dangers sécuritaires.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Émeutes et violences sociales',
                'description' => 'Les émeutes et les violences sociales créent un climat d\'instabilité sociale. Cela peut entraîner une méfiance généralisée, une polarisation de la société et une détérioration des relations intercommunautaires. L\'instabilité sociale peut également compromettre le fonctionnement des institutions et des services publics.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Attaques informatiques',
                'description' => 'Les cyberattaques, telles que les attaques de phishing, les logiciels malveillants ou les violations de données, peuvent causer des perturbations majeures dans les opérations de l\'administration et compromettre la sécurité des informations.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Brigandage',
                'description' => 'Les vols et les cambriolages peuvent représenter un danger pour la sécurité des employés, des patients et la protection des biens de l\'institution.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Terrorisme',
                'description' => 'Les attaques terroristes peuvent causer des dommages importants aux infrastructures et mettre en danger la vie des employés et des patients.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Violences internes',
                'description' => 'Les conflits entre employés, les actes de sabotage ou les agressions physiques peuvent également constituer des dangers sécuritaires.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Attaques informatiques',
                'description' => 'Les cyberattaques, telles que les attaques de phishing, les logiciels malveillants ou les violations de données, peuvent causer des perturbations majeures dans les opérations de l\'institution et compromettre la sécurité des informations.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Institution médico-sociale']
            ], [
                'name' => 'Problèmes de trésorerie',
                'description' => 'Une mauvaise gestion des flux de trésorerie peut entraîner des difficultés financières, telles que des retards de paiement aux fournisseurs ou des difficultés à honorer les obligations financières.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Fluctuations des marchés financiers',
                'description' => 'Les variations des taux de change, des prix des matières premières ou des marchés financiers peuvent avoir un impact sur les résultats financiers de l\'entreprise, en particulier pour les entreprises qui opèrent à l\'échelle internationale.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Concurrence accrue',
                'description' => 'L\'entrée de nouveaux concurrents sur le marché ou l\'évolution des préférences des consommateurs peuvent réduire la part de marché de l\'entreprise et affecter ses revenus.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Ralentissement économique',
                'description' => 'Une récession économique ou une crise financière peut entraîner une diminution de la demande des consommateurs, ce qui peut affecter les ventes et les revenus de l\'entreprise.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Instabilité politique',
                'description' => 'Les changements politiques, tels que les changements de réglementation ou les politiques fiscales, peuvent avoir un impact sur l\'environnement des affaires et les résultats financiers de l\'entreprise.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Difficultés d\'accès au financement',
                'description' => 'Une entreprise peut rencontrer des difficultés à obtenir des prêts bancaires ou à lever des fonds, ce qui peut limiter sa capacité à investir et à se développer.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Entreprise', 'Institution médico-sociale']
            ],
            [
                'name' => 'Crise financière et récession',
                'description' => 'Les autorités publiques peuvent être confrontées à des risques économiques, tels que les crises financières et les récessions. Ces risques peuvent avoir un impact sur la santé économique d\'un pays, d\'une région, d\'une commune et nécessitent une gestion proactive pour atténuer les effets négatifs.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Fluctuations des marchés financiers',
                'description' => 'Les variations des taux de change, des prix des matières premières ou des marchés financiers peuvent avoir un impact sur les résultats de l\'administration.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Ralentissement économique',
                'description' => 'Une récession économique ou une crise financière peut entraîner une diminution des recettes de l\'administration.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Instabilité politique',
                'description' => 'Les changements politiques, tels que les changements de réglementation ou les politiques fiscales, peuvent avoir un impact sur les recettes de l\'administration.',
                'category' => 'Dangers économiques et financiers',
                'organization_types' => ['Administration publique']
            ], [
                'name' => 'Accidents de travail',
                'description' => 'Les accidents de travail peuvent survenir dans des environnements industriels ou dans des secteurs où les employés sont exposés à des risques physiques. Cela peut inclure des blessures causées par des machines, des chutes, des produits chimiques dangereux, etc.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Pannes de machines',
                'description' => 'Les pannes de machines peuvent entraîner des interruptions de production, des retards dans les livraisons ou des coûts de réparation élevés. Cela peut avoir un impact sur la productivité et les résultats financiers de l\'entreprise.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Incendies ou explosions',
                'description' => 'Les incendies ou les explosions peuvent causer des dommages matériels importants, mettre en danger la sécurité des employés et entraîner des pertes financières considérables.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Pollution environnementale',
                'description' => 'Les entreprises opérant dans des secteurs industriels peuvent être confrontées à des risques de pollution de l\'air, de l\'eau ou du sol. Cela peut entraîner des sanctions légales, des dommages à l\'image de l\'entreprise et des conséquences néfastes pour l\'environnement.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Risques liés aux produits',
                'description' => 'Les entreprises qui fabriquent ou vendent des produits peuvent être confrontées à des risques liés à la qualité ou à la sécurité de leurs produits. Cela peut entraîner des rappels de produits, des litiges juridiques et des pertes financières.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Risques liés à la chaîne d\'approvisionnement',
                'description' => 'Les entreprises qui dépendent de fournisseurs ou de partenaires pour leurs activités peuvent être exposées à des risques liés à la fiabilité de leur chaîne d\'approvisionnement. Cela peut inclure des retards de livraison, des problèmes de qualité des produits ou des ruptures d\'approvisionnement.',
                'category' => 'Dangers métiers',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Santé des résidents',
                'description' => 'Les institutions médico-sociales accueillent souvent des personnes âgées ou des personnes atteintes de maladies chroniques. Il existe donc un risque de problèmes de santé, tels que les chutes, les infections nosocomiales, les accidents vasculaires cérébraux, etc.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Sécurité des résidents',
                'description' => 'Les résidents des institutions médico-sociales peuvent être vulnérables aux agressions, aux vols, aux abus, etc.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Gestion des médicaments',
                'description' => 'Les institutions médico-sociales sont responsables de la gestion des médicaments pour leurs résidents. Il existe donc un risque d\'erreurs de médication, de mauvaise conservation des médicaments, etc.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Gestion des données personnelles',
                'description' => 'Les institutions médico-sociales traitent souvent des données personnelles sensibles, telles que des informations médicales ou des données financières. Il existe donc un risque de violation de la confidentialité et de la sécurité des données.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Erreurs médicales',
                'description' => 'Les institutions médico-sociales sont confrontées au risque d\'erreurs médicales, telles que la mauvaise administration de médicaments, les diagnostics erronés ou les erreurs chirurgicales. Ces erreurs peuvent avoir des conséquences graves pour les résidents et entraîner des poursuites judiciaires.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Cybersécurité',
                'description' => 'Les institutions médico-sociales manipulent et stockent des données sensibles, telles que les dossiers médicaux des résidents. Cela les expose au risque de cyberattaques, de vol de données et de violation de la confidentialité.',
                'category' => 'Dangers liés à la prise en charge des patients',
                'organization_types' => ['Institution médico-sociale']
            ],
            [
                'name' => 'Pénuries de matières premières',
                'description' => 'Des facteurs tels que les catastrophes naturelles, les conflits géopolitiques ou les problèmes logistiques peuvent entraîner des pénuries de matières premières essentielles à la production.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Interruptions de la chaîne d\'approvisionnement',
                'description' => 'Des événements tels que les grèves, les conflits sociaux, les problèmes de transport ou les problèmes de qualité peuvent entraîner des interruptions dans la chaîne d\'approvisionnement, ce qui peut affecter la disponibilité des produits ou services.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Instabilité économique',
                'description' => 'Les fluctuations économiques, les crises financières ou les changements de politique peuvent avoir un impact sur les coûts des matières premières, les taux de change ou les réglementations commerciales, ce qui peut rendre l\'approvisionnement plus difficile ou plus coûteux.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Attaques informatiques',
                'description' => 'Les attaques informatiques ciblant les systèmes de gestion des stocks, les réseaux de communication ou les plateformes d\'approvisionnement peuvent perturber les opérations d\'approvisionnement et compromettre la sécurité des données.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ],
            [
                'name' => 'Problèmes de qualité',
                'description' => 'Des problèmes de qualité des matières premières ou des produits finis peuvent entraîner des rappels, des pertes financières et une détérioration de la réputation de l\'entreprise.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Entreprise', 'Administration publique', 'Institution médico-sociale']
            ], [
                'name' => 'Défaillance des infrastructures critiques',
                'description' => 'Les infrastructures critiques telles que l\'électricité, l\'eau, les télécommunications et les réseaux informatiques peuvent subir des pannes, des cyberattaques ou des catastrophes naturelles, ce qui peut entraîner des interruptions de service et perturber la prise en charge des patients.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Vétusté des infrastructures',
                'description' => 'Les infrastructures vieillissantes peuvent présenter des risques de défaillance, notamment en cas de défaut de maintenance ou de manque d\'investissement dans leur modernisation. Cela peut entraîner des interruptions de service, des problèmes de sécurité et une augmentation des coûts d\'exploitation.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Catastrophes naturelles',
                'description' => 'Les tremblements de terre, les inondations, les tempêtes et autres catastrophes naturelles peuvent endommager les infrastructures, perturber les opérations commerciales et causer des pertes financières importantes.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Incendies ou explosions',
                'description' => 'Les incendies ou les explosions peuvent causer des dommages humains et matériels importants, mettre en danger la sécurité des employés et des patients et entraîner des pertes financières considérables.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Entreprise']
            ],
            [
                'name' => 'Cyberattaques',
                'description' => 'Les infrastructures informatiques et les systèmes de contrôle peuvent être la cible de cyberattaques, ce qui peut entraîner des interruptions de service, des vols de données sensibles et des dommages à la réputation de l\'institution.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Pénuries de ressources',
                'description' => 'Les infrastructures peuvent être confrontées à des pénuries de ressources telles que l\'énergie, l\'eau ou les matières premières, ce qui peut entraîner des problèmes d\'approvisionnement, des augmentations des coûts et des perturbations dans la prise en charge.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Institution médico-sociale']
            ], [
                'name' => 'Émeutes et violences sociales',
                'description' => 'Les émeutes et les violences sociales créent un climat d\'instabilité sociale. Cela peut entraîner une méfiance généralisée, une polarisation de la société et une détérioration des relations intercommunautaires. L\'instabilité sociale peut également compromettre le fonctionnement des institutions et des services publics.',
                'category' => 'Dangers sécuritaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Problèmes de qualité',
                'description' => 'Des problèmes de qualité des matières premières ou des produits finis peuvent entraîner des rappels, des pertes financières et une détérioration de la réputation de l\'institution.',
                'category' => 'Dangers d\'approvisionnement',
                'organization_types' => ['Institution médico-sociale', 'Administration publique']
            ],
            [
                'name' => 'Changements réglementaires',
                'description' => 'Les administrations doivent faire face aux risques liés aux évolutions des réglementations dans leur secteur d\'activité. Cela peut inclure de nouvelles obligations légales, des exigences en matière de conformité ou des sanctions en cas de non-respect des règles. Les administrations doivent être conscientes de ces changements et s\'adapter en conséquence.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Protection des administrés',
                'description' => 'Les administrations doivent respecter les lois et réglementations visant à protéger les droits des administrés.',
                'category' => 'Dangers institutionnels et réglementaires',
                'organization_types' => ['Administration publique']
            ],
            [
                'name' => 'Pénuries de ressources',
                'description' => 'Les infrastructures peuvent être confrontées à des pénuries de ressources telles que l\'énergie, l\'eau ou les matières premières, ce qui peut entraîner des problèmes d\'approvisionnement, des augmentations des coûts et des perturbations des opérations.',
                'category' => 'Dangers infrastructurels',
                'organization_types' => ['Entreprise', 'Administration publique']
            ], [
                'name' => 'Instabilité politique',
                'description' => 'Les changements de gouvernement, les crises politiques, les conflits sociaux ou les révolutions peuvent entraîner une instabilité politique qui affecte l\'environnement des affaires et la stabilité économique.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Réglementations changeantes',
                'description' => 'Les modifications fréquentes des réglementations et des lois peuvent avoir un impact sur les opérations commerciales, les coûts de conformité et la planification à long terme.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Risques géopolitiques',
                'description' => 'Les conflits entre pays, les sanctions économiques, les tensions diplomatiques ou les risques liés aux frontières peuvent perturber les activités commerciales internationales et les relations avec les partenaires commerciaux.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Risques de corruption',
                'description' => 'La corruption politique peut affecter les relations commerciales, l\'équité des marchés et l\'image de l\'entreprise, en particulier dans les pays où la corruption est répandue.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise', 'Administration publique']
            ],
            [
                'name' => 'Risques de nationalisation',
                'description' => 'Dans certains pays, il existe un risque de nationalisation des entreprises étrangères, ce qui peut entraîner la perte de biens, de contrats et de revenus.',
                'category' => 'Dangers politiques',
                'organization_types' => ['Entreprise']
            ],
            [
                'name' => 'Rumeurs sur les réseaux sociaux',
                'description' => 'Les rumeurs peuvent se propager rapidement sur les réseaux sociaux et nuire à la réputation d\'une institution. Une fausse information peut causer des dommages considérables, il est donc important de surveiller les médias sociaux et de réagir rapidement pour clarifier les malentendus.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Bashing en ligne',
                'description' => 'L\'institution peut être la cible de critiques et de commentaires négatifs en ligne, que ce soit sur les réseaux sociaux, les sites de notation ou les forums. Ces attaques peuvent nuire à l\'image de l\'institution et à sa réputation. Il est important de gérer activement la présence en ligne de l\'institution et de répondre de manière appropriée aux commentaires négatifs.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Scandales ou comportements répréhensibles',
                'description' => 'Les scandales impliquant des dirigeants ou des employés de l\'institution peuvent entacher l\'image de l\'institution. Des comportements répréhensibles tels que la fraude, la corruption ou la discrimination peuvent causer des dommages considérables à la réputation de l\'institution. Il est important de mettre en place des politiques et des procédures strictes pour prévenir de tels comportements et de réagir rapidement en cas de problème.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Violations de la confidentialité des données',
                'description' => 'Les violations de la confidentialité des données peuvent entraîner une perte de confiance de la part des clients et du public envers l\'institution. Il est essentiel de mettre en place des mesures de sécurité robustes pour protéger les données des clients et de communiquer de manière transparente en cas de violation de données.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],
            [
                'name' => 'Mauvaise gestion des crises',
                'description' => 'Une mauvaise gestion d\'une crise peut nuire à l\'image de l\'institution. Il est important d\'avoir des plans de gestion de crise solides en place, de former le personnel à la gestion de crise et de communiquer de manière efficace et transparente pendant les périodes de crise.',
                'category' => 'Dangers d\'image',
                'organization_types' => ['Institution médico-sociale', 'Administration publique', 'Entreprise']
            ],

            [
                "name" => "Changement climatique",
                "description" => "Le changement climatique, avec ses effets tels que l'augmentation des températures, la montée des eaux et les phénomènes météorologiques extrêmes plus fréquents, peut également représenter un danger pour les entreprises. Il peut entraîner des perturbations dans les opérations, des dommages aux infrastructures et des risques accrus pour la santé et la sécurité des employés.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Entreprise", "Administration publique"]
            ],
            [
                "name" => "Risques géologiques",
                "description" => "Les risques géologiques tels que les glissements de terrain, les affaissements de terrain ou les éruptions volcaniques peuvent également représenter des dangers pour les entreprises. Ils peuvent endommager les infrastructures, perturber les opérations et mettre en danger la sécurité des employés.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Entreprise", "Administration publique"]
            ],
            [
                "name" => "Risques liés aux ressources naturelles",
                "description" => "Les entreprises qui dépendent de ressources naturelles telles que l'eau, les minéraux, les combustibles fossiles, etc., peuvent être confrontées à des risques d'épuisement des ressources, de pénuries, de fluctuation des prix, etc.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Entreprise", "Administration publique"]
            ],
            [
                "name" => "Dégradation de l'écosystème",
                "description" => "Les activités humaines peuvent entraîner une dégradation de l'écosystème, notamment la destruction des habitats naturels, la déforestation, la surexploitation des ressources, la disparition des espèces, etc. Cela peut avoir des conséquences sur la biodiversité et la durabilité des entreprises.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Entreprise", "Administration publique"]
            ],
            [
                "name" => "Pollution de l'environnement",
                "description" => "Les activités de l'entreprise ou celles de tiers peuvent entraîner une pollution de l'environnement, notamment la pollution de l'air, de l'eau et du sol. Cela peut avoir des conséquences néfastes sur les écosystèmes et la biodiversité et un impact sur la santé et la sécurité des employés, ainsi que sur la réputation de l'entreprise. Elle peut également entraîner des poursuites légales et des amendes.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Entreprise", "Administration publique"]
            ],
            [
                "name" => "Catastrophes naturelles",
                "description" => "Les tremblements de terre, les inondations, les tempêtes, les ouragans, les avalanches, les glissements de terrain, les incendies de forêt, etc., peuvent peuvent causer des dommages importants aux infrastructures, aux équipements et aux personnes. Elles peuvent également entraîner des perturbations majeures dans la prise en charge.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Institution médico-sociale", "Administration publique", "Entreprise"]
            ],
            [
                "name" => "Conditions météorologiques extrêmes",
                "description" => "Les conditions météorologiques extrêmes telles que les tempêtes de neige, les tempêtes de grêle, les vagues de chaleur ou les sécheresses peuvent également causer des dommages importants aux infrastructures et aux biens des institutions. Elles peuvent entraîner des pannes de courant, des interruptions de service et des retards dans la prise en charge.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Institution médico-sociale", "Administration publique", "Entreprise"]
            ],
            [
                "name" => "Épidémies et pandémies",
                "description" => "Les épidémies et pandémies, comme nous l'avons vu récemment avec la pandémie de COVID-19, peuvent avoir un impact majeur sur les institutions. Elles peuvent entraîner des fermetures d'institutions, des perturbations de la chaîne d'approvisionnement, une baisse de la demande et des problèmes de main-d'œuvre.",
                "category" => "Dangers environnementaux",
                "organization_types" => ["Institution médico-sociale", "Administration publique", "Entreprise"]
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
