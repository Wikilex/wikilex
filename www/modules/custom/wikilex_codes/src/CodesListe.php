<?php

namespace Drupal\wikilex_codes;

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

    'C_06074069' => [	'cIDTexte' => 'LEGITEXT000006074069'	, 'nom_qualifie' => 'code_action_sociale_familles',	'nom_complet' => 'Code de l\'action sociale et des familles', ],
    'C_06075116' => [	'cIDTexte' => 'LEGITEXT000006075116'	, 'nom_qualifie' => 'code_artisanat',	'nom_complet' => 'Code de l\'artisanat', ],
    'C_06073984' => [	'cIDTexte' => 'LEGITEXT000006073984'	, 'nom_qualifie' => 'code_assurances',	'nom_complet' => 'Code des assurances', ],
    'C_06074234' => [	'cIDTexte' => 'LEGITEXT000006074234'	, 'nom_qualifie' => 'code_aviation_civile',	'nom_complet' => 'Code de l\'aviation civile', ],
    'C_20908868' => [	'cIDTexte' => 'LEGITEXT000020908868'	, 'nom_qualifie' => 'code_cinema_image_animee',	'nom_complet' => 'Code du cinéma et de l\'image animée', ],
    'C_06070721' => [	'cIDTexte' => 'LEGITEXT000006070721'	, 'nom_qualifie' => 'code_civil',	'nom_complet' => 'Code civil', ],
    'C_05634379' => [	'cIDTexte' => 'LEGITEXT000005634379'	, 'nom_qualifie' => 'code_commerce',	'nom_complet' => 'Code de commerce', ],
    'C_06070162' => [	'cIDTexte' => 'LEGITEXT000006070162'	, 'nom_qualifie' => 'code_communes',	'nom_complet' => 'Code des communes', ],
    'C_06070300' => [	'cIDTexte' => 'LEGITEXT000006070300'	, 'nom_qualifie' => 'code_communes_nouvelle_caledonie',	'nom_complet' => 'Code des communes de la Nouvelle-Calédonie', ],
    'C_06069565' => [	'cIDTexte' => 'LEGITEXT000006069565'	, 'nom_qualifie' => 'code_consommation',	'nom_complet' => 'Code de la consommation', ],
    'C_06074096' => [	'cIDTexte' => 'LEGITEXT000006074096'	, 'nom_qualifie' => 'code_construction_habitation',	'nom_complet' => 'Code de la construction et de l\'habitation', ],
    'C_06071307' => [	'cIDTexte' => 'LEGITEXT000006071307'	, 'nom_qualifie' => 'code_defense',	'nom_complet' => 'Code de la défense', ],
    'C_06074232' => [	'cIDTexte' => 'LEGITEXT000006074232'	, 'nom_qualifie' => 'code_deontologie_architectes',	'nom_complet' => 'Code de déontologie des architectes', ],
    'C_06071188' => [	'cIDTexte' => 'LEGITEXT000006071188'	, 'nom_qualifie' => 'code_disciplinaire_penal_marine_marchande',	'nom_complet' => 'Code disciplinaire et pénal de la marine marchande', ],
    'C_06070208' => [	'cIDTexte' => 'LEGITEXT000006070208'	, 'nom_qualifie' => 'code_domaine_etat',	'nom_complet' => 'Code du domaine de l\'Etat', ],
    'C_06074235' => [	'cIDTexte' => 'LEGITEXT000006074235'	, 'nom_qualifie' => 'code_domaine_etat_collectivites_publiques_applicable_collectivite_territoriale_mayotte',	'nom_complet' => 'Code du domaine de l\'Etat et des collectivités publiques applicable à la collectivité territoriale de Mayotte', ],
    'C_06074237' => [	'cIDTexte' => 'LEGITEXT000006074237'	, 'nom_qualifie' => 'code_domaine_public_fluvial_navigation_interieure',	'nom_complet' => 'Code du domaine public fluvial et de la navigation intérieure', ],
    'C_06071570' => [	'cIDTexte' => 'LEGITEXT000006071570'	, 'nom_qualifie' => 'code_douanes',	'nom_complet' => 'Code des douanes', ],
    'C_06071645' => [	'cIDTexte' => 'LEGITEXT000006071645'	, 'nom_qualifie' => 'code_douanes_mayotte',	'nom_complet' => 'Code des douanes de Mayotte', ],
    'C_06071191' => [	'cIDTexte' => 'LEGITEXT000006071191'	, 'nom_qualifie' => 'code_education',	'nom_complet' => 'Code de l\'éducation', ],
    'C_06070239' => [	'cIDTexte' => 'LEGITEXT000006070239'	, 'nom_qualifie' => 'code_electoral',	'nom_complet' => 'Code électoral', ],
    'C_23983208' => [	'cIDTexte' => 'LEGITEXT000023983208'	, 'nom_qualifie' => 'code_energie',	'nom_complet' => 'Code de l\'énergie', ],
    'C_06070158' => [	'cIDTexte' => 'LEGITEXT000006070158'	, 'nom_qualifie' => 'code_entree_sejour_etrangers_du_droit_asile',	'nom_complet' => 'Code de l\'entrée et du séjour des étrangers et du droit d\'asile', ],
    'C_06074220' => [	'cIDTexte' => 'LEGITEXT000006074220'	, 'nom_qualifie' => 'code_environnement',	'nom_complet' => 'Code de l\'environnement', ],
    'C_06074224' => [	'cIDTexte' => 'LEGITEXT000006074224'	, 'nom_qualifie' => 'code_expropriation_pour_cause_utilite_publique',	'nom_complet' => 'Code de l\'expropriation pour cause d\'utilité publique', ],
    'C_06072637' => [	'cIDTexte' => 'LEGITEXT000006072637'	, 'nom_qualifie' => 'code_famille_aide_sociale',	'nom_complet' => 'Code de la famille et de l\'aide sociale', ],
    'C_25244092' => [	'cIDTexte' => 'LEGITEXT000025244092'	, 'nom_qualifie' => 'code_forestier_(nouveau)',	'nom_complet' => 'Code forestier (nouveau)', ],
    'C_06070299' => [	'cIDTexte' => 'LEGITEXT000006070299'	, 'nom_qualifie' => 'code_general_propriete_personnes_publiques',	'nom_complet' => 'Code général de la propriété des personnes publiques', ],
    'C_06070633' => [	'cIDTexte' => 'LEGITEXT000006070633'	, 'nom_qualifie' => 'code_general_collectivites_territoriales',	'nom_complet' => 'Code général des collectivités territoriales', ],
    'C_06069577' => [	'cIDTexte' => 'LEGITEXT000006069577'	, 'nom_qualifie' => 'code_general_impots',	'nom_complet' => 'Code général des impôts', ],
    'C_06069568' => [	'cIDTexte' => 'LEGITEXT000006069568'	, 'nom_qualifie' => 'code_general_impots_annexe_1',	'nom_complet' => 'Code général des impôts, annexe 1', ],
    'C_06069569' => [	'cIDTexte' => 'LEGITEXT000006069569'	, 'nom_qualifie' => 'code_general_impots_annexe_2',	'nom_complet' => 'Code général des impôts, annexe 2', ],
    'C_06069574' => [	'cIDTexte' => 'LEGITEXT000006069574'	, 'nom_qualifie' => 'code_general_impots_annexe_3',	'nom_complet' => 'Code général des impôts, annexe 3', ],
    'C_06069576' => [	'cIDTexte' => 'LEGITEXT000006069576'	, 'nom_qualifie' => 'code_general_impots_annexe_4',	'nom_complet' => 'Code général des impôts, annexe 4', ],
    'C_06070666' => [	'cIDTexte' => 'LEGITEXT000006070666'	, 'nom_qualifie' => 'code_instruments_monetaires_medailles',	'nom_complet' => 'Code des instruments monétaires et des médailles', ],
    'C_06070249' => [	'cIDTexte' => 'LEGITEXT000006070249'	, 'nom_qualifie' => 'code_juridictions_financieres',	'nom_complet' => 'Code des juridictions financières', ],
    'C_06070933' => [	'cIDTexte' => 'LEGITEXT000006070933'	, 'nom_qualifie' => 'code_justice_administrative',	'nom_complet' => 'Code de justice administrative', ],
    'C_06071360' => [	'cIDTexte' => 'LEGITEXT000006071360'	, 'nom_qualifie' => 'code_justice_militaire_(nouveau)',	'nom_complet' => 'Code de justice militaire (nouveau)', ],
    'C_06071007' => [	'cIDTexte' => 'LEGITEXT000006071007'	, 'nom_qualifie' => 'code_legion_honneur_medaille_militaire',	'nom_complet' => 'Code de la légion d\'honneur et de la médaille militaire', ],
    'C_06069583' => [	'cIDTexte' => 'LEGITEXT000006069583'	, 'nom_qualifie' => 'livre_procedures_fiscales',	'nom_complet' => 'Livre des procédures fiscales', ],
    'C_06071785' => [	'cIDTexte' => 'LEGITEXT000006071785'	, 'nom_qualifie' => 'code_minier',	'nom_complet' => 'Code minier', ],
    'C_23501962' => [	'cIDTexte' => 'LEGITEXT000023501962'	, 'nom_qualifie' => 'code_minier_(nouveau)',	'nom_complet' => 'Code minier (nouveau)', ],
    'C_06072026' => [	'cIDTexte' => 'LEGITEXT000006072026'	, 'nom_qualifie' => 'code_monetaire_financier',	'nom_complet' => 'Code monétaire et financier', ],
    'C_06074067' => [	'cIDTexte' => 'LEGITEXT000006074067'	, 'nom_qualifie' => 'code_mutualite',	'nom_complet' => 'Code de la mutualité', ],
    'C_06071164' => [	'cIDTexte' => 'LEGITEXT000006071164'	, 'nom_qualifie' => 'code_organisation_judiciaire',	'nom_complet' => 'Code de l\'organisation judiciaire', ],
    'C_06074236' => [	'cIDTexte' => 'LEGITEXT000006074236'	, 'nom_qualifie' => 'code_patrimoine',	'nom_complet' => 'Code du patrimoine', ],
    'C_06070719' => [	'cIDTexte' => 'LEGITEXT000006070719'	, 'nom_qualifie' => 'code_penal',	'nom_complet' => 'Code pénal', ],
    'C_06070302' => [	'cIDTexte' => 'LEGITEXT000006070302'	, 'nom_qualifie' => 'code_pensions_civiles_militaires_retraite',	'nom_complet' => 'Code des pensions civiles et militaires de retraite', ],
    'C_06074066' => [	'cIDTexte' => 'LEGITEXT000006074066'	, 'nom_qualifie' => 'code_pensions_retraite_marins_français_commerce_peche_ou_plaisance',	'nom_complet' => 'Code des pensions de retraite des marins français du commerce, de pêche ou de plaisance', ],
    'C_06074068' => [	'cIDTexte' => 'LEGITEXT000006074068'	, 'nom_qualifie' => 'code_pensions_militaires_invalidite_victimes_guerre',	'nom_complet' => 'Code des pensions militaires d\'invalidité et des victimes de guerre', ],
    'C_06074233' => [	'cIDTexte' => 'LEGITEXT000006074233'	, 'nom_qualifie' => 'code_ports_maritimes',	'nom_complet' => 'Code des ports maritimes', ],
    'C_06070987' => [	'cIDTexte' => 'LEGITEXT000006070987'	, 'nom_qualifie' => 'code_postes_communications_electroniques',	'nom_complet' => 'Code des postes et des communications électroniques', ],
    'C_06070716' => [	'cIDTexte' => 'LEGITEXT000006070716'	, 'nom_qualifie' => 'code_procedure_civile',	'nom_complet' => 'Code de procédure civile', ],
    'C_06071154' => [	'cIDTexte' => 'LEGITEXT000006071154'	, 'nom_qualifie' => 'code_procedure_penale',	'nom_complet' => 'Code de procédure pénale', ],
    'C_25024948' => [	'cIDTexte' => 'LEGITEXT000025024948'	, 'nom_qualifie' => 'code_procedures_civiles_execution',	'nom_complet' => 'Code des procédures civiles d\'exécution', ],
    'C_06069414' => [	'cIDTexte' => 'LEGITEXT000006069414'	, 'nom_qualifie' => 'code_propriete_intellectuelle',	'nom_complet' => 'Code de la propriété intellectuelle', ],
    'C_06071190' => [	'cIDTexte' => 'LEGITEXT000006071190'	, 'nom_qualifie' => 'code_recherche',	'nom_complet' => 'Code de la recherche', ],
    'C_31366350' => [	'cIDTexte' => 'LEGITEXT000031366350'	, 'nom_qualifie' => 'code_relations_public_administration',	'nom_complet' => 'Code des relations entre le public et l\'administration', ],
    'C_06074228' => [	'cIDTexte' => 'LEGITEXT000006074228'	, 'nom_qualifie' => 'code_route',	'nom_complet' => 'Code de la route', ],
    'C_06071366' => [	'cIDTexte' => 'LEGITEXT000006071366'	, 'nom_qualifie' => 'code_rural_(ancien)',	'nom_complet' => 'Code rural (ancien)', ],
    'C_06071367' => [	'cIDTexte' => 'LEGITEXT000006071367'	, 'nom_qualifie' => 'code_rural_peche_maritime',	'nom_complet' => 'Code rural et de la pêche maritime', ],
    'C_06072665' => [	'cIDTexte' => 'LEGITEXT000006072665'	, 'nom_qualifie' => 'code_sante_publique',	'nom_complet' => 'Code de la santé publique', ],
    'C_25503132' => [	'cIDTexte' => 'LEGITEXT000025503132'	, 'nom_qualifie' => 'code_securite_interieure',	'nom_complet' => 'Code de la sécurité intérieure', ],
    'C_06073189' => [	'cIDTexte' => 'LEGITEXT000006073189'	, 'nom_qualifie' => 'code_securite_sociale',	'nom_complet' => 'Code de la sécurité sociale', ],
    'C_06071335' => [	'cIDTexte' => 'LEGITEXT000006071335'	, 'nom_qualifie' => 'code_service_national',	'nom_complet' => 'Code du service national', ],
    'C_06071318' => [	'cIDTexte' => 'LEGITEXT000006071318'	, 'nom_qualifie' => 'code_sport',	'nom_complet' => 'Code du sport', ],
    'C_06074073' => [	'cIDTexte' => 'LEGITEXT000006074073'	, 'nom_qualifie' => 'code_tourisme',	'nom_complet' => 'Code du tourisme', ],
    'C_23086525' => [	'cIDTexte' => 'LEGITEXT000023086525'	, 'nom_qualifie' => 'code_transports',	'nom_complet' => 'Code des transports', ],
    'C_06072050' => [	'cIDTexte' => 'LEGITEXT000006072050'	, 'nom_qualifie' => 'code_travail',	'nom_complet' => 'Code du travail', ],
    'C_06072052' => [	'cIDTexte' => 'LEGITEXT000006072052'	, 'nom_qualifie' => 'code_travail_applicable_mayotte',	'nom_complet' => 'Code du travail applicable à Mayotte', ],
    'C_06072051' => [	'cIDTexte' => 'LEGITEXT000006072051'	, 'nom_qualifie' => 'code_travail_maritime',	'nom_complet' => 'Code du travail maritime', ],
    'C_06074075' => [	'cIDTexte' => 'LEGITEXT000006074075'	, 'nom_qualifie' => 'code_urbanisme',	'nom_complet' => 'Code de l\'urbanisme', ],
    'C_06070667' => [	'cIDTexte' => 'LEGITEXT000006070667'	, 'nom_qualifie' => 'code_voirie_routiere',	'nom_complet' => 'Code de la voirie routière', ],
    ];
}