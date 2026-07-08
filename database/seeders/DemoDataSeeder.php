<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Etudiant;
use App\Models\Ressource;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizReponse;
use App\Models\Actualite;
use App\Models\KnowledgeDocument;
use App\Models\Recommandation;
use App\Models\Question;
use App\Models\Reponse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // ===== ADMIN (if not exists) =====
        $admin = User::firstOrCreate(
            ['email' => 'admin@insam.cm'],
            ['nom' => 'Admin', 'prenom' => 'INSAM', 'password' => Hash::make('admin123'), 'role' => 'admin']
        );

        // ===== ETUDIANTS =====
        $etudiants = [
            ['nom' => 'EPOH MATCHINDA', 'prenom' => 'Oceanne Armelle', 'email' => 'oceanne.epoh@insam.cm', 'matricule' => '22INS001', 'filiere' => 'Genie Logiciel', 'niveau' => 'Licence'],
            ['nom' => 'NGUEMO', 'prenom' => 'Jean-Pierre', 'email' => 'jp.nguemo@insam.cm', 'matricule' => '22INS002', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
            ['nom' => 'TCHAMENI', 'prenom' => 'Arielle', 'email' => 'arielle.tchameni@insam.cm', 'matricule' => '22INS003', 'filiere' => 'Telecommunication', 'niveau' => 'BTS 1'],
            ['nom' => 'FOTSO', 'prenom' => 'Kevin', 'email' => 'kevin.fotso@insam.cm', 'matricule' => '22INS004', 'filiere' => 'Commerce International', 'niveau' => 'BTS 2'],
            ['nom' => 'MBOUDA', 'prenom' => 'Diane', 'email' => 'diane.mbouda@insam.cm', 'matricule' => '22INS005', 'filiere' => 'Marketing-Commerce-Vente', 'niveau' => 'Licence'],
            ['nom' => 'TAGNE', 'prenom' => 'Franck', 'email' => 'franck.tagne@insam.cm', 'matricule' => '22INS006', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'BTS 1'],
            ['nom' => 'KAMGA', 'prenom' => 'Patricia', 'email' => 'patricia.kamga@insam.cm', 'matricule' => '22INS007', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['nom' => 'DJOMOU', 'prenom' => 'Samuel', 'email' => 'samuel.djomou@insam.cm', 'matricule' => '22INS008', 'filiere' => 'Gestion des systemes d\'information', 'niveau' => 'BTS 2'],
            ['nom' => 'WAMBA', 'prenom' => 'Erica', 'email' => 'erica.wamba@insam.cm', 'matricule' => '22INS009', 'filiere' => 'Banque et finance', 'niveau' => 'Licence'],
            ['nom' => 'NKENGFACK', 'prenom' => 'Boris', 'email' => 'boris.nkengfack@insam.cm', 'matricule' => '22INS010', 'filiere' => 'Genie Logiciel', 'niveau' => 'Licence'],
            ['nom' => 'SIMO', 'prenom' => 'Carine', 'email' => 'carine.simo@insam.cm', 'matricule' => '22INS011', 'filiere' => 'Infographie et web design', 'niveau' => 'BTS 2'],
            ['nom' => 'KENFACK', 'prenom' => 'David', 'email' => 'david.kenfack@insam.cm', 'matricule' => '22INS012', 'filiere' => 'Telecommunication', 'niveau' => 'BTS 2'],
            ['nom' => 'NGANOU', 'prenom' => 'Laetitia', 'email' => 'laetitia.nganou@insam.cm', 'matricule' => '22INS013', 'filiere' => 'Gestion des ressources humaines', 'niveau' => 'BTS 1'],
            ['nom' => 'TSAFACK', 'prenom' => 'Emmanuel', 'email' => 'emmanuel.tsafack@insam.cm', 'matricule' => '22INS014', 'filiere' => 'Commerce International', 'niveau' => 'Licence'],
            ['nom' => 'DONGMO', 'prenom' => 'Sylvie', 'email' => 'sylvie.dongmo@insam.cm', 'matricule' => '22INS015', 'filiere' => 'Sciences infirmieres', 'niveau' => 'BTS 1'],
            ['nom' => 'NZOUSSA', 'prenom' => 'Rodrigue', 'email' => 'rodrigue.nzoussa@insam.cm', 'matricule' => '23INS016', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['nom' => 'TEBUG', 'prenom' => 'Christelle', 'email' => 'christelle.tebug@insam.cm', 'matricule' => '23INS017', 'filiere' => 'Sage-femme', 'niveau' => 'BTS 2'],
            ['nom' => 'MOUAFO', 'prenom' => 'Yannick', 'email' => 'yannick.mouafo@insam.cm', 'matricule' => '23INS018', 'filiere' => 'Kinesitherapie', 'niveau' => 'BTS 1'],
            ['nom' => 'FOUDJEU', 'prenom' => 'Marlene', 'email' => 'marlene.foudjeu@insam.cm', 'matricule' => '23INS019', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'BTS 2'],
            ['nom' => 'MEGNE', 'prenom' => 'Olivier', 'email' => 'olivier.megne@insam.cm', 'matricule' => '23INS020', 'filiere' => 'Marketing-Commerce-Vente', 'niveau' => 'BTS 1'],
            ['nom' => 'TALLA', 'prenom' => 'Grace', 'email' => 'grace.talla@insam.cm', 'matricule' => '23INS021', 'filiere' => 'Genie Logiciel', 'niveau' => 'Master 1'],
            ['nom' => 'KAPCHE', 'prenom' => 'Junior', 'email' => 'junior.kapche@insam.cm', 'matricule' => '23INS022', 'filiere' => 'Gestion des systemes d\'information', 'niveau' => 'Licence'],
            ['nom' => 'FEUDJIO', 'prenom' => 'Ange', 'email' => 'ange.feudjio@insam.cm', 'matricule' => '23INS023', 'filiere' => 'Banque et finance', 'niveau' => 'BTS 2'],
            ['nom' => 'NKWENTI', 'prenom' => 'Raissa', 'email' => 'raissa.nkwenti@insam.cm', 'matricule' => '23INS024', 'filiere' => 'Commerce International', 'niveau' => 'BTS 1'],
            ['nom' => 'TIENTCHEU', 'prenom' => 'Alex', 'email' => 'alex.tientcheu@insam.cm', 'matricule' => '23INS025', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
        ];

        $userIds = [];
        foreach ($etudiants as $e) {
            $user = User::firstOrCreate(
                ['email' => $e['email']],
                ['nom' => $e['nom'], 'prenom' => $e['prenom'], 'password' => Hash::make('etudiant123'), 'role' => 'etudiant']
            );
            Etudiant::firstOrCreate(
                ['user_id' => $user->id],
                ['matricule' => $e['matricule'], 'filiere' => $e['filiere'], 'niveau' => $e['niveau']]
            );
            $userIds[] = $user->id;
        }

        // ===== RESSOURCES =====
        $ressources = [
            // Genie Logiciel
            ['titre' => 'Introduction a la programmation en Python', 'description' => 'Ce cours couvre les bases de la programmation : variables, boucles, fonctions, et structures de donnees en Python.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['titre' => 'Algorithmique et structures de donnees', 'description' => 'Les algorithmes fondamentaux : tri, recherche, listes, piles, files, arbres et graphes.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['titre' => 'Programmation orientee objet en Java', 'description' => 'Concepts de la POO : classes, heritage, polymorphisme, interfaces, encapsulation.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
            ['titre' => 'Bases de donnees relationnelles - SQL', 'description' => 'Conception de bases de donnees, modele relationnel, langage SQL, normalisation.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
            ['titre' => 'Developpement Web - HTML/CSS/JavaScript', 'description' => 'Fondamentaux du developpement web front-end : HTML5, CSS3, JavaScript ES6+.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['titre' => 'Framework Laravel - Developpement Backend', 'description' => 'Developpement d\'applications web avec le framework PHP Laravel : MVC, Eloquent, Blade, API REST.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'Licence'],
            ['titre' => 'Genie Logiciel et methodologies Agile', 'description' => 'Cycle de vie du logiciel, methodes agiles (Scrum, Kanban), UML, gestion de projet IT.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'Licence'],
            ['titre' => 'Reseaux informatiques et protocoles', 'description' => 'Modele OSI, TCP/IP, adressage IP, routage, commutation, securite reseau.', 'type' => 'cours', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
            ['titre' => 'Epreuve Algorithmique - Session 2025', 'description' => 'Examen de fin de semestre en algorithmique avec corriges detailles.', 'type' => 'examen', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['titre' => 'Epreuve POO Java - Session 2025', 'description' => 'Examen de programmation orientee objet Java avec exercices pratiques.', 'type' => 'examen', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
            ['titre' => 'TD Algorithmes de tri', 'description' => 'Travaux diriges sur les algorithmes de tri : selection, insertion, bulle, fusion, rapide.', 'type' => 'td', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 1'],
            ['titre' => 'TD Requetes SQL avancees', 'description' => 'Exercices pratiques sur les jointures, sous-requetes, fonctions d\'agregation, vues.', 'type' => 'td', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],
            ['titre' => 'TP Creation d\'une API REST avec Laravel', 'description' => 'Travaux pratiques : creer une API REST complete avec authentification, CRUD, et validation.', 'type' => 'tp', 'filiere' => 'Genie Logiciel', 'niveau' => 'Licence'],
            ['titre' => 'Fiche de revision - Bases de donnees', 'description' => 'Resume des concepts cles : normalisation, MCD, MLD, SQL, transactions, index.', 'type' => 'fiche_revision', 'filiere' => 'Genie Logiciel', 'niveau' => 'BTS 2'],

            // Telecommunication
            ['titre' => 'Transmission de donnees numeriques', 'description' => 'Principes de la transmission numerique : modulation, codage, multiplexage, bande passante.', 'type' => 'cours', 'filiere' => 'Telecommunication', 'niveau' => 'BTS 1'],
            ['titre' => 'Systemes de telecommunication mobile', 'description' => 'Architecture des reseaux mobiles : 2G, 3G, 4G, 5G, antennes, couverture reseau.', 'type' => 'cours', 'filiere' => 'Telecommunication', 'niveau' => 'BTS 2'],
            ['titre' => 'Electronique analogique et numerique', 'description' => 'Composants electroniques, circuits logiques, amplificateurs, filtres, convertisseurs.', 'type' => 'cours', 'filiere' => 'Telecommunication', 'niveau' => 'BTS 1'],
            ['titre' => 'Epreuve Transmission de donnees - 2025', 'description' => 'Examen sur la transmission numerique avec exercices de calcul et schemas.', 'type' => 'examen', 'filiere' => 'Telecommunication', 'niveau' => 'BTS 1'],

            // Commerce International
            ['titre' => 'Techniques du commerce international', 'description' => 'Incoterms, documents commerciaux, operations de dedouanement, logistique internationale.', 'type' => 'cours', 'filiere' => 'Commerce International', 'niveau' => 'BTS 1'],
            ['titre' => 'Droit des affaires internationales', 'description' => 'Contrats internationaux, reglement des litiges, droit douanier, OMC.', 'type' => 'cours', 'filiere' => 'Commerce International', 'niveau' => 'BTS 2'],
            ['titre' => 'Economie internationale', 'description' => 'Theories du commerce international, balance des paiements, taux de change, mondialisation.', 'type' => 'cours', 'filiere' => 'Commerce International', 'niveau' => 'BTS 2'],
            ['titre' => 'Epreuve Commerce International - 2025', 'description' => 'Examen complet avec etude de cas sur une operation d\'importation.', 'type' => 'examen', 'filiere' => 'Commerce International', 'niveau' => 'BTS 2'],
            ['titre' => 'Fiche revision - Incoterms 2020', 'description' => 'Tableau recapitulatif des 11 Incoterms : EXW, FCA, FAS, FOB, CFR, CIF, CPT, CIP, DAP, DPU, DDP.', 'type' => 'fiche_revision', 'filiere' => 'Commerce International', 'niveau' => 'BTS 1'],

            // Marketing-Commerce-Vente
            ['titre' => 'Fondamentaux du marketing', 'description' => 'Le mix marketing (4P), segmentation, ciblage, positionnement, etude de marche.', 'type' => 'cours', 'filiere' => 'Marketing-Commerce-Vente', 'niveau' => 'BTS 1'],
            ['titre' => 'Marketing digital et reseaux sociaux', 'description' => 'Strategie digitale, SEO/SEA, community management, e-mailing, analytics.', 'type' => 'cours', 'filiere' => 'Marketing-Commerce-Vente', 'niveau' => 'BTS 2'],
            ['titre' => 'Techniques de vente et negociation', 'description' => 'Processus de vente, ecoute active, traitement des objections, closing, fidelisation.', 'type' => 'cours', 'filiere' => 'Marketing-Commerce-Vente', 'niveau' => 'BTS 1'],
            ['titre' => 'TD Etude de marche - Cas pratique', 'description' => 'Realiser une etude de marche complete pour le lancement d\'un produit au Cameroun.', 'type' => 'td', 'filiere' => 'Marketing-Commerce-Vente', 'niveau' => 'BTS 2'],

            // Comptabilite et gestion
            ['titre' => 'Comptabilite generale - Principes', 'description' => 'Plan comptable OHADA, ecritures comptables, journal, grand livre, balance, bilan.', 'type' => 'cours', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'BTS 1'],
            ['titre' => 'Comptabilite analytique', 'description' => 'Cout complet, cout variable, seuil de rentabilite, centres d\'analyse, ABC.', 'type' => 'cours', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'BTS 2'],
            ['titre' => 'Fiscalite des entreprises au Cameroun', 'description' => 'IS, TVA, patente, impots sur le revenu, declarations fiscales, regime fiscal.', 'type' => 'cours', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'Licence'],
            ['titre' => 'Epreuve Comptabilite generale - 2025', 'description' => 'Examen avec exercices d\'ecritures comptables, etats financiers, amortissements.', 'type' => 'examen', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'BTS 1'],
            ['titre' => 'TD Ecritures comptables OHADA', 'description' => 'Exercices pratiques sur les ecritures de vente, achat, paie, amortissement, provisions.', 'type' => 'td', 'filiere' => 'Comptabilite et gestion', 'niveau' => 'BTS 1'],

            // Banque et finance
            ['titre' => 'Economie monetaire et bancaire', 'description' => 'Systeme bancaire camerounais, BEAC, COBAC, politique monetaire, marche des capitaux.', 'type' => 'cours', 'filiere' => 'Banque et finance', 'niveau' => 'BTS 2'],
            ['titre' => 'Gestion de portefeuille', 'description' => 'Analyse financiere, evaluation d\'actifs, gestion du risque, diversification.', 'type' => 'cours', 'filiere' => 'Banque et finance', 'niveau' => 'Licence'],

            // GRH
            ['titre' => 'Gestion des ressources humaines', 'description' => 'Recrutement, formation, evaluation, remuneration, gestion des carrieres, GPEC.', 'type' => 'cours', 'filiere' => 'Gestion des ressources humaines', 'niveau' => 'BTS 1'],
            ['titre' => 'Droit du travail camerounais', 'description' => 'Code du travail, contrat de travail, licenciement, securite sociale, CNPS.', 'type' => 'cours', 'filiere' => 'Gestion des ressources humaines', 'niveau' => 'BTS 2'],

            // Transversal
            ['titre' => 'Anglais des affaires - Business English', 'description' => 'Vocabulaire professionnel, correspondance commerciale, presentations, negociation en anglais.', 'type' => 'cours', 'filiere' => '', 'niveau' => 'BTS 1'],
            ['titre' => 'Mathematiques financieres', 'description' => 'Interets simples et composes, annuites, emprunts, amortissements financiers.', 'type' => 'cours', 'filiere' => '', 'niveau' => 'BTS 1'],
            ['titre' => 'Methodologie de redaction du rapport de stage', 'description' => 'Structure du rapport, introduction, problematique, bibliographie, soutenance.', 'type' => 'cours', 'filiere' => '', 'niveau' => 'BTS 2'],
        ];

        foreach ($ressources as $r) {
            Ressource::firstOrCreate(
                ['titre' => $r['titre']],
                array_merge($r, ['user_id' => $admin->id, 'telechargements' => rand(5, 120)])
            );
        }

        // ===== QUIZZES =====
        $quizzes = [
            [
                'titre' => 'Les bases de Python',
                'matiere' => 'Programmation',
                'chapitre' => 'Introduction',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'BTS 1',
                'questions' => [
                    ['question' => 'Quel mot-cle permet de definir une fonction en Python ?', 'options' => ['function', 'def', 'func', 'define'], 'bonne_reponse' => 'def'],
                    ['question' => 'Quel est le resultat de 10 // 3 en Python ?', 'options' => ['3.33', '3', '4', '3.0'], 'bonne_reponse' => '3'],
                    ['question' => 'Comment declarer une liste vide en Python ?', 'options' => ['list = {}', 'list = []', 'list = ()', 'list = ""'], 'bonne_reponse' => 'list = []'],
                    ['question' => 'Quelle methode ajoute un element a la fin d\'une liste ?', 'options' => ['add()', 'insert()', 'append()', 'push()'], 'bonne_reponse' => 'append()'],
                    ['question' => 'Quel type de boucle est utilise pour iterer sur une sequence ?', 'options' => ['while', 'for', 'do-while', 'repeat'], 'bonne_reponse' => 'for'],
                ],
            ],
            [
                'titre' => 'SQL et bases de donnees',
                'matiere' => 'Bases de donnees',
                'chapitre' => 'Requetes SQL',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'BTS 2',
                'questions' => [
                    ['question' => 'Quelle commande SQL permet de recuperer des donnees ?', 'options' => ['GET', 'FETCH', 'SELECT', 'RETRIEVE'], 'bonne_reponse' => 'SELECT'],
                    ['question' => 'Quel mot-cle SQL permet de filtrer les resultats ?', 'options' => ['FILTER', 'WHERE', 'HAVING', 'CONDITION'], 'bonne_reponse' => 'WHERE'],
                    ['question' => 'Comment supprimer toutes les lignes d\'une table sans supprimer la table ?', 'options' => ['DROP TABLE', 'DELETE FROM', 'REMOVE ALL', 'CLEAR TABLE'], 'bonne_reponse' => 'DELETE FROM'],
                    ['question' => 'Quelle jointure retourne toutes les lignes des deux tables ?', 'options' => ['INNER JOIN', 'LEFT JOIN', 'FULL OUTER JOIN', 'CROSS JOIN'], 'bonne_reponse' => 'FULL OUTER JOIN'],
                    ['question' => 'Quelle fonction SQL compte le nombre de lignes ?', 'options' => ['SUM()', 'COUNT()', 'TOTAL()', 'NUM()'], 'bonne_reponse' => 'COUNT()'],
                    ['question' => 'Quel est le role de la cle primaire ?', 'options' => ['Chiffrer les donnees', 'Identifier de maniere unique chaque enregistrement', 'Relier deux tables', 'Trier les donnees'], 'bonne_reponse' => 'Identifier de maniere unique chaque enregistrement'],
                ],
            ],
            [
                'titre' => 'Programmation Orientee Objet',
                'matiere' => 'POO Java',
                'chapitre' => 'Concepts fondamentaux',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'BTS 2',
                'questions' => [
                    ['question' => 'Quel est le principe qui consiste a cacher les details internes d\'un objet ?', 'options' => ['Heritage', 'Polymorphisme', 'Encapsulation', 'Abstraction'], 'bonne_reponse' => 'Encapsulation'],
                    ['question' => 'Quel mot-cle Java permet d\'heriter d\'une classe ?', 'options' => ['inherits', 'extends', 'implements', 'derives'], 'bonne_reponse' => 'extends'],
                    ['question' => 'Qu\'est-ce qu\'un constructeur en Java ?', 'options' => ['Une methode qui detruit un objet', 'Une methode speciale appelee lors de la creation d\'un objet', 'Un attribut de classe', 'Un type de variable'], 'bonne_reponse' => 'Une methode speciale appelee lors de la creation d\'un objet'],
                    ['question' => 'Quel modificateur d\'acces rend un membre accessible uniquement dans sa classe ?', 'options' => ['public', 'protected', 'private', 'default'], 'bonne_reponse' => 'private'],
                    ['question' => 'Qu\'est-ce que le polymorphisme ?', 'options' => ['Creer plusieurs classes', 'Une meme methode peut avoir des comportements differents', 'Cacher les attributs', 'Heriger de plusieurs classes'], 'bonne_reponse' => 'Une meme methode peut avoir des comportements differents'],
                ],
            ],
            [
                'titre' => 'Fondamentaux du Marketing',
                'matiere' => 'Marketing',
                'chapitre' => 'Mix Marketing',
                'filiere' => 'Marketing-Commerce-Vente',
                'niveau' => 'BTS 1',
                'questions' => [
                    ['question' => 'Quels sont les 4P du mix marketing ?', 'options' => ['Produit, Prix, Place, Promotion', 'Produit, Prix, Personne, Publicite', 'Plan, Prix, Produit, Process', 'Produit, Profit, Place, Publicite'], 'bonne_reponse' => 'Produit, Prix, Place, Promotion'],
                    ['question' => 'Qu\'est-ce que la segmentation de marche ?', 'options' => ['Fixer les prix', 'Diviser le marche en groupes homogenes', 'Creer un produit', 'Faire de la publicite'], 'bonne_reponse' => 'Diviser le marche en groupes homogenes'],
                    ['question' => 'Quelle est la premiere etape d\'une etude de marche ?', 'options' => ['L\'analyse des donnees', 'La redaction du rapport', 'La definition du probleme', 'La collecte des donnees'], 'bonne_reponse' => 'La definition du probleme'],
                    ['question' => 'Qu\'est-ce que le positionnement ?', 'options' => ['Le lieu de vente', 'La place qu\'occupe le produit dans l\'esprit du consommateur', 'Le prix du produit', 'La promotion du produit'], 'bonne_reponse' => 'La place qu\'occupe le produit dans l\'esprit du consommateur'],
                    ['question' => 'Le cycle de vie d\'un produit comprend combien de phases ?', 'options' => ['2', '3', '4', '5'], 'bonne_reponse' => '4'],
                ],
            ],
            [
                'titre' => 'Comptabilite generale OHADA',
                'matiere' => 'Comptabilite',
                'chapitre' => 'Ecritures comptables',
                'filiere' => 'Comptabilite et gestion',
                'niveau' => 'BTS 1',
                'questions' => [
                    ['question' => 'Quel est le principe de la partie double ?', 'options' => ['Chaque operation s\'enregistre en deux temps', 'Tout debit implique un credit de meme montant', 'Il faut deux comptables', 'Les comptes sont doubles'], 'bonne_reponse' => 'Tout debit implique un credit de meme montant'],
                    ['question' => 'Dans le plan OHADA, la classe 1 correspond a :', 'options' => ['Charges', 'Comptes de capitaux', 'Comptes de tresorerie', 'Produits'], 'bonne_reponse' => 'Comptes de capitaux'],
                    ['question' => 'Qu\'est-ce que le bilan ?', 'options' => ['Le resultat de l\'exercice', 'Un etat financier montrant le patrimoine', 'La liste des charges', 'Le livre journal'], 'bonne_reponse' => 'Un etat financier montrant le patrimoine'],
                    ['question' => 'L\'amortissement represente :', 'options' => ['Un benefice', 'La perte de valeur d\'une immobilisation', 'Un achat', 'Une vente'], 'bonne_reponse' => 'La perte de valeur d\'une immobilisation'],
                    ['question' => 'Le compte de resultat presente :', 'options' => ['L\'actif et le passif', 'Les charges et les produits', 'Les dettes', 'Les immobilisations'], 'bonne_reponse' => 'Les charges et les produits'],
                ],
            ],
            [
                'titre' => 'Commerce International - Incoterms',
                'matiere' => 'Commerce International',
                'chapitre' => 'Incoterms 2020',
                'filiere' => 'Commerce International',
                'niveau' => 'BTS 1',
                'questions' => [
                    ['question' => 'Que signifie l\'Incoterm FOB ?', 'options' => ['Free On Board', 'Freight On Board', 'Free Over Border', 'First On Board'], 'bonne_reponse' => 'Free On Board'],
                    ['question' => 'Combien d\'Incoterms existent dans la version 2020 ?', 'options' => ['8', '11', '13', '15'], 'bonne_reponse' => '11'],
                    ['question' => 'Quel Incoterm impose le maximum d\'obligations au vendeur ?', 'options' => ['EXW', 'FOB', 'CIF', 'DDP'], 'bonne_reponse' => 'DDP'],
                    ['question' => 'L\'Incoterm EXW signifie :', 'options' => ['Le vendeur livre a domicile', 'L\'acheteur recupere au depart usine', 'Le transport est partage', 'Assurance obligatoire'], 'bonne_reponse' => 'L\'acheteur recupere au depart usine'],
                ],
            ],
            [
                'titre' => 'Reseaux et Telecommunications',
                'matiere' => 'Reseaux',
                'chapitre' => 'Modele OSI et TCP/IP',
                'filiere' => 'Telecommunication',
                'niveau' => 'BTS 2',
                'questions' => [
                    ['question' => 'Combien de couches possede le modele OSI ?', 'options' => ['4', '5', '6', '7'], 'bonne_reponse' => '7'],
                    ['question' => 'Quel protocole fonctionne au niveau de la couche Transport ?', 'options' => ['HTTP', 'IP', 'TCP', 'Ethernet'], 'bonne_reponse' => 'TCP'],
                    ['question' => 'Quelle est la couche responsable du routage dans le modele OSI ?', 'options' => ['Couche 1', 'Couche 2', 'Couche 3', 'Couche 4'], 'bonne_reponse' => 'Couche 3'],
                    ['question' => 'Quel equipement reseau fonctionne au niveau de la couche 2 ?', 'options' => ['Routeur', 'Switch', 'Hub', 'Modem'], 'bonne_reponse' => 'Switch'],
                    ['question' => 'Une adresse IPv4 est codee sur combien de bits ?', 'options' => ['8', '16', '32', '64'], 'bonne_reponse' => '32'],
                ],
            ],
            [
                'titre' => 'Developpement Web',
                'matiere' => 'Web',
                'chapitre' => 'HTML/CSS/JS',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'BTS 1',
                'questions' => [
                    ['question' => 'Quelle balise HTML definit un lien hypertexte ?', 'options' => ['<link>', '<a>', '<href>', '<url>'], 'bonne_reponse' => '<a>'],
                    ['question' => 'Quelle propriete CSS change la couleur du texte ?', 'options' => ['text-color', 'font-color', 'color', 'foreground'], 'bonne_reponse' => 'color'],
                    ['question' => 'Que signifie CSS ?', 'options' => ['Creative Style Sheets', 'Cascading Style Sheets', 'Computer Style Sheets', 'Colorful Style Sheets'], 'bonne_reponse' => 'Cascading Style Sheets'],
                    ['question' => 'Quelle methode JavaScript affiche une boite de dialogue ?', 'options' => ['msg()', 'alert()', 'dialog()', 'popup()'], 'bonne_reponse' => 'alert()'],
                    ['question' => 'Quel symbole est utilise pour les commentaires en JavaScript ?', 'options' => ['<!-- -->', '/* */', '# #', '% %'], 'bonne_reponse' => '/* */'],
                ],
            ],
        ];

        foreach ($quizzes as $qData) {
            $quiz = Quiz::firstOrCreate(
                ['titre' => $qData['titre']],
                ['matiere' => $qData['matiere'], 'chapitre' => $qData['chapitre'], 'filiere' => $qData['filiere'], 'niveau' => $qData['niveau']]
            );
            foreach ($qData['questions'] as $q) {
                QuizQuestion::firstOrCreate(
                    ['quiz_id' => $quiz->id, 'question' => $q['question']],
                    ['options' => $q['options'], 'bonne_reponse' => $q['bonne_reponse']]
                );
            }
        }

        // ===== QUIZ RESPONSES (simulated student attempts) =====
        $allQuizzes = Quiz::all();
        foreach ($allQuizzes as $quiz) {
            $totalQ = $quiz->questions()->count();
            $attempts = array_slice($userIds, 0, rand(5, 12));
            foreach ($attempts as $uid) {
                QuizReponse::firstOrCreate(
                    ['user_id' => $uid, 'quiz_id' => $quiz->id],
                    ['score' => rand(max(1, $totalQ - 3), $totalQ), 'total' => $totalQ, 'reponses' => []]
                );
            }
        }

        // ===== ACTUALITES =====
        $actualites = [
            ['titre' => 'Rentree academique 2025-2026', 'description' => "L'IUES/INSAM a le plaisir d'annoncer la rentree academique pour l'annee 2025-2026. Les cours debutent le lundi 16 septembre 2025.\n\nLes etudiants sont invites a finaliser leur inscription et a retirer leur carte d'etudiant au bureau de la scolarite.\n\nHoraires d'ouverture de la scolarite : Lundi - Vendredi, 8h - 16h.", 'date_publication' => '2025-09-01'],
            ['titre' => 'Resultats des examens du premier semestre', 'description' => "Les resultats des examens du premier semestre 2025-2026 sont disponibles. Les etudiants peuvent consulter leurs notes via la plateforme en ligne ou au tableau d'affichage.\n\nLes reclamations sont recevables jusqu'au 28 fevrier 2026.", 'date_publication' => '2026-02-15'],
            ['titre' => 'Seminaire sur l\'intelligence artificielle', 'description' => "L'IUES/INSAM organise un seminaire sur le theme \"L'Intelligence Artificielle au service de l'education\" le samedi 15 mars 2026 a l'amphitheatre central.\n\nIntervenants :\n- Dr. KAMDEM Paul (Universite de Dschang)\n- Mme. FOUDA Nicole (Expert IA, Google Africa)\n\nEntree libre pour tous les etudiants.", 'date_publication' => '2026-03-01'],
            ['titre' => 'Lancement de la plateforme d\'accompagnement academique', 'description' => "Nous avons le plaisir de vous presenter notre nouvelle plateforme intelligente d'accompagnement academique !\n\nFonctionnalites disponibles :\n- Assistant IA pour vos questions academiques\n- Ressources de cours et d'examens\n- Quiz interactifs pour tester vos connaissances\n- Recommandations personnalisees\n\nConnectez-vous et explorez !", 'date_publication' => '2026-06-01'],
            ['titre' => 'Periode des stages - Ete 2026', 'description' => "Les stages academiques pour les etudiants de BTS 2 et Licence debutent le 1er juillet 2026.\n\nRappels importants :\n- Deposez votre convention de stage avant le 20 juin\n- Le rapport de stage doit etre depose avant le 15 septembre\n- La soutenance est prevue entre le 20 et 30 septembre\n\nBon stage a tous !", 'date_publication' => '2026-06-15'],
            ['titre' => 'Calendrier des examens - Session de Juin 2026', 'description' => "Le calendrier des examens de la session de juin 2026 est disponible.\n\nDates cles :\n- BTS 1 : du 17 au 21 juin 2026\n- BTS 2 : du 10 au 14 juin 2026\n- Licence : du 24 au 28 juin 2026\n\nConsultez les details sur le tableau d'affichage de votre departement.", 'date_publication' => '2026-05-20'],
            ['titre' => 'Journee portes ouvertes IUES/INSAM', 'description' => "L'IUES/INSAM organise sa journee portes ouvertes le samedi 12 avril 2026.\n\nAu programme :\n- Visite du campus et des laboratoires\n- Presentations des filieres\n- Echanges avec les enseignants et etudiants\n- Inscriptions a tarif preferentiel\n\nInvitez vos amis et famille !", 'date_publication' => '2026-04-01'],
            ['titre' => 'Atelier CV et preparation aux entretiens', 'description' => "Le service orientation et insertion professionnelle de l'IUES/INSAM organise un atelier pratique :\n\n\"Rediger un CV efficace et reussir ses entretiens d'embauche\"\n\nDate : Mercredi 8 mai 2026, 14h - 17h\nLieu : Salle B204\n\nPlaces limitees - Inscrivez-vous aupres de votre delegue.", 'date_publication' => '2026-04-25'],
        ];

        foreach ($actualites as $a) {
            Actualite::firstOrCreate(
                ['titre' => $a['titre']],
                array_merge($a, ['user_id' => $admin->id])
            );
        }

        // ===== BASE DE CONNAISSANCES =====
        $knowledgeDocs = [
            [
                'titre' => 'Introduction a l\'algorithmique',
                'matiere' => 'Algorithmique',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'BTS 1',
                'fichier_nom' => 'cours_algorithmique.pdf',
                'contenu_texte' => "COURS D'ALGORITHMIQUE - IUES/INSAM\n\nChapitre 1 : Introduction\n\nUn algorithme est une suite finie et ordonnee d'instructions permettant de resoudre un probleme. Le mot algorithme vient du mathematicien Al-Khwarizmi.\n\nLes etapes de resolution d'un probleme :\n1. Analyse du probleme\n2. Conception de l'algorithme\n3. Codage dans un langage de programmation\n4. Test et verification\n5. Maintenance\n\nChapitre 2 : Les variables et types de donnees\n\nUne variable est un espace memoire nomme qui contient une valeur. Types fondamentaux :\n- Entier : nombres entiers (1, 42, -7)\n- Reel : nombres decimaux (3.14, -2.5)\n- Caractere : un seul caractere ('A', '9')\n- Chaine : suite de caracteres (\"Bonjour\")\n- Booleen : VRAI ou FAUX\n\nDeclaration : Variable nom_variable : Type\nAffectation : nom_variable <- valeur\n\nChapitre 3 : Les structures de controle\n\nStructure conditionnelle :\nSI condition ALORS\n    instructions\nSINON\n    instructions\nFIN SI\n\nBoucle POUR :\nPOUR i DE debut A fin FAIRE\n    instructions\nFIN POUR\n\nBoucle TANT QUE :\nTANT QUE condition FAIRE\n    instructions\nFIN TANT QUE\n\nChapitre 4 : Les tableaux\n\nUn tableau est une structure de donnees qui stocke une collection d'elements de meme type. Declaration : Tableau T[n] : Type\n\nOperations courantes :\n- Parcours : visiter tous les elements\n- Recherche : trouver un element\n- Tri : ordonner les elements\n- Insertion et suppression\n\nChapitre 5 : Les fonctions et procedures\n\nUne fonction est un sous-programme qui retourne une valeur.\nUne procedure est un sous-programme qui ne retourne pas de valeur.\n\nFonction NomFonction(param1: Type, param2: Type) : TypeRetour\n    instructions\n    Retourner valeur\nFin Fonction\n\nAvantages : reutilisabilite, modularite, lisibilite du code.",
            ],
            [
                'titre' => 'Cours de Bases de Donnees Relationnelles',
                'matiere' => 'Bases de donnees',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'BTS 2',
                'fichier_nom' => 'cours_bdd.pdf',
                'contenu_texte' => "BASES DE DONNEES RELATIONNELLES - IUES/INSAM\n\nChapitre 1 : Concepts de base\n\nUne base de donnees est un ensemble organise de donnees structurees. Le SGBD (Systeme de Gestion de Bases de Donnees) est le logiciel qui gere la base. Exemples : MySQL, PostgreSQL, Oracle, SQL Server.\n\nLe modele relationnel organise les donnees en tables (relations) composees de lignes (tuples) et colonnes (attributs).\n\nChapitre 2 : Conception - MCD et MLD\n\nMCD (Modele Conceptuel de Donnees) :\n- Entites : objets du monde reel (Etudiant, Cours)\n- Associations : liens entre entites (s'inscrire)\n- Cardinalites : 1,1 - 0,n - 1,n - 0,1\n\nMLD (Modele Logique de Donnees) :\nTransformation des entites en tables, les associations deviennent des cles etrangeres ou des tables de jonction.\n\nChapitre 3 : Normalisation\n\n1NF : Pas de groupe repetitif, attributs atomiques\n2NF : 1NF + chaque attribut depend de toute la cle\n3NF : 2NF + pas de dependance transitive\nBCNF : Toute dependance fonctionnelle a pour partie gauche une super-cle\n\nChapitre 4 : Langage SQL\n\nDDL (Definition) : CREATE TABLE, ALTER TABLE, DROP TABLE\nDML (Manipulation) : SELECT, INSERT, UPDATE, DELETE\nDCL (Controle) : GRANT, REVOKE\n\nExemples :\nCREATE TABLE etudiants (\n    id INT PRIMARY KEY AUTO_INCREMENT,\n    nom VARCHAR(100),\n    prenom VARCHAR(100),\n    filiere VARCHAR(50)\n);\n\nSELECT nom, prenom FROM etudiants WHERE filiere = 'Genie Logiciel' ORDER BY nom;\n\nSELECT filiere, COUNT(*) as total FROM etudiants GROUP BY filiere HAVING total > 5;\n\nJointures :\nSELECT e.nom, c.intitule FROM etudiants e INNER JOIN inscriptions i ON e.id = i.etudiant_id INNER JOIN cours c ON i.cours_id = c.id;",
            ],
            [
                'titre' => 'Marketing Digital',
                'matiere' => 'Marketing',
                'filiere' => 'Marketing-Commerce-Vente',
                'niveau' => 'BTS 2',
                'fichier_nom' => 'cours_marketing_digital.pdf',
                'contenu_texte' => "MARKETING DIGITAL - IUES/INSAM\n\nChapitre 1 : Introduction au marketing digital\n\nLe marketing digital (ou marketing numerique) est l'ensemble des techniques marketing utilisant les canaux digitaux. Il represente aujourd'hui plus de 50% des investissements publicitaires mondiaux.\n\nCanaux principaux :\n- Site web et SEO\n- Reseaux sociaux (Facebook, Instagram, LinkedIn, TikTok)\n- Email marketing\n- Publicite en ligne (Google Ads, Facebook Ads)\n- Marketing de contenu\n- Marketing d'influence\n\nChapitre 2 : SEO (Search Engine Optimization)\n\nLe SEO est l'ensemble des techniques visant a ameliorer la visibilite d'un site web dans les resultats de recherche naturels.\n\nFacteurs cles :\n- Mots-cles pertinents\n- Contenu de qualite\n- Optimisation technique (vitesse, mobile-friendly)\n- Backlinks de qualite\n- Experience utilisateur (UX)\n\nChapitre 3 : Reseaux sociaux\n\nStrategie de presence sur les reseaux sociaux :\n1. Definir ses objectifs (notoriete, engagement, conversion)\n2. Choisir les bons reseaux\n3. Creer un calendrier editorial\n4. Produire du contenu varie (images, videos, stories)\n5. Analyser les performances (KPIs)\n\nKPIs importants : taux d'engagement, portee, impressions, taux de clic, taux de conversion.\n\nChapitre 4 : Email marketing\n\nBonnes pratiques :\n- Segmenter sa base de contacts\n- Personnaliser les messages\n- Optimiser l'objet du mail (taux d'ouverture)\n- Responsive design\n- Call-to-action clair\n- Respecter le RGPD",
            ],
            [
                'titre' => 'Comptabilite Generale OHADA',
                'matiere' => 'Comptabilite',
                'filiere' => 'Comptabilite et gestion',
                'niveau' => 'BTS 1',
                'fichier_nom' => 'cours_compta_ohada.pdf',
                'contenu_texte' => "COMPTABILITE GENERALE OHADA - IUES/INSAM\n\nChapitre 1 : Le cadre comptable OHADA\n\nL'OHADA (Organisation pour l'Harmonisation en Afrique du Droit des Affaires) a adopte le SYSCOHADA revise en 2017. Ce systeme s'applique dans les 17 pays membres dont le Cameroun.\n\nPrincipes fondamentaux :\n- Principe de prudence\n- Principe de permanence des methodes\n- Principe du cout historique\n- Principe de continuite d'exploitation\n- Principe de specialisation des exercices\n- Principe d'importance significative\n\nChapitre 2 : Le plan comptable OHADA\n\nClasses du plan comptable :\n- Classe 1 : Comptes de capitaux (capital, reserves, emprunts)\n- Classe 2 : Comptes d'immobilisations (terrains, batiments, equipements)\n- Classe 3 : Comptes de stocks (matieres premieres, produits finis)\n- Classe 4 : Comptes de tiers (fournisseurs, clients, Etat)\n- Classe 5 : Comptes de tresorerie (banque, caisse)\n- Classe 6 : Comptes de charges (achats, services, personnel)\n- Classe 7 : Comptes de produits (ventes, prestations)\n- Classe 8 : Comptes speciaux\n\nChapitre 3 : Les ecritures comptables\n\nPrincipe de la partie double : tout debit implique un credit de meme montant.\n\nExemple - Achat de marchandises a credit :\n601 Achats de marchandises     500 000\n    401 Fournisseurs                    500 000\n\nExemple - Vente au comptant :\n521 Banque                     800 000\n    701 Ventes de marchandises           800 000\n\nExemple - Paiement salaires :\n661 Remunerations du personnel  1 200 000\n    421 Personnel                        1 200 000\n\nChapitre 4 : Les etats financiers\n\nLe bilan : etat du patrimoine a une date donnee\n- Actif : ce que l'entreprise possede\n- Passif : ce que l'entreprise doit\n\nLe compte de resultat : recapitulatif des charges et produits\nResultat = Produits - Charges",
            ],
            [
                'titre' => 'Techniques du Commerce International',
                'matiere' => 'Commerce International',
                'filiere' => 'Commerce International',
                'niveau' => 'BTS 1',
                'fichier_nom' => 'cours_commerce_international.pdf',
                'contenu_texte' => "TECHNIQUES DU COMMERCE INTERNATIONAL - IUES/INSAM\n\nChapitre 1 : Les Incoterms 2020\n\nLes Incoterms (International Commercial Terms) sont des regles publiees par la CCI (Chambre de Commerce Internationale) qui definissent les obligations de l'acheteur et du vendeur.\n\n11 Incoterms classes en 4 categories :\n\nGroupe E - Depart :\n- EXW (Ex Works) : depart usine\n\nGroupe F - Transport principal non paye :\n- FCA (Free Carrier) : franco transporteur\n- FAS (Free Alongside Ship) : franco le long du navire\n- FOB (Free On Board) : franco a bord\n\nGroupe C - Transport principal paye :\n- CFR (Cost and Freight) : cout et fret\n- CIF (Cost, Insurance and Freight) : cout, assurance et fret\n- CPT (Carriage Paid To) : port paye jusqu'a\n- CIP (Carriage and Insurance Paid To) : port paye, assurance comprise\n\nGroupe D - Arrivee :\n- DAP (Delivered at Place) : rendu au lieu de destination\n- DPU (Delivered at Place Unloaded) : rendu au lieu de destination decharge\n- DDP (Delivered Duty Paid) : rendu droits acquittes\n\nChapitre 2 : Les documents du commerce international\n\n- Facture commerciale (Commercial Invoice)\n- Liste de colisage (Packing List)\n- Connaissement maritime (Bill of Lading)\n- Lettre de transport aerien (Air Way Bill)\n- Certificat d'origine\n- Certificat d'assurance\n- Declaration en douane (D6, D15 au Cameroun)\n\nChapitre 3 : Les moyens de paiement internationaux\n\n1. Virement bancaire international (SWIFT)\n2. Cheque international\n3. Remise documentaire (D/P, D/A)\n4. Credit documentaire (Lettre de Credit L/C)\n   - Le plus securise pour les deux parties\n   - Irrevocable et confirme = maximum de securite",
            ],
            [
                'titre' => 'Programmation Web avec Laravel',
                'matiere' => 'Developpement Web',
                'filiere' => 'Genie Logiciel',
                'niveau' => 'Licence',
                'fichier_nom' => 'cours_laravel.pdf',
                'contenu_texte' => "DEVELOPPEMENT WEB AVEC LARAVEL - IUES/INSAM\n\nChapitre 1 : Introduction a Laravel\n\nLaravel est un framework PHP open-source suivant le modele MVC (Model-View-Controller). Cree par Taylor Otwell en 2011, c'est le framework PHP le plus populaire.\n\nCaracteristiques :\n- Architecture MVC elegante\n- ORM Eloquent pour les bases de donnees\n- Systeme de migration pour la gestion du schema\n- Blade comme moteur de templates\n- Systeme de routage puissant\n- Authentification integree\n- Artisan CLI pour la productivite\n\nInstallation :\ncomposer create-project laravel/laravel mon-projet\nphp artisan serve\n\nChapitre 2 : Routing et Controllers\n\nRoutes definies dans routes/web.php ou routes/api.php :\nRoute::get('/etudiants', [EtudiantController::class, 'index']);\nRoute::post('/etudiants', [EtudiantController::class, 'store']);\nRoute::put('/etudiants/{id}', [EtudiantController::class, 'update']);\nRoute::delete('/etudiants/{id}', [EtudiantController::class, 'destroy']);\n\nChapitre 3 : Eloquent ORM\n\nChaque table a un Model correspondant :\nclass Etudiant extends Model {\n    protected \$fillable = ['nom', 'prenom', 'matricule', 'filiere'];\n}\n\nOperations CRUD :\n\$etudiants = Etudiant::all();\n\$etudiant = Etudiant::find(1);\n\$etudiant = Etudiant::create(['nom' => 'Dupont', ...]);\n\$etudiant->update(['nom' => 'Martin']);\n\$etudiant->delete();\n\nRelations : hasOne, hasMany, belongsTo, belongsToMany\n\nChapitre 4 : API REST avec Laravel\n\nCreer une API RESTful :\n1. Definir les routes dans api.php\n2. Creer les controllers avec --api\n3. Utiliser les Resources pour formater les reponses JSON\n4. Authentification avec Laravel Sanctum (tokens API)\n5. Validation des donnees avec \$request->validate()",
            ],
            [
                'titre' => 'Gestion des Ressources Humaines',
                'matiere' => 'GRH',
                'filiere' => 'Gestion des ressources humaines',
                'niveau' => 'BTS 1',
                'fichier_nom' => 'cours_grh.pdf',
                'contenu_texte' => "GESTION DES RESSOURCES HUMAINES - IUES/INSAM\n\nChapitre 1 : Introduction a la GRH\n\nLa GRH est l'ensemble des pratiques de gestion visant a mobiliser et developper les ressources humaines pour une plus grande efficacite de l'organisation.\n\nFonctions principales :\n- Recrutement et selection\n- Formation et developpement\n- Gestion des carrieres\n- Remuneration et avantages sociaux\n- Relations sociales\n- Gestion previsionnelle des emplois (GPEC)\n\nChapitre 2 : Le recrutement\n\nEtapes du processus :\n1. Identification du besoin\n2. Definition du poste et du profil\n3. Choix des canaux de recrutement\n4. Reception et tri des candidatures\n5. Entretiens de selection\n6. Decision et integration\n\nTypes de recrutement :\n- Interne : promotion, mutation, reconversion\n- Externe : annonces, cabinets, reseaux sociaux, cooptation\n\nChapitre 3 : La formation\n\nPlan de formation :\n1. Identification des besoins en competences\n2. Definition des objectifs de formation\n3. Choix des methodes (presentiel, e-learning, alternance)\n4. Mise en oeuvre\n5. Evaluation de l'efficacite\n\nChapitre 4 : La remuneration\n\nComposantes de la remuneration :\n- Salaire de base\n- Primes et indemnites\n- Avantages en nature\n- Participation et interessement\n\nAu Cameroun : SMIG = 41 875 FCFA/mois\nCharges sociales : CNPS (cotisations retraite, allocations familiales, risques professionnels)",
            ],
            [
                'titre' => 'Transmission de donnees numeriques',
                'matiere' => 'Telecommunications',
                'filiere' => 'Telecommunication',
                'niveau' => 'BTS 1',
                'fichier_nom' => 'cours_transmission.pdf',
                'contenu_texte' => "TRANSMISSION DE DONNEES NUMERIQUES - IUES/INSAM\n\nChapitre 1 : Principes de base\n\nLa transmission de donnees est le transfert d'information entre un emetteur et un recepteur via un canal de communication.\n\nGrandeurs fondamentales :\n- Debit binaire (bit/s) : nombre de bits transmis par seconde\n- Bande passante (Hz) : plage de frequences du canal\n- Rapport signal/bruit (SNR en dB)\n- Taux d'erreur binaire (BER)\n\nTheoreme de Shannon : C = B * log2(1 + SNR)\nC = capacite maximale du canal, B = bande passante\n\nChapitre 2 : Les supports de transmission\n\nSupports guides :\n- Paire torsadee (telephone, Ethernet)\n- Cable coaxial (television, reseau)\n- Fibre optique (haut debit, longue distance)\n\nSupports non guides (sans fil) :\n- Ondes radio (Wi-Fi, Bluetooth)\n- Micro-ondes (faisceaux hertziens)\n- Infrarouge (telecommandes)\n- Satellite\n\nChapitre 3 : Modulation\n\nLa modulation adapte le signal numerique au canal de transmission.\n\nTypes de modulation :\n- ASK (Amplitude Shift Keying) : variation d'amplitude\n- FSK (Frequency Shift Keying) : variation de frequence\n- PSK (Phase Shift Keying) : variation de phase\n- QAM (Quadrature Amplitude Modulation) : combinaison amplitude/phase\n\nChapitre 4 : Multiplexage\n\nTechniques pour partager un canal entre plusieurs communications :\n- FDM (Frequency Division Multiplexing)\n- TDM (Time Division Multiplexing)\n- CDM (Code Division Multiplexing)\n- WDM (Wavelength Division Multiplexing) pour la fibre optique",
            ],
        ];

        foreach ($knowledgeDocs as $kd) {
            KnowledgeDocument::firstOrCreate(
                ['titre' => $kd['titre']],
                array_merge($kd, ['fichier_path' => 'knowledge/' . $kd['fichier_nom']])
            );
        }

        // ===== QUESTIONS / REPONSES IA (historique chat) =====
        $conversations = [
            ['user_idx' => 0, 'contenu' => 'Explique-moi le principe de la programmation orientee objet', 'reponse' => "La Programmation Orientee Objet (POO) est un paradigme de programmation qui organise le code autour d'\"objets\" plutot que de fonctions. Voici les 4 piliers fondamentaux :\n\n1. **Encapsulation** : Regrouper les donnees (attributs) et les traitements (methodes) au sein d'un meme objet, tout en controlant l'acces avec des modificateurs (public, private, protected).\n\n2. **Heritage** : Permet a une classe enfant d'heriter des attributs et methodes d'une classe parent. Ex: la classe Etudiant peut heriter de la classe Personne.\n\n3. **Polymorphisme** : Une meme methode peut avoir des comportements differents selon l'objet qui l'appelle. Ex: la methode calculerFrais() peut fonctionner differemment pour un EtudiantBTS et un EtudiantLicence.\n\n4. **Abstraction** : Cacher la complexite interne et ne montrer que l'essentiel a l'utilisateur.\n\nEn Java par exemple :\n```java\npublic class Etudiant extends Personne {\n    private String matricule;\n    public void etudier() { ... }\n}\n```"],
            ['user_idx' => 1, 'contenu' => 'Comment fonctionne une jointure SQL ?', 'reponse' => "Une jointure SQL permet de combiner des donnees de plusieurs tables liees entre elles. Voici les types principaux :\n\n**INNER JOIN** (jointure interne) :\nRetourne uniquement les lignes qui ont une correspondance dans les deux tables.\n```sql\nSELECT e.nom, c.intitule \nFROM etudiants e \nINNER JOIN inscriptions i ON e.id = i.etudiant_id\nINNER JOIN cours c ON i.cours_id = c.id;\n```\n\n**LEFT JOIN** :\nRetourne toutes les lignes de la table de gauche, meme sans correspondance a droite (NULL).\n\n**RIGHT JOIN** :\nL'inverse du LEFT JOIN.\n\n**FULL OUTER JOIN** :\nRetourne toutes les lignes des deux tables.\n\nConseil pour les examens a l'INSAM : maitrisez bien INNER JOIN et LEFT JOIN, ce sont les plus frequents dans les epreuves !"],
            ['user_idx' => 2, 'contenu' => 'Quelles sont les couches du modele OSI ?', 'reponse' => "Le modele OSI (Open Systems Interconnection) comporte 7 couches, de la plus basse a la plus haute :\n\n1. **Couche Physique** : Transmission des bits bruts sur le support (cables, signaux electriques)\n2. **Couche Liaison** : Transfert fiable entre noeud adjacents, adressage MAC (Switch)\n3. **Couche Reseau** : Routage et adressage logique IP (Routeur)\n4. **Couche Transport** : Communication bout a bout fiable (TCP/UDP)\n5. **Couche Session** : Gestion des sessions de communication\n6. **Couche Presentation** : Format des donnees, chiffrement, compression\n7. **Couche Application** : Interface avec l'utilisateur (HTTP, FTP, SMTP)\n\nMoyen mnemotechnique : **P**our **L**es **R**eseaux **T**out **S**e **P**asse **A**utomatiquement\n\nA l'examen de Telecom, on vous demandera souvent d'identifier a quelle couche appartient un protocole ou equipement !"],
            ['user_idx' => 3, 'contenu' => 'Quelle est la difference entre FOB et CIF ?', 'reponse' => "FOB et CIF sont deux Incoterms tres utilises dans le commerce maritime :\n\n**FOB (Free On Board)** :\n- Le vendeur livre la marchandise a bord du navire au port d'embarquement\n- Le transfert de risque se fait quand la marchandise est a bord\n- L'acheteur prend en charge : le fret maritime, l'assurance, le dedouanement a l'arrivee\n- Utilise souvent pour les exportations\n\n**CIF (Cost, Insurance and Freight)** :\n- Le vendeur paie le fret ET l'assurance jusqu'au port de destination\n- MAIS le transfert de risque se fait au port d'embarquement (comme FOB !)\n- L'acheteur prend en charge : le dedouanement a l'arrivee, le transport interieur\n- Plus protecteur pour l'acheteur\n\nExemple concret : Un exportateur camerounais vend du cacao a un importateur francais.\n- En FOB Douala : le vendeur livre au port de Douala, l'acheteur organise le transport maritime\n- En CIF Le Havre : le vendeur organise et paie le transport jusqu'au Havre + assurance"],
            ['user_idx' => 5, 'contenu' => 'Comment calculer l\'amortissement lineaire ?', 'reponse' => "L'amortissement lineaire (ou constant) repartit le cout d'une immobilisation de maniere egale sur sa duree de vie.\n\n**Formule :**\nAnnuite = Valeur d'origine / Duree de vie\nTaux = 100% / Duree de vie\n\n**Exemple :**\nL'INSAM achete un ordinateur a 600 000 FCFA, duree de vie 3 ans.\n\nAnnuite = 600 000 / 3 = 200 000 FCFA/an\nTaux = 100% / 3 = 33,33%\n\nTableau d'amortissement :\n| Annee | Base     | Annuite  | Cumul    | VNC      |\n|-------|----------|----------|----------|----------|\n| 1     | 600 000  | 200 000  | 200 000  | 400 000  |\n| 2     | 600 000  | 200 000  | 400 000  | 200 000  |\n| 3     | 600 000  | 200 000  | 600 000  | 0        |\n\nVNC = Valeur Nette Comptable = Valeur d'origine - Cumul des amortissements\n\nEcriture comptable OHADA :\n681 Dotations aux amortissements    200 000\n    2815 Amort. materiel info               200 000"],
            ['user_idx' => 4, 'contenu' => 'Comment reussir une etude de marche ?', 'reponse' => "Voici les etapes cles pour realiser une etude de marche reussie :\n\n**1. Definir le probleme et les objectifs**\n- Quel est le besoin ? (lancer un produit, comprendre un marche...)\n- Questions precises a resoudre\n\n**2. Etude documentaire (secondaire)**\n- Donnees existantes : INS (Cameroun), rapports sectoriels\n- Veille concurrentielle\n\n**3. Etude qualitative**\n- Entretiens individuels (10-15 personnes)\n- Focus groups (6-8 personnes)\n- Observer les comportements\n\n**4. Etude quantitative**\n- Questionnaire aupres d'un echantillon representatif\n- Minimum 100-200 repondants\n- Questions fermees pour faciliter l'analyse\n\n**5. Analyse des donnees**\n- Tris a plat et tris croises\n- Calcul de moyennes, pourcentages\n- Identification des tendances\n\n**6. Recommandations**\n- Synthese des resultats\n- Decisions marketing a prendre\n\nConseil : Pour votre TD a l'INSAM, concentrez-vous sur un marche local camerounais, c'est plus pertinent et plus facile a etudier !"],
        ];

        foreach ($conversations as $conv) {
            $question = Question::create([
                'user_id' => $userIds[$conv['user_idx']],
                'contenu' => $conv['contenu'],
                'created_at' => now()->subDays(rand(1, 30)),
            ]);
            Reponse::create([
                'question_id' => $question->id,
                'contenu' => $conv['reponse'],
            ]);
        }

        // ===== RECOMMANDATIONS =====
        $recoMessages = [
            "Basee sur votre profil en Genie Logiciel (Licence), voici mes recommandations :\n\n1. Maitrisez Laravel et les API REST - c'est une competence tres demandee sur le marche camerounais. Consultez le cours \"Framework Laravel\" disponible dans les ressources.\n\n2. Pratiquez les algorithmes quotidiennement sur des plateformes comme HackerRank ou LeetCode pour renforcer votre logique.\n\n3. Commencez un projet personnel (application web ou mobile) pour enrichir votre portfolio - c'est un atout majeur pour les stages et l'emploi.",

            "En tant qu'etudiant en BTS 2 Genie Logiciel, je vous recommande :\n\n1. Revisez les bases de donnees SQL car c'est un sujet recurrent aux examens. Le TD \"Requetes SQL avancees\" est excellent.\n\n2. Approfondissez la POO Java - le cours et l'epreuve de session 2025 sont disponibles dans les ressources.\n\n3. Familiarisez-vous avec Git/GitHub pour le travail collaboratif - indispensable en entreprise.",

            "Pour votre parcours en Commerce International BTS 2 :\n\n1. Maitrisez parfaitement les 11 Incoterms 2020 - consultez la fiche de revision disponible. C'est un incontournable aux examens.\n\n2. Entrainez-vous avec l'epreuve 2025 de Commerce International pour vous familiariser avec le format.\n\n3. Ameliorez votre anglais des affaires - la ressource \"Business English\" couvre le vocabulaire essentiel du commerce international.",
        ];

        foreach ($recoMessages as $idx => $msg) {
            if (isset($userIds[$idx])) {
                Recommandation::create([
                    'user_id' => $userIds[$idx],
                    'message' => $msg,
                    'created_at' => now()->subDays(rand(1, 15)),
                ]);
            }
        }

        $this->command->info('Donnees de demonstration inserees avec succes !');
        $this->command->info('Comptes de test :');
        $this->command->info('  Admin : admin@insam.cm / admin123');
        $this->command->info('  Etudiante : oceanne.epoh@insam.cm / etudiant123');
    }
}
