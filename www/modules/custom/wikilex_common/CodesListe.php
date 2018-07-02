<?php

namespace Drupal\wikilex_common;

class CodesListe {

  public function getCidTexte($cid) {
    if (isset($this->list[$cid]['cIDTexte'])) {
      return $this->list[$cid]['cIDTexte'];
    }
    else {
      return NULL;
    }
  }

  public function getNomQualifie($cid) {
    if (isset($this->list[$cid]['nom_qualifie'])) {
      return $this->list[$cid]['nom_qualifie'];
    }
    else {
      return NULL;
    }
  }

  public function getNomComplet($cid) {
    if (isset($this->list[$cid]['nom_complet'])) {
      return $this->list[$cid]['nom_complet'];
    }
    else {
      return NULL;
    }
  }

  protected $list = [
      'C_06070666'=>[
        'cIDTexte' => 'LEGITEXT000006070666',
        'nom_qualifie' => 'code_instruments_monetaires_medailes',
        'nom_complet' => 'Code des instruments monétaires et des médailles',
      ],

      'C_06074069' => [
        'cIDTexte' => 'LEGITEXT000006074069',
        'nom_qualifie' => 'code_action_sociale_familles',
        'nom_complet' => 'Code de l\'action sociale et des familles',
      ],

      'C_06075116' => [
        'cIDTexte' => 'LEGITEXT000006075116',
        'nom_qualifie' => 'code_artisanat',
        'nom_complet' => 'Code de l\'artisanat',
      ],

      'code_assurances' => [
        'cIDTexte' => 'LEGITEXT000006073984',
        'nom_qualifie' => 'code_assurances',
        'nom_complet' => 'Code des assurances',
        'code_legiphp' => 'C_06073984',
      ],

      'code_aviation_civile' => [
        'cIDTexte' => 'LEGITEXT000006074234',
        'nom_qualifie' => 'code_aviation_civile',
        'nom_complet' => 'Code de l\'aviation civile',
        'code_legiphp' => 'C_06074234',
      ],

      'code_cinema_image_animee' => [
        'cIDTexte' => 'LEGITEXT000020908868',
        'nom_qualifie' => 'code_cinema_image_animee',
        'nom_complet' => 'Code du cinéma et de l\'image animée',
        'code_legiphp' => 'C_20908868',
      ],

      'code_civil' => [
        'cIDTexte' => 'LEGITEXT000006070721',
        'nom_qualifie' => 'code_civil',
        'nom_complet' => 'Code civil',
        'code_legiphp' => 'C_06070721',
      ],

      'code_commerce' => [
        'cIDTexte' => 'LEGITEXT000005634379',
        'nom_qualifie' => 'code_commerce',
        'nom_complet' => 'Code de commerce',
        'code_legiphp' => 'C_05634379',
      ],

      'code_penal' => [
        'cIDTexte' => 'LEGITEXT000006070719',
        'nom_qualifie' => 'code_penal',
        'nom_complet' => 'Code pénal',
        'code_legiphp' => 'C_06070719',
      ],

      'code_consommation' => [
        'cIDTexte' => 'LEGITEXT000006069565',
        'nom_qualifie' => 'code_consommation',
        'nom_complet' => 'Code de la consommation',
        'code_legiphp' => 'C_06069565',
      ],

      'code_education' => [
        'cIDTexte' => 'LEGITEXT000006071191',
        'nom_qualifie' => 'code_education',
        'nom_complet' => 'Code de l\'éducation',
        'code_legiphp' => 'C_06071191',
      ],

      'code_electoral' => [
        'cIDTexte' => 'LEGITEXT000006070239',
        'nom_qualifie' => 'code_electoral',
        'nom_complet' => 'Code électoral',
        'code_legiphp' => 'C_06070239',
      ],

      'code_travail' => [
        'cIDTexte' => 'LEGITEXT000006072050',
        'nom_qualifie' => 'code_travail',
        'nom_complet' => 'Code du travail',
        'code_legiphp' => 'C_06072050',
      ],

      'code_construction_habitation' => [
        'cIDTexte' => 'LEGITEXT000006074096',
        'nom_qualifie' => 'code_construction_habitation',
        'nom_complet' => 'Code de la construction et de l\'habitation',
        'code_legiphp' => 'C_06074096',
      ],

      'code_defense' => [
        'cIDTexte' => 'LEGITEXT000006071307',
        'nom_qualifie' => 'code_defense',
        'nom_complet' => 'Code de la défense',
        'code_legiphp' => 'C_06071307',
      ],


      'code_domaine_etat' => [
        'cIDTexte' => 'LEGITEXT000006070208',
        'nom_qualifie' => 'code_domaine_etat',
        'nom_complet' => 'Code du domaine de l\'Etat',
        'code_legiphp' => 'C_06070208',
      ],

      'code_famille_aide_sociale' => [
        'cIDTexte' => 'LEGITEXT000006072637',
        'nom_qualifie' => 'code_famille_aide_sociale',
        'nom_complet' => 'Code de la famille et de l\'aide sociale',
        'code_legiphp' => 'C_06072637',
      ],

      'code_sport' => [
        'cIDTexte' => 'LEGITEXT000006071318',
        'nom_qualifie' => 'code_sport',
        'nom_complet' => 'Code du sport',
        'code_legiphp' => 'C_06071318',
      ],

      'code_tourisme' => [
        'cIDTexte' => 'LEGITEXT000006074073',
        'nom_qualifie' => 'code_tourisme',
        'nom_complet' => 'Code du tourisme',
        'code_legiphp' => 'C_06074073',
      ],

      'code_transports' => [
        'cIDTexte' => 'LEGITEXT000023086525',
        'nom_qualifie' => 'code_transports',
        'nom_complet' => 'Code des transports',
        'code_legiphp' => 'C_23086525',
      ],

      'code_sante_publique' => [
        'cIDTexte' => 'LEGITEXT000006072665',
        'nom_qualifie' => 'code_sante_publique',
        'nom_complet' => 'Code de la santé publique',
        'code_legiphp' => 'C_06072665',
      ],

      'code_securite_interieure' => [
        'cIDTexte' => 'LEGITEXT000025503132',
        'nom_qualifie' => 'code_securite_interieure',
        'nom_complet' => 'Code de la sécurité intérieure',
        'code_legiphp' => 'C_25503132',
      ],

      'code_securite_sociale' => [
        'cIDTexte' => 'LEGITEXT000006073189',
        'nom_qualifie' => 'code_securite_sociale',
        'nom_complet' => 'Code de la sécurité sociale',
        'code_legiphp' => 'C_06073189',
      ],
  /*
 
 
 LEGITEXT000006070162	Code des communes 	code_communes 	C_06070162
 LEGITEXT000006070300	Code des communes de la Nouvelle-Calédonie 	code_communes_nouvelle_caledonie 	C_06070300
 LEGITEXT000006074232	Code de déontologie des architectes 	code_deontologie_architectes 	C_06074232
 LEGITEXT000006071188	Code disciplinaire et pénal de la marine marchande 	code_disciplinaire_penal_marine_marchande 	C_06071188
 LEGITEXT000006074235	Code du domaine de l'Etat et des collectivités publiques applicable à la collectivité territoriale de Mayotte 	code_domaine_etat_collectivites_publiques_applicable_collectivite_territoriale_mayotte 	C_06074235
 LEGITEXT000006074237	Code du domaine public fluvial et de la navigation intérieure 	code_domaine_public_fluvial_navigation_interieure 	C_06074237
 LEGITEXT000006071570	Code des douanes 	code_douanes 	C_06071570
 LEGITEXT000006071645	Code des douanes de Mayotte	code_douanes_mayotte	C_06071645
 
 LEGITEXT000023983208	Code de l'énergie 	code_energie 	C_23983208
 LEGITEXT000006070158	Code de l'entrée et du séjour des étrangers et du droit d'asile 	code_entree_sejour_etrangers_du_droit_asile 	C_06070158
 LEGITEXT000006074220	Code de l'environnement	code_environnement	C_06074220
 LEGITEXT000006074224	Code de l'expropriation pour cause d'utilité publique	code_expropriation_pour_cause_utilite_publique	C_06074224
 LEGITEXT000025244092	Code forestier (nouveau) 	code_forestier_(nouveau) 	C_25244092
 LEGITEXT000006070299	Code général de la propriété des personnes publiques	code_general_propriete_personnes_publiques	C_06070299
 LEGITEXT000006070633	Code général des collectivités territoriales 	code_general_collectivites_territoriales 	C_06070633
 LEGITEXT000006069577	Code général des impôts	code_general_impots	C_06069577
 LEGITEXT000006069568	Code général des impôts, annexe 1 	code_general_impots_annexe_1 	C_06069568
 LEGITEXT000006069569	Code général des impôts, annexe 2 	code_general_impots_annexe_2 	C_06069569
 LEGITEXT000006069574	Code général des impôts, annexe 3	code_general_impots_annexe_3	C_06069574
 LEGITEXT000006069576	Code général des impôts, annexe 4 	code_general_impots_annexe_4 	C_06069576
 LEGITEXT000006070666	Code des instruments monétaires et des médailles 	code_instruments_monetaires_medailles 	C_06070666
 LEGITEXT000006070249	Code des juridictions financières 	code_juridictions_financieres 	C_06070249
 LEGITEXT000006070933	Code de justice administrative 	code_justice_administrative 	C_06070933
 LEGITEXT000006071360	Code de justice militaire (nouveau) 	code_justice_militaire_(nouveau) 	C_06071360
 LEGITEXT000006071007	Code de la légion d'honneur et de la médaille militaire 	code_legion_honneur_medaille_militaire 	C_06071007
 LEGITEXT000006069583	Livre des procédures fiscales 	livre_procedures_fiscales 	C_06069583
 LEGITEXT000006071785	Code minier 	code_minier 	C_06071785
 LEGITEXT000023501962	Code minier (nouveau) 	code_minier_(nouveau) 	C_23501962
 LEGITEXT000006072026	Code monétaire et financier	code_monetaire_financier	C_06072026
 LEGITEXT000006074067	Code de la mutualité 	code_mutualite 	C_06074067
 LEGITEXT000006071164	Code de l'organisation judiciaire	code_organisation_judiciaire	C_06071164
 LEGITEXT000006074236	Code du patrimoine 	code_patrimoine 	C_06074236
 LEGITEXT000006070302	Code des pensions civiles et militaires de retraite 	code_pensions_civiles_militaires_retraite 	C_06070302
 LEGITEXT000006074066	Code des pensions de retraite des marins français du commerce, de pêche ou de plaisance	code_pensions_retraite_marins_français_commerce_peche_ou_plaisance	C_06074066
 LEGITEXT000006074068	Code des pensions militaires d'invalidité et des victimes de guerre 	code_pensions_militaires_invalidite_victimes_guerre 	C_06074068
 LEGITEXT000006074233	Code des ports maritimes 	code_ports_maritimes 	C_06074233
 LEGITEXT000006070987	Code des postes et des communications électroniques 	code_postes_communications_electroniques 	C_06070987
 LEGITEXT000006070716	Code de procédure civile 	code_procedure_civile 	C_06070716
 LEGITEXT000006071154	Code de procédure pénale 	code_procedure_penale 	C_06071154
 LEGITEXT000025024948	Code des procédures civiles d'exécution 	code_procedures_civiles_execution 	C_25024948
 LEGITEXT000006069414	Code de la propriété intellectuelle 	code_propriete_intellectuelle 	C_06069414
 LEGITEXT000006071190	Code de la recherche 	code_recherche 	C_06071190
 LEGITEXT000031366350	Code des relations entre le public et l'administration	code_relations_public_administration	C_31366350
 LEGITEXT000006074228	Code de la route 	code_route 	C_06074228
 LEGITEXT000006071366	Code rural (ancien) 	code_rural_(ancien) 	C_06071366
 LEGITEXT000006071367	Code rural et de la pêche maritime 	code_rural_peche_maritime 	C_06071367
 LEGITEXT000006071335	Code du service national 	code_service_national 	C_06071335
 LEGITEXT000006072052	Code du travail applicable à Mayotte	code_travail_applicable_mayotte	C_06072052
 LEGITEXT000006072051	Code du travail maritime 	code_travail_maritime 	C_06072051
 LEGITEXT000006074075	Code de l'urbanisme 	code_urbanisme 	C_06074075
 LEGITEXT000006070667	Code de la voirie routière 	code_voirie_routiere 	C_06070667
 */
  ];
}