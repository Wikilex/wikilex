<?php

namespace Drupal\wikilex_hook_book;

use Drupal\book\BookOutlineStorageInterface;
use Drupal\Core\Cache\Cache;
use Drupal\node\Entity\Node;

class CleanOutlines  {

  /**
   * Book outline storage.
   *
   * @var \Drupal\book\BookOutlineStorageInterface
   */
  protected $bookOutlineStorage;

  /**
   * {@inheritdoc}
   */
  public function __construct(BookOutlineStorageInterface $book_outline_storage) {
    $this->bookOutlineStorage = $book_outline_storage;
  }

  /**
   * Fonction pour netoyer l'arborescende d'un code de loi.
   *
   * @param int $bid
   *   Le nid du book.
   */
  public function cleanBookOutline($bid) {
    /** @var \Drupal\Core\Database\Statement $book_menu_tree */
   $book_menu_tree = $this->bookOutlineStorage->getBookMenuTree($bid, [], 1, 9);
    // Build an ordered array of links using the query result object.
    $links = [];
    $pids = [];
    foreach ($book_menu_tree as $key => $link) {
      $link = (array) $link;
      $links[$link['nid']] = $link;
      $pids[$link['nid']] = $link['pid'];
    }
    foreach ($links as $nid => $link) {
      $node = Node::load($nid);
      $links[$nid]['type'] = $node->bundle();
      $links[$nid]['title'] = $node->getTitle();
    }

    foreach ($links as $nid => $link) {
      if ($link['type'] == 'section' || $link['type'] == 'code_de_lois' ) {
        // On recherche les enfants de cette entrée.
        $childrens = [];
        foreach ($pids as $nid_pid => $pid) {
          if ($pid == $nid) {
            //kint('pid : ' . $pid, 'nid_pid : ' . $nid_pid);
            $childrens[$nid_pid] = $links[$nid_pid];
          }
        }
        if (empty($childrens)) {
          // On retire les outlines sections sans enfants (sans articles donc).
          unset($links[$nid]);
        }
        else {
          $links[$nid]['has_children'] = 1;
          // On trie les enfants de la section par ordre ASC des titres.
          $childrens_titles = [];
          foreach ($childrens as $key_children => $children) {
            $childrens_titles[$key_children] = $children['title'];
          }
          array_multisort($childrens_titles, SORT_ASC, $childrens);
          foreach ($childrens as $weight => $children) {
            // On place la weight dans le tableau des liens.
            $links[$children['nid']]['weight'] = $weight;
          }
        }
      }

    }

    // Unset les columns rajoutées.
    // Sauveguarder la nouvelle outline.
    foreach ($links as $nid => $link) {
      unset($link['type']);
      unset($link['title']);
      $this->bookOutlineStorage->update($nid, $link);
    }

    $cache_tags[] = 'bid:' . $bid;
    Cache::invalidateTags($cache_tags);
  }

}